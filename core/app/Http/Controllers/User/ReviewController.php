<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Hiring;
use App\Models\Influencer;
use App\Models\Order;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller {

    public function index(Request $request) {
        $pageTitle = 'My Reviews';
        $reviews   = Review::where('user_id', auth()->id());

        if ($request->search) {
            $search  = $request->search;
            $reviews = $reviews->where('review', 'like', "%$search%")->orWhereHas('hiring', function ($q) use ($search) {
                $q->where('hiring_no', 'like', "%$search%");
            })->orWhereHas('order', function ($query) use ($search) {
                $query->where('order_no', 'like', "%$search%");
            })->orWhereHas('influencer', function ($influencer) use ($search) {
                $influencer->where('username', 'like', "%$search%");
            });
        }

        $reviews = $reviews->with('hiring', 'order', 'influencer')->latest()->paginate(getPaginate());
        return view($this->activeTemplate . 'user.review.index', compact('pageTitle', 'reviews'));
    }

    public function orderReviews(Request $request) {
        $pageTitle = 'My Reviews';
        $reviews   = Review::where('user_id', auth()->id())->where('order_id', '!=', 0);

        if ($request->search) {
            $search  = $request->search;
            $reviews = $reviews->where('review', 'like', "%$search%")->orWhereHas('order', function ($query) use ($search) {
                $query->where('order_no', 'like', "%$search%");
            })->orWhereHas('influencer', function ($influencer) use ($search) {
                $influencer->where('username', 'like', "%$search%");
            });
        }

        $reviews = $reviews->with('hiring', 'order', 'influencer')->latest()->paginate(getPaginate());
        return view($this->activeTemplate . 'user.review.index', compact('pageTitle', 'reviews'));
    }

    public function hiringReviews(Request $request) {
        $pageTitle = 'My Reviews';
        $reviews   = Review::where('user_id', auth()->id())->where('order_id', 0);

        if ($request->search) {
            $search  = $request->search;
            $reviews = $reviews->where('review', 'like', "%$search%")->orWhereHas('hiring', function ($q) use ($search) {
                $q->where('hiring_no', 'like', "%$search%");
            })->orWhereHas('influencer', function ($influencer) use ($search) {
                $influencer->where('username', 'like', "%$search%");
            });
        }

        $reviews = $reviews->with('hiring', 'order', 'influencer')->latest()->paginate(getPaginate());
        return view($this->activeTemplate . 'user.review.index', compact('pageTitle', 'reviews'));
    }

    public function reviewInfluencer($id) {
        $pageTitle = 'Add Review';
        $hiring    = Hiring::with('influencer')->where('user_id', auth()->id())->with('review')->findOrFail($id);
        return view($this->activeTemplate . 'user.review.influencer', compact('pageTitle', 'hiring'));
    }

    public function reviewService($id) {
        $pageTitle = 'Update Review';
        $order     = Order::with('influencer', 'review', 'service')->where('user_id', auth()->id())->findOrFail($id);
        return view($this->activeTemplate . 'user.review.service', compact('pageTitle', 'order'));
    }

    public function addServiceReview(Request $request, $id) {

        $this->validation($request->all())->validate();

        $order  = Order::with('service.influencer')->where('user_id', auth()->id())->findOrFail($id);
        $review = Review::where('user_id', auth()->id())->where(function ($query) use ($id, $order) {
            $query->where('order_id', $id)->orWhere('service_id', $order->service_id);
        })->first();

        $influencerId = @$order->influencer_id;
        $this->addReview($influencerId, $order, $hiringId = 0, $review);
        $service = $this->reviewForService($order->service_id);

        if (!$review) {
            $service->increment('total_review');
        }

        $notify[] = ['success', 'Review added successfully'];
        return back()->withNotify($notify);
    }

    public function addHiringReview(Request $request, $id) {

        $this->validation($request->all())->validate();

        $hiring = Hiring::with('influencer')->where('user_id', auth()->id())->findOrFail($id);
        $review = Review::where('user_id', auth()->id())->where('hiring_id', $id)->first();

        $influencerId = @$hiring->influencer_id;
        $this->addReview($influencerId, null, $hiring->id, $review);

        $influencer = $this->reviewForInfluencer($influencerId);

        if (!$review) {
            $influencer->increment('total_review');
        }

        $notify[] = ['success', 'Review added successfully'];
        return back()->withNotify($notify);
    }

    protected function validation(array $data) {
        $validate = Validator::make($data, [
            'star'   => 'required|integer|min:1|max:5',
            'review' => 'required|string',
        ]);

        return $validate;
    }

    protected function addReview($influencerId, $order = null, $hiringId = 0, $review = null) {
        $request = request();

        if (!$review) {
            $review = new Review();
        }

        $review->user_id       = auth()->id();
        $review->influencer_id = $influencerId;
        $review->hiring_id     = $hiringId;
        $review->order_id      = $order->id ?? 0;
        $review->service_id    = $order->service_id ?? 0;
        $review->star          = $request->star;
        $review->review        = $request->review;
        $review->save();
    }

    public function removeServiceReview($id) {
        $review = Review::where('user_id', auth()->id())->where('id', $id)->firstOrFail();
        $review->delete();

        $service = $this->reviewForService($review->service_id);
        $service->decrement('total_review');

        $notify[] = ['success', 'Review removed successfully'];
        return back()->withNotify($notify);
    }

    public function removeInfluencerReview($id) {
        $review = Review::where('user_id', auth()->id())->where('id', $id)->firstOrFail();
        $review->delete();
        $influencer = $this->reviewForInfluencer($review->influencer_id);
        $influencer->decrement('total_review');
        $notify[] = ['success', 'Review removed successfully'];
        return back()->withNotify($notify);
    }

    protected function reviewForInfluencer($id) {
        $request     = request();
        $influencer  = Influencer::with('reviews')->where('id', $id)->firstOrFail();
        $totalReview = $influencer->reviews()->where('hiring_id', '!=', 0)->count();
        $totalStar   = $influencer->reviews()->where('hiring_id', '!=', 0)->sum('star');

        if ($totalReview != 0) {
            $avgRating = $totalStar / $totalReview;
        } else {
            $avgRating = $request->star;
        }

        $influencer->rating = $avgRating;
        $influencer->save();

        return $influencer;
    }

    protected function reviewForService($id) {
        $service            = Service::approved()->where('id', $id)->with('reviews')->firstOrFail();
        $totalServiceReview = $service->reviews()->where('order_id', '!=', 0)->count();
        $totalServiceStar   = $service->reviews()->where('order_id', '!=', 0)->sum('star');

        if ($totalServiceReview != 0) {
            $avgServiceRating = $totalServiceStar / $totalServiceReview;
        } else {
            $avgServiceRating = 0;
        }

        $service->rating = $avgServiceRating;
        $service->save();
        return $service;
    }

}
