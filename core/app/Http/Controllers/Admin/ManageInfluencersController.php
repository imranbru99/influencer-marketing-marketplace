<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hiring;
use App\Models\Influencer;
use App\Models\NotificationLog;
use App\Models\Order;
use App\Models\Review;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ManageInfluencersController extends Controller
{

    public function allInfluencers()
    {
        $pageTitle   = 'All Influencers';
        $influencers = $this->influencerData();
        return view('admin.influencers.list', compact('pageTitle', 'influencers'));
    }

    public function activeInfluencers()
    {
        $pageTitle   = 'Active Influencers';
        $influencers = $this->influencerData('active');
        return view('admin.influencers.list', compact('pageTitle', 'influencers'));
    }

    public function bannedInfluencers()
    {
        $pageTitle   = 'Banned Influencers';
        $influencers = $this->influencerData('banned');
        return view('admin.influencers.list', compact('pageTitle', 'influencers'));
    }

    public function emailUnverifiedInfluencers()
    {
        $pageTitle   = 'Email Unverified Influencers';
        $influencers = $this->influencerData('emailUnverified');
        return view('admin.influencers.list', compact('pageTitle', 'influencers'));
    }

    public function kycUnverifiedInfluencers()
    {
        $pageTitle   = 'KYC Unverified Influencers';
        $influencers = $this->influencerData('kycUnverified');
        return view('admin.influencers.list', compact('pageTitle', 'influencers'));
    }

    public function kycPendingInfluencers()
    {
        $pageTitle   = 'KYC Unverified Influencers';
        $influencers = $this->influencerData('kycPending');
        return view('admin.influencers.list', compact('pageTitle', 'influencers'));
    }

    public function emailVerifiedInfluencers()
    {
        $pageTitle   = 'Email Verified Influencers';
        $influencers = $this->influencerData('emailVerified');
        return view('admin.influencers.list', compact('pageTitle', 'influencers'));
    }

    public function mobileUnverifiedInfluencers()
    {
        $pageTitle   = 'Mobile Unverified Influencers';
        $influencers = $this->influencerData('mobileUnverified');
        return view('admin.influencers.list', compact('pageTitle', 'influencers'));
    }

    public function mobileVerifiedInfluencers()
    {
        $pageTitle   = 'Mobile Verified Influencers';
        $influencers = $this->influencerData('mobileVerified');
        return view('admin.influencers.list', compact('pageTitle', 'influencers'));
    }

    public function influencersWithBalance()
    {
        $pageTitle   = 'Influencers with Balance';
        $influencers = $this->influencerData('withBalance');
        return view('admin.influencers.list', compact('pageTitle', 'influencers'));
    }

    protected function influencerData($scope = null)
    {

        if ($scope) {
            $influencers = Influencer::$scope();
        } else {
            $influencers = Influencer::query();
        }

        //search
        $request = request();

        if ($request->search) {
            $search      = $request->search;
            $influencers = $influencers->where(function ($user) use ($search) {
                $user->where('username', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        return $influencers->orderBy('id', 'desc')->paginate(getPaginate());
    }

    public function detail($id)
    {
        $influencer       = Influencer::findOrFail($id);
        $pageTitle        = 'Information of ' . $influencer->username;
        $totalService     = Service::where('influencer_id', $influencer->id)->where('status', 1)->count();
        $totalWithdrawals = Withdrawal::where('influencer_id', $influencer->id)->where('status', 1)->sum('amount');
        $totalTransaction = Transaction::where('influencer_id', $influencer->id)->count();
        $countries        = json_decode(file_get_contents(resource_path('views/partials/country.json')));

        $data['pending_order']    = Order::pending()->where('influencer_id', $id)->count();
        $data['inprogress_order'] = Order::inprogress()->where('influencer_id', $id)->count();
        $data['job_done_order']   = Order::jobDone()->where('influencer_id', $id)->count();
        $data['completed_order']  = Order::completed()->where('influencer_id', $id)->count();
        $data['reported_order']   = Order::reported()->where('influencer_id', $id)->count();
        $data['cancelled_order']  = Order::cancelled()->where('influencer_id', $id)->count();

        $data['pending_hiring']    = Hiring::pending()->where('influencer_id', $id)->count();
        $data['inprogress_hiring'] = Hiring::inprogress()->where('influencer_id', $id)->count();
        $data['job_done_hiring']   = Hiring::jobDone()->where('influencer_id', $id)->count();
        $data['completed_hiring']  = Hiring::completed()->where('influencer_id', $id)->count();
        $data['reported_hiring']   = Hiring::reported()->where('influencer_id', $id)->count();
        $data['cancelled_hiring']  = Hiring::cancelled()->where('influencer_id', $id)->count();

        return view('admin.influencers.detail', compact('pageTitle', 'influencer', 'totalWithdrawals', 'totalTransaction', 'countries', 'totalService', 'data'));
    }

    public function kycDetails($id)
    {
        $pageTitle  = 'KYC Details';
        $influencer = Influencer::findOrFail($id);
        return view('admin.influencers.kyc_detail', compact('pageTitle', 'influencer'));
    }

    public function kycApprove($id)
    {
        $influencer     = Influencer::findOrFail($id);
        $influencer->kv = 1;
        $influencer->save();

        notify($influencer, 'KYC_APPROVE', []);

        $notify[] = ['success', 'KYC approved successfully'];
        return to_route('admin.influencers.kyc.pending')->withNotify($notify);
    }

    public function kycReject($id)
    {
        $influencer = Influencer::findOrFail($id);

        foreach ($influencer->kyc_data as $kycData) {

            if ($kycData->type == 'file') {
                fileManager()->removeFile(getFilePath('verify') . '/' . $kycData->value);
            }
        }

        $influencer->kv       = 0;
        $influencer->kyc_data = null;
        $influencer->save();

        notify($influencer, 'KYC_REJECT', []);

        $notify[] = ['success', 'KYC rejected successfully'];
        return to_route('admin.influencers.kyc.pending')->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $influencer   = Influencer::findOrFail($id);
        $countryData  = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryArray = (array) $countryData;
        $countries    = implode(',', array_keys($countryArray));

        $countryCode = $request->country;
        $country     = $countryData->$countryCode->country;
        $dialCode    = $countryData->$countryCode->dial_code;

        $request->validate([
            'firstname' => 'required|string|max:40',
            'lastname'  => 'required|string|max:40',
            'email'     => 'required|email|string|max:40|unique:users,email,' . $influencer->id,
            'mobile'    => 'required|string|max:40|unique:influencers,mobile,' . $influencer->id,
            'country'   => 'required|in:' . $countries,
        ]);
        $influencer->mobile       = $dialCode . $request->mobile;
        $influencer->country_code = $countryCode;
        $influencer->firstname    = $request->firstname;
        $influencer->lastname     = $request->lastname;
        $influencer->email        = $request->email;
        $influencer->address      = [
            'address' => $request->address,
            'city'    => $request->city,
            'state'   => $request->state,
            'zip'     => $request->zip,
            'country' => @$country,
        ];
        $influencer->ev = $request->ev ? 1 : 0;
        $influencer->sv = $request->sv ? 1 : 0;
        $influencer->ts = $request->ts ? 1 : 0;

        if (!$request->kv) {
            $influencer->kv = 0;

            if ($influencer->kyc_data) {

                foreach ($influencer->kyc_data as $kycData) {

                    if ($kycData->type == 'file') {
                        fileManager()->removeFile(getFilePath('verify') . '/' . $kycData->value);
                    }
                }
            }

            $influencer->kyc_data = null;
        } else {
            $influencer->kv = 1;
        }

        $influencer->save();

        $notify[] = ['success', 'Influencer details updated successfully'];
        return redirect()->back()->withNotify($notify);
    }

    public function addSubBalance(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'act'    => 'required|in:add,sub',
            'remark' => 'required|string|max:255',
        ]);

        $influencer = Influencer::findOrFail($id);
        $amount     = $request->amount;
        $general    = gs();
        $trx        = getTrx();

        $transaction = new Transaction();

        if ($request->act == 'add') {
            $influencer->balance += $amount;

            $transaction->trx_type = '+';
            $transaction->remark   = 'balance_add';

            $notifyTemplate = 'BAL_ADD';

            $notify[] = ['success', $general->cur_sym . $amount . ' added successfully'];
        } else {

            if ($amount > $influencer->balance) {
                $notify[] = ['error', $influencer->username . ' doesn\'t have sufficient balance.'];
                return back()->withNotify($notify);
            }

            $influencer->balance -= $amount;

            $transaction->trx_type = '-';
            $transaction->remark   = 'balance_subtract';

            $notifyTemplate = 'BAL_SUB';
            $notify[]       = ['success', $general->cur_sym . $amount . ' subtracted successfully'];
        }

        $influencer->save();

        $transaction->influencer_id = $influencer->id;
        $transaction->amount        = $amount;
        $transaction->post_balance  = $influencer->balance;
        $transaction->charge        = 0;
        $transaction->trx           = $trx;
        $transaction->details       = $request->remark;
        $transaction->save();

        notify($influencer, $notifyTemplate, [
            'trx'          => $trx,
            'amount'       => showAmount($amount),
            'remark'       => $request->remark,
            'post_balance' => showAmount($influencer->balance),
        ]);

        return back()->withNotify($notify);
    }

    public function login($id)
    {
        if (auth()->check()) {
            auth()->logout();
        }
        Auth::guard('influencer')->loginUsingId($id);
        return to_route('influencer.home');
    }

    public function status(Request $request, $id)
    {
        $influencer = Influencer::findOrFail($id);

        if ($influencer->status == 1) {
            $request->validate([
                'reason' => 'required|string|max:255',
            ]);
            $influencer->status     = 0;
            $influencer->ban_reason = $request->reason;
            $notify[]               = ['success', 'Influencer banned successfully'];
        } else {
            $influencer->status     = 1;
            $influencer->ban_reason = null;
            $notify[]               = ['success', 'Influencer unbanned successfully'];
        }

        $influencer->save();
        return back()->withNotify($notify);
    }

    public function showNotificationSingleForm($id)
    {
        $influencer = Influencer::findOrFail($id);
        $general    = gs();

        if (!$general->en && !$general->sn) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.influencers.detail', $influencer->id)->withNotify($notify);
        }

        $pageTitle = 'Send Notification to ' . $influencer->username;
        return view('admin.influencers.notification_single', compact('pageTitle', 'influencer'));
    }

    public function sendNotificationSingle(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string',
            'subject' => 'required|string',
        ]);

        $influencer = Influencer::findOrFail($id);
        notify($influencer, 'DEFAULT', [

            'subject' => $request->subject,
            'message' => $request->message,
        ]);
        $notify[] = ['success', 'Notification sent successfully'];
        return back()->withNotify($notify);
    }

    public function showNotificationAllForm()
    {
        $general = gs();

        if (!$general->en && !$general->sn) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.dashboard')->withNotify($notify);
        }

        $influencers = Influencer::where('ev', 1)->where('sv', 1)->where('status', 1)->count();
        $pageTitle   = 'Notification to Verified Influencers';
        return view('admin.influencers.notification_all', compact('pageTitle', 'influencers'));
    }

    public function sendNotificationAll(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'message' => 'required',
            'subject' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $influencer = Influencer::where('status', 1)->where('ev', 1)->where('sv', 1)->skip($request->skip)->first();
        notify($influencer, 'DEFAULT', [
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return response()->json([
            'success'    => 'message sent',
            'total_sent' => $request->skip + 1,
        ]);
    }

    public function notificationLog($id)
    {
        $influencer = Influencer::findOrFail($id);
        $pageTitle  = 'Notifications Sent to ' . $influencer->username;
        $logs       = NotificationLog::where('influencer_id', $id)->with('user', 'influencer')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.influencers.reports.notification_history', compact('pageTitle', 'logs', 'influencer'));
    }

    public function reviews($id)
    {
        $influencer = Influencer::findOrFail($id);
        $pageTitle  = 'Reviews of ' . $influencer->username;
        $reviews    = Review::where('influencer_id', $id)->with('user')->paginate(getPaginate());
        return view('admin.influencers.reviews', compact('pageTitle', 'reviews'));
    }
    public function reviewRemove($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        $influencer = Influencer::with('reviews')->where('id', $review->influencer_id)->firstOrFail();

        if ($influencer->reviews->count() > 0) {
            $totalReview = $influencer->reviews->count();
            $totalStar   = $influencer->reviews->sum('star');
            $avgRating   = $totalStar / $totalReview;
        } else {
            $avgRating = 0;
        }
        $influencer->rating = $avgRating;
        $influencer->save();

        if ($review->service_id != 0) {
            $service = Service::approved()->where('id', $review->service_id)->with('reviews')->firstOrFail();
            if ($service->reviews->count() > 0) {
                $totalServiceReview = $service->reviews->count();
                $totalServiceStar   = $service->reviews->sum('star');
                $avgServiceRating   = $totalServiceStar / $totalServiceReview;
            } else {
                $avgServiceRating = 0;
            }

            $service->rating = $avgServiceRating;
            $service->save();
        }

        $notify[] = ['success', 'Review remove successfully'];
        return back()->withNotify($notify);
    }
}
