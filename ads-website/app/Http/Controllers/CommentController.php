<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Ad;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $adId)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $comment = new Comment();
        $comment->ad_id = $adId;
        $comment->user_id = auth()->id();
        $comment->content = $request->content;
        $comment->save();

        return redirect()->route('ads.show', $adId);
    }
}
