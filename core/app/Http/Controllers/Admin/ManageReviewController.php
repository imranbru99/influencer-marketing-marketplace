<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Influencer;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Http\Request;

class ManageReviewController extends Controller {
    public function services(Request $request) {
        $pageTitle = 'Service Review List';
        $reviews   = Review::where('order_id', '!=', 0);
        if ($request->search) {
            $search  = $request->search;
            $reviews = $reviews->where('review', 'like', "%$search%")->orWhereHas('user', function ($q) use ($search) {
                $q->where('username', 'like', "%$search%");
            })->orWhereHas('order', function ($query) use ($search) {
                $query->where('order_no', 'like', "%$search%");
            })->orWhereHas('influencer', function ($influencer) use ($search) {
                $influencer->where('username', 'like', "%$search%");
            });
        }
        $reviews = $reviews->latest()->with('user', 'service', 'order', 'influencer')->latest()->paginate(getPaginate());
        return view('admin.reviews.services', compact('pageTitle', 'reviews'));
    }

    public function influencers(Request $request) {
        $pageTitle = 'Influencer Review List';
        $reviews   = Review::where('order_id', 0);
        if ($request->search) {
            $search  = $request->search;
            $reviews = $reviews->where('review', 'like', "%$search%")->whereHas('user', function ($q) use ($search) {
                $q->where('username', 'like', "%$search%");
            })->orWhereHas('hiring', function ($query) use ($search) {
                $query->where('hiring_no', 'like', "%$search%");
            })->orWhereHas('influencer', function ($influencer) use ($search) {
                $influencer->where('username', 'like', "%$search%");
            });
        }
        $reviews = $reviews->latest()->with('user', 'influencer', 'hiring')->latest()->paginate(getPaginate());
        return view('admin.reviews.influencers', compact('pageTitle', 'reviews'));
    }

    public function serviceReviewDelete($id) {

        $review = Review::findOrFail($id);
        $review->delete();

        $service            = Service::approved()->where('id', $review->service_id)->with('reviews')->firstOrFail();
        $totalServiceReview = $service->reviews()->where('order_id', '!=', 0)->count();
        $totalServiceStar   = $service->reviews()->where('order_id', '!=', 0)->sum('star');

        if ($totalServiceReview != 0) {
            $avgServiceRating = $totalServiceStar / $totalServiceReview;
        } else {
            $avgServiceRating = 0;
        }

        $service->rating = $avgServiceRating;
        $service->decrement('total_review');
        $service->save();

        $notify[] = ['success', 'Review removed successfully'];
        return back()->withNotify($notify);
    }

    public function influencerReviewDelete($id) {

        $review = Review::findOrFail($id);
        $review->delete();

        $influencer  = Influencer::with('reviews')->where('id', $review->influencer_id)->firstOrFail();
        $totalReview = $influencer->reviews()->where('hiring_id', '!=', 0)->count();
        $totalStar   = $influencer->reviews()->where('hiring_id', '!=', 0)->sum('star');

        if ($totalReview != 0) {
            $avgRating = $totalStar / $totalReview;
        } else {
            $avgRating = 0;
        }

        $influencer->rating = $avgRating;
        $influencer->decrement('total_review');
        $influencer->save();

        $notify[] = ['success', 'Review removed successfully'];
        return back()->withNotify($notify);
    }
    
}
