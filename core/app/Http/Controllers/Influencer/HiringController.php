<?php

namespace App\Http\Controllers\Influencer;

use App\Http\Controllers\Controller;
use App\Models\Hiring;
use App\Models\HiringConversation;
use App\Models\Transaction;
use App\Models\User;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HiringController extends Controller {
    public function index() {
        $this->pageTitle = 'All Hiring';
        return $this->filterHiring();
    }

    public function pending() {
        $this->pageTitle = 'Pending Hiring';
        return $this->filterHiring('pending');
    }

    public function inprogress() {
        $this->pageTitle = 'Processing Hiring';
        return $this->filterHiring('inprogress');
    }

    public function jobDone() {
        $this->pageTitle = 'Job Done Hiring';
        return $this->filterHiring('JobDone');
    }

    public function completed() {
        $this->pageTitle = 'Completed Hiring';
        return $this->filterHiring('completed');
    }

    public function reported() {
        $this->pageTitle = 'Reported Hiring';
        return $this->filterHiring('reported');
    }

    public function cancelled() {
        $this->pageTitle = 'Cancelled Hiring';
        return $this->filterHiring('cancelled');
    }

    protected function filterHiring($scope = null) {
        $influencerId = authInfluencerId();
        $hirings      = Hiring::query();

        if ($scope) {
            $hirings = $hirings->$scope();
        }

        $request = request();

        if ($request->search) {
            $search  = request()->search;
            $hirings = $hirings->where(function ($q) use ($search) {
                $q->where('hiring_no', $search)->orWhereHas('user', function ($query) use ($search) {
                    $query->where('username', $search);
                });
            });
        }

        $hirings = $hirings->where('influencer_id', $influencerId)->with('user')->latest()->paginate(getPaginate());

        $pageTitle = $this->pageTitle;

        $pendingHiring = Hiring::pending()->where('influencer_id', $influencerId)->count();

        return view($this->activeTemplate . 'influencer.hiring.list', compact('pageTitle', 'hirings', 'pendingHiring'));
    }

    public function detail($id) {
        $pageTitle = 'Hiring Detail';
        $hiring    = Hiring::where('influencer_id', authInfluencerId())->with('user.orderCompleted','review')->findOrFail($id);
        return view($this->activeTemplate . 'influencer.hiring.detail', compact('pageTitle', 'hiring'));
    }

    public function acceptStatus($id) {
        $influencer     = authInfluencer();
        $hiring         = Hiring::pending()->where('id', $id)->where('influencer_id', $influencer->id)->with('user')->firstOrFail();
        $hiring->status = 2;
        $hiring->save();

        $user    = $hiring->user;
        $general = gs();
        notify($user, 'HIRING_INPROGRESS', [
            'influencer'    => $influencer->username,
            'site_currency' => $general->cur_text,
            'amount'        => showAmount($hiring->amount),
            'hiring_no'     => $hiring->hiring_no,
            'title'         => $hiring->title,
        ]);
        $notify[] = ['success', 'Hiring status has now inprogress'];
        return back()->withNotify($notify);
    }

    public function jobDoneStatus($id) {
        $influencer     = authInfluencer();
        $hiring         = Hiring::inprogress()->where('id', $id)->where('influencer_id', $influencer->id)->with('user')->firstOrFail();
        $hiring->status = 3;
        $hiring->save();

        $user    = $hiring->user;
        $general = gs();
        notify($user, 'JOB_DONE_SUCCESSFULLY', [
            'influencer'    => $influencer->username,
            'site_currency' => $general->cur_text,
            'amount'        => showAmount($hiring->amount),
            'hiring_no'     => $hiring->hiring_no,
            'title'         => $hiring->title,
        ]);
        $notify[] = ['success', 'Job has been done successfully'];
        return back()->withNotify($notify);
    }

    public function cancelStatus($id) {
        $influencer     = authInfluencer();
        $hiring         = Hiring::where('id', $id)->where('influencer_id', $influencer->id)->with('user')->firstOrFail();
        $hiring->status = 5;
        $hiring->save();

        $user    = $hiring->user;
        $general = gs();

        $user->balance += $hiring->amount;
        $user->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->amount       = $hiring->amount;
        $transaction->post_balance = $user->balance;
        $transaction->trx_type     = '+';
        $transaction->details      = showAmount($hiring->amount) . $general->cur_text . ' payment refunded for hiring cancellation';
        $transaction->trx          = getTrx();
        $transaction->remark       = 'hiring_payment';
        $transaction->save();

        notify($user, 'HIRING_CANCELLED', [
            'influencer'    => $influencer->username,
            'site_currency' => $general->cur_text,
            'amount'        => showAmount($hiring->amount),
            'post_balance'  => showAmount($user->balance),
            'hiring_no'     => $hiring->hiring_no,
            'title'         => $hiring->title,
        ]);
        $notify[] = ['success', 'Hiring has been cancelled successfully'];
        return back()->withNotify($notify);
    }

    public function conversation($id) {
        $pageTitle           = 'Conversation View';
        $hiring              = Hiring::where('influencer_id', authInfluencerId())->with('hiringMessage')->findOrFail($id);
        $user                = User::where('id', $hiring->user_id)->first();
        $conversationMessage = $hiring->hiringMessage->take(10);
        return view($this->activeTemplate . 'influencer.hiring.conversation', compact('pageTitle', 'conversationMessage', 'user', 'hiring'));
    }

    public function conversationStore(Request $request, $id) {
        $hiring = Hiring::where('influencer_id', authInfluencerId())->find($id);

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

        $user = User::active()->find($hiring->user_id);

        if (!$user) {
            return response()->json(['error' => 'Influencer is banned from admin.']);
        }

        $message                = new HiringConversation();
        $message->hiring_id     = $hiring->id;
        $message->user_id       = $user->id;
        $message->influencer_id = authInfluencerId();
        $message->sender        = 'influencer';
        $message->message       = $request->message;

        if ($request->hasFile('attachments')) {

            foreach ($request->file('attachments') as $file) {
                try {
                    $arrFile[] = fileUploader($file, getFilePath('conversation'));
                } catch (\Exception$exp) {
                    return response()->json(['error' => 'Couldn\'t upload your image']);
                }

            }

            $message->attachments = json_encode($arrFile);
        }

        $message->save();
        return view($this->activeTemplate . 'user.conversation.last_message', compact('message'));
    }

    public function conversationMessage(Request $request) {
        $conversationMessage = HiringConversation::where('hiring_id', $request->hiring_id)->take($request->messageCount)->latest()->get();
        return view($this->activeTemplate . 'influencer.conversation.message', compact('conversationMessage'));
    }

}
