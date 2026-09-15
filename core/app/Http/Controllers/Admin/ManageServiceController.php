<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ManageServiceController extends Controller {
    public function index() {
        $pageTitle = 'All Services';
        $services  = $this->serviceData();
        return view('admin.service.list', compact('pageTitle', 'services'));
    }

    public function pending() {
        $pageTitle = 'Pending Services';
        $services  = $this->serviceData('pending');
        return view('admin.service.list', compact('pageTitle', 'services'));
    }

    public function approved() {
        $pageTitle = 'Approved Services';
        $services  = $this->serviceData('approved');
        return view('admin.service.list', compact('pageTitle', 'services'));
    }

    public function rejected() {
        $pageTitle = 'Rejected Services';
        $services  = $this->serviceData('rejected');
        return view('admin.service.list', compact('pageTitle', 'services'));
    }

    public function expired() {
        $pageTitle = 'Expired Services';
        $services  = $this->serviceData('expired');
        return view('admin.service.list', compact('pageTitle', 'services'));
    }

    protected function serviceData($scope = null) {

        if ($scope) {
            $services = Service::$scope();
        } else {
            $services = Service::query();
        }

        $request = request();

        if ($request->search) {

            $search   = $request->search;
            $services = $services->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")->orWhereHas('influencer', function ($influencer) use ($search) {
                    $influencer->where('username', 'like', "%$search%");
                })->orWhereHas('category', function ($category) use ($search) {
                    $category->where('name', 'like', "%$search%");
                });
            });

        }

        return $services->with('influencer', 'category')->withCount('totalOrder', 'completeOrder')->orderBy('id', 'desc')->paginate(getPaginate());
    }

    public function detail($id) {
        $pageTitle = 'Service Detail';
        $service   = Service::with('influencer', 'category', 'tags', 'gallery')->findOrFail($id);
        return view('admin.service.detail', compact('pageTitle', 'service'));
    }

    public function status(Request $request, $id) {
        $request->validate([
            'status'         => 'required|integer|in:1,2',
            'admin_feedback' => 'nullable|string',
        ]);

        $service                 = Service::with('influencer')->findOrFail($id);
        $service->status         = $request->status;
        $service->admin_feedback = $request->admin_feedback;
        $service->save();

        $influencer = $service->influencer;
        $general    = gs();

        if ($request->status == 1) {
            notify($influencer, 'SERVICE_APPROVE', [
                'username'     => $influencer->username,
                'title'        => $service->title,
                'currency'     => $general->cur_text,
                'created_at'   => showDateTime($service->created_at),
                'post_balance' => showAmount($influencer->balance),
            ]);
            $notification = 'Service approved successfully';
        } else {
            notify($influencer, 'SERVICE_REJECT', [
                'username'       => $influencer->username,
                'title'          => $service->title,
                'currency'       => $general->cur_text,
                'created_at'     => showDateTime($service->created_at),
                'post_balance'   => showAmount($influencer->balance),
                'admin_feedback' => $request->admin_feedback,
            ]);
            $notification = 'Service rejected successfully';
        }

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

}
