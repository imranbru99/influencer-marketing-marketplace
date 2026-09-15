<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\GatewayCurrency;
use App\Models\Hiring;
use App\Models\HiringConversation;
use App\Models\Influencer;
use App\Models\Transaction;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HiringController extends Controller
{

    public function hiring($name, $id)
    {
        $pageTitle  = 'Hiring Request';
        $influencer = Influencer::active()->where('id', $id)->where('username', $name)->firstOrFail();
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();
        return view($this->activeTemplate . 'user.hiring.request', compact('pageTitle', 'influencer', 'gatewayCurrency'));
    }

    public function hiringInfluencer(Request $request, $influencerId = 0)
    {
        $influencer = Influencer::active()->findOrFail($influencerId);
        $this->validation($request);
        $user = auth()->user();

        if ($request->payment_type == 1 && $request->amount > $user->balance) {
            $notify[] = ['error', 'You have no sufficient balance'];
            return back()->withNotify($notify)->withInput();
        }

        $paymentStatus = $request->payment_type == 1 ? 1 : 0;

        $hiring = $this->saveHiringData($influencer, $request, $paymentStatus);

        if ($request->payment_type == 1) {
            $this->payViaWallet($hiring);
        } else {
            session()->put('payment_data', [
                'hiring_id' => $hiring->id,
                'amount' => $hiring->amount,
            ]);

            return redirect()->route('user.payment');
        }

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $user->id;
        $adminNotification->title     = 'A new hiring requested by ' . $user->username;
        $adminNotification->click_url = urlPath('admin.hiring.detail', $hiring->id);
        $adminNotification->save();
        $general = gs();

        notify($influencer, 'HIRING_PENDING', [
            'username'      => $user->username,
            'title'         => $hiring->title,
            'site_currency' => $general->cur_text,
            'amount'        => showAmount($hiring->amount),
            'hiring_no'     => $hiring->hiring_no,
        ]);

        $notify[] = ['success', 'Hiring request submitted successfully'];
        return to_route('user.hiring.history')->withNotify($notify);
    }

    protected function validation($request)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'delivery_date' => 'required|date_format:Y-m-d|after:yesterday',
            'amount'        => 'required|numeric|gt:0',
            'description'   => 'required|string',
            'payment_type'  => 'required|in:1,2',
        ]);
    }


    protected function saveHiringData($influencer, $request, $paymentStatus)
    {
        $user = auth()->user();
        $hiring                 = new Hiring();
        $hiring->user_id        = $user->id;
        $hiring->influencer_id  = $influencer->id;
        $hiring->title          = $request->title;
        $hiring->delivery_date  = $request->delivery_date;
        $hiring->amount         = $request->amount;
        $hiring->description    = $request->description;
        $hiring->payment_status = $paymentStatus;
        $hiring->hiring_no      = getTrx();
        $hiring->save();
        return $hiring;
    }

    protected function payViaWallet($hiring)
    {
        $user = auth()->user();
        $user->balance -= $hiring->amount;
        $user->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->amount       = $hiring->amount;
        $transaction->post_balance = $user->balance;
        $transaction->trx_type     = '-';
        $transaction->trx          = getTrx();
        $transaction->details      = 'Deducted for hiring expense';
        $transaction->remark       = 'hiring_payment';
        $transaction->save();
    }



    public function detail($id)
    {
        $pageTitle = 'Hiring Detail';
        $hiring    = Hiring::where('user_id', auth()->id())->with('influencer')->findOrFail($id);
        return view($this->activeTemplate . 'user.hiring.detail', compact('pageTitle', 'hiring'));
    }

    public function all(Request $request)
    {

        $pageTitle = 'All Hiring';
        $hirings   = Hiring::where('user_id', auth()->id())->paymentCompleted();

        if ($request->search) {
            $search  = $request->search;
            $hirings = $hirings->where(function ($q) use ($search) {
                $q->where('hiring_no', $search)->orWhereHas('influencer', function ($query) use ($search) {
                    $query->where('username', $search);
                });
            });
        }

        $hirings = $hirings->with('influencer', 'review')->latest()->paginate(getPaginate());
        return view($this->activeTemplate . 'user.hiring.history', compact('pageTitle', 'hirings'));
    }

    public function completeStatus($id)
    {
        $user           = auth()->user();
        $hiring         = Hiring::JobDone()->where('id', $id)->where('user_id', $user->id)->with('influencer')->firstOrFail();
        $hiring->status = 1;
        $hiring->save();

        $influencer = $hiring->influencer;
        $general    = gs();

        $influencer->balance += $hiring->amount;
        $influencer->increment('completed_order');
        $influencer->save();

        $transaction                = new Transaction();
        $transaction->influencer_id = $influencer->id;
        $transaction->amount        = $hiring->amount;
        $transaction->post_balance  = $influencer->balance;
        $transaction->trx_type      = '+';
        $transaction->details       = 'Payment received for completing a new hiring task';
        $transaction->trx           = getTrx();
        $transaction->remark        = 'hiring_payment';
        $transaction->save();

        notify($influencer, 'HIRING_COMPLETED_INFLUENCER', [
            'site_currency' => $general->cur_text,
            'amount'        => showAmount($hiring->amount),
            'hiring_no'     => $hiring->hiring_no,
            'title'         => $hiring->title,
        ]);

        $notify[] = ['success', 'Hiring completed successfully'];
        return back()->withNotify($notify);
    }

    public function reportStatus(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string',
        ]);

        $user           = auth()->user();
        $hiring         = Hiring::JobDone()->where('id', $id)->where('user_id', $user->id)->with('influencer')->firstOrFail();
        $hiring->status = 4;
        $hiring->reason = $request->reason;
        $hiring->save();

        $influencer = $hiring->influencer;
        $general    = gs();

        notify($influencer, 'HIRING_REPORTED', [
            'username'      => $user->username,
            'site_currency' => $general->cur_text,
            'amount'        => showAmount($hiring->amount),
            'hiring_no'     => $hiring->hiring_no,
            'title'         => $hiring->title,
            'reason'        => $hiring->reason,
        ]);

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $user->id;
        $adminNotification->title     = 'This hiring is reported by ' . $user->username;
        $adminNotification->click_url = urlPath('admin.hiring.detail', $hiring->id);
        $adminNotification->save();

        $notify[] = ['success', 'Hiring request has been reported.'];
        return back()->withNotify($notify);
    }

    public function conversation($id)
    {
        $pageTitle           = 'Conversation';
        $hiring              = Hiring::where('user_id', auth()->id())->with('hiringMessage')->findOrFail($id);
        $influencer          = Influencer::where('id', $hiring->influencer_id)->first();
        $conversationMessage = $hiring->hiringMessage->take(10);
        return view($this->activeTemplate . 'user.hiring.conversation', compact('pageTitle', 'conversationMessage', 'influencer', 'hiring'));
    }

    public function conversationStore(Request $request, $id)
    {
        $hiring = Hiring::where('user_id', auth()->id())->find($id);

        if (!$hiring) {
            return response()->json(['error' => 'Hiring id not found.']);
        }

        $validator = Validator::make($request->all(), [
            'message'       => 'required',
            'attachments'   => 'nullable|array',
            'attachments.*' => ['required', new FileTypeValidate(['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx', 'txt'])],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $influencer = Influencer::active()->where('id', $hiring->influencer_id)->first();

        if (!$influencer) {
            return response()->json(['error' => 'Influencer is banned from admin.']);
        }

        $message                = new HiringConversation();
        $message->hiring_id     = $hiring->id;
        $message->user_id       = auth()->id();
        $message->influencer_id = $influencer->id;
        $message->sender        = 'client';
        $message->message       = $request->message;

        if ($request->hasFile('attachments')) {

            foreach ($request->file('attachments') as $file) {
                try {
                    $arrFile[] = fileUploader($file, getFilePath('conversation'));
                } catch (\Exception $exp) {
                    return response()->json(['error' => 'Couldn\'t upload your image']);
                }
            }

            $message->attachments = json_encode($arrFile);
        }

        $message->save();

        return view($this->activeTemplate . 'user.conversation.last_message', compact('message'));
    }

    public function conversationMessage(Request $request)
    {
        $conversationMessage = HiringConversation::where('hiring_id', $request->hiring_id)->take($request->messageCount)->latest()->get();
        return view($this->activeTemplate . 'user.conversation.message', compact('conversationMessage'));
    }
}
