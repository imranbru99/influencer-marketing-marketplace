<?php

namespace App\Http\Controllers\Influencer;

use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Lib\GoogleAuthenticator;
use App\Models\Form;
use App\Models\Hiring;
use App\Models\Order;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class InfluencerController extends Controller {
    public function home() {
        $pageTitle                 = 'Dashboard';
        $influencerId              = authInfluencerId();
        $data['current_balance']   = authInfluencer()->balance;
        $data['withdraw_balance']  = Withdrawal::where('influencer_id', $influencerId)->where('status', 1)->sum('amount');
        $data['total_transaction'] = Transaction::where('influencer_id', $influencerId)->count();
        $data['total_hiring']      = Hiring::where('influencer_id', $influencerId)->count();
        $data['total_order']       = Order::where('influencer_id', $influencerId)->count();
        $data['total_service']     = Service::where('influencer_id', $influencerId)->count();

        $data['pending_order']    = Order::pending()->where('influencer_id', $influencerId)->count();
        $data['inprogress_order'] = Order::inprogress()->where('influencer_id', $influencerId)->count();
        $data['job_done_order']   = Order::jobDone()->where('influencer_id', $influencerId)->count();
        $data['completed_order']  = Order::completed()->where('influencer_id', $influencerId)->count();
        $data['cancelled_order']  = Order::cancelled()->where('influencer_id', $influencerId)->count();
        $data['reported_order']   = Order::reported()->where('influencer_id', $influencerId)->count();
        $data['rejected_order']   = Order::rejected()->where('influencer_id', $influencerId)->count();

        $data['pending_hiring']    = Hiring::pending()->where('influencer_id', $influencerId)->count();
        $data['inprogress_hiring'] = Hiring::inprogress()->where('influencer_id', $influencerId)->count();
        $data['job_done_hiring']    = Hiring::jobDone()->where('influencer_id', $influencerId)->count();
        $data['completed_hiring']  = Hiring::completed()->where('influencer_id', $influencerId)->count();
        $data['cancelled_hiring']  = Hiring::cancelled()->where('influencer_id', $influencerId)->count();
        $data['reported_hiring']   = Hiring::reported()->where('influencer_id', $influencerId)->count();
        $data['rejected_hiring']   = Hiring::rejected()->where('influencer_id', $influencerId)->count();

        return view($this->activeTemplate . 'influencer.dashboard', compact('pageTitle', 'data'));
    }

    public function show2faForm() {
        $general    = gs();
        $ga         = new GoogleAuthenticator();
        $influencer = authInfluencer();
        $secret     = $ga->createSecret();
        $qrCodeUrl  = $ga->getQRCodeGoogleUrl($influencer->username . '@' . $general->site_name, $secret);
        $pageTitle  = '2FA Security';
        return view($this->activeTemplate . 'influencer.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request) {
        $influencer = authInfluencer();
        $this->validate($request, [
            'key'  => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($influencer, $request->code, $request->key);

        if ($response) {
            $influencer->tsc = $request->key;
            $influencer->ts  = 1;
            $influencer->save();
            $notify[] = ['success', 'Google authenticator activated successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }

    }

    public function disable2fa(Request $request) {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $influencer = authInfluencer();
        $response   = verifyG2fa($influencer, $request->code);

        if ($response) {
            $influencer->tsc = null;
            $influencer->ts  = 0;
            $influencer->save();
            $notify[] = ['success', 'Two factor authenticator deactivated successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }

        return back()->withNotify($notify);
    }

    public function transactions(Request $request) {
        $pageTitle    = 'Transactions';
        $remarks      = Transaction::where('influencer_id', authInfluencerId())->distinct('remark')->orderBy('remark')->get('remark');
        $transactions = Transaction::where('influencer_id', authInfluencerId());

        if ($request->search) {
            $transactions = $transactions->where('trx', $request->search);
        }

        if ($request->type) {
            $transactions = $transactions->where('trx_type', $request->type);
        }

        if ($request->remark) {
            $transactions = $transactions->where('remark', $request->remark);
        }

        $transactions = $transactions->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'influencer.transactions', compact('pageTitle', 'transactions', 'remarks'));
    }

    public function kycForm() {

        if (authInfluencer()->kv == 2) {
            $notify[] = ['error', 'Your KYC is under review'];
            return to_route('influencer.home')->withNotify($notify);
        }

        if (authInfluencer()->kv == 1) {
            $notify[] = ['error', 'You are already KYC verified'];
            return to_route('influencer.home')->withNotify($notify);
        }

        $pageTitle = 'KYC Form';
        return view($this->activeTemplate . 'influencer.kyc.form', compact('pageTitle'));
    }

    public function kycData() {
        $influencer = authInfluencer();
        $pageTitle  = 'KYC Data';
        return view($this->activeTemplate . 'influencer.kyc.info', compact('pageTitle', 'influencer'));
    }

    public function kycSubmit(Request $request) {
        $form           = Form::where('act', 'influencer_kyc')->first();
        $formData       = $form->form_data;
        $formProcessor  = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $influencerData       = $formProcessor->processFormData($request, $formData);
        $influencer           = authInfluencer();
        $influencer->kyc_data = $influencerData;
        $influencer->kv       = 2;
        $influencer->save();

        $notify[] = ['success', 'KYC data submitted successfully'];
        return to_route('influencer.home')->withNotify($notify);
    }

    public function attachmentDownload($fileHash) {
        $filePath  = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $general   = gs();
        $title     = slug($general->site_name) . '- attachments.' . $extension;
        $mimetype  = mime_content_type($filePath);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }

    public function influencerData() {
        $influencer = authInfluencer();

        if ($influencer->reg_step == 1) {
            return to_route('influencer.home');
        }

        $pageTitle = 'Influencer Data';
        return view($this->activeTemplate . 'influencer.influencer_data', compact('pageTitle', 'influencer'));
    }

    public function influencerDataSubmit(Request $request) {
        $influencer = authInfluencer();

        if ($influencer->reg_step == 1) {
            return to_route('influencer.home');
        }

        $request->validate([
            'firstname' => 'required',
            'lastname'  => 'required',
        ]);
        $influencer->firstname = $request->firstname;
        $influencer->lastname  = $request->lastname;
        $influencer->address   = [
            'country' => @$influencer->address->country,
            'address' => $request->address,
            'state'   => $request->state,
            'zip'     => $request->zip,
            'city'    => $request->city,
        ];
        $influencer->reg_step = 1;
        $influencer->save();

        $notify[] = ['success', 'Registration process completed successfully'];
        return to_route('influencer.home')->withNotify($notify);
    }

}
