<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class ManageTagController extends Controller {

    public function tags(Request $request) {
        $pageTitle = 'Tags';
        $tags      = Tag::query();
        if ($request->search) {
            $search = $request->search;
            $tags   = $tags->where(function ($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            });
        }
        $tags = $tags->latest()->paginate(getPaginate());
        return view('admin.tags.index', compact('pageTitle', 'tags'));
    }

    public function store(Request $request, $id = 0) {
        $request->validate([
            'name' => 'required|string|unique:tags,name,'.$id,
        ]);

        if ($id) {
            $tag          = Tag::findOrFail($id);
            $notification = 'Tag updated successfully';
        } else {
            $tag          = new Tag();
            $notification = 'Tag created successfully';
        }
        $tag->name = $request->name;
        $tag->save();
        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function delete($id) {
        Tag::where('id', $id)->delete();
        $notify[] = ['success', 'Tag deleted successfully'];
        return back()->withNotify($notify);
    }
}
