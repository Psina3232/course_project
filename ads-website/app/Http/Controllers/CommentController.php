<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $adId
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $adId)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $comment = Comment::create([
            'ad_id' => $adId,
            'user_id' => Auth::id(),
            'content' => $validated['content'],
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Comment added successfully',
                'comment' => $comment
            ], 201);
        }

        return redirect()->route('ads.show', $adId);
    }

    /**
     * Update the specified comment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== auth()->id() && !auth()->user()->is_admin) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'You are not authorized to edit this comment'], 403);
            }
            return redirect()->back()->withErrors(['message' => 'You are not authorized to edit this comment']);
        }

        $comment->content = $request->content;
        $comment->save();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Comment updated successfully', 'comment' => $comment], 200);
        }

        return redirect()->route('ads.show', $comment->ad_id);
    }

    /**
     * Remove the specified comment from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id, Request $request)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== auth()->id() && !auth()->user()->is_admin) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'You are not authorized to delete this comment'], 403);
            }
            return redirect()->back()->withErrors(['message' => 'You are not authorized to delete this comment']);
        }

        $comment->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Comment deleted successfully'], 200);
        }

        return redirect()->route('ads.show', $comment->ad_id);
    }
}