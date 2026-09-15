<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Influencer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FavoriteController extends Controller {

    public function addFavorite(Request $request) {
        $validator = Validator::make($request->all(), [
            'influencerId' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $influencer = Influencer::active()->where('id', $request->influencerId)->first();

        if (!$influencer) {
            return response()->json(['success' => 'Influencer not found']);
        }

        $favorite                = new favorite();
        $favorite->user_id       = auth()->id();
        $favorite->influencer_id = $influencer->id;
        $favorite->save();

        return response()->json([
            'success'      => 'Added to favorite list',
            'influencerId' => $influencer->id,
        ]);
    }

    public function favoriteInfluencer() {
        $userId    = auth()->id();
        $favorites = Favorite::where('user_id', $userId)->select('influencer_id')->get();
        return $favorites;
    }

    public function favoriteList(Request $request) {
        $pageTitle = 'My Favorite List';
        $favorites = Favorite::query();

        if ($request->search) {
            $search    = $request->search;
            $favorites = $favorites->whereHas('influencer', function ($query) use ($search) {
                $query->where('username', 'LIKE', "%$search%");
            });
        }

        $favorites = $favorites->where('user_id', auth()->id())->with(['influencer' => function ($query) {
            $query->withCount('reviews');
        },
        ])->latest()->paginate(getPaginate());
        return view($this->activeTemplate . 'user.favorite.list', compact('pageTitle', 'favorites'));
    }

    public function delete(Request $request) {
        $validator = Validator::make($request->all(), [
            'influencerId' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        Favorite::where('user_id', auth()->id())->where('influencer_id', $request->influencerId)->delete();
        return response()->json([
            'success'      => ' Removed from favorite list',
            'remark'       => 'remove',
            'influencerId' => $request->influencerId,
        ]);
    }

    public function remove($id) {
        Favorite::where('user_id', auth()->id())->where('id', $id)->delete();
        $notify[] = ['success', 'Removed from favorite list successfully'];
        return back()->withNotify($notify);
    }

}
