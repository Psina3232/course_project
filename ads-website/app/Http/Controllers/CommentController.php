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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $adId)
    {
        // Валидация входящих данных
        $validated = $request->validate([
            'content' => 'required|string|max:255',
        ]);

        // Создание нового комментария
        $comment = Comment::create([
            'ad_id' => $adId,
            'user_id' => Auth::id(),
            'content' => $validated['content'],
        ]);

        return response()->json([
            'message' => 'Comment added successfully',
            'comment' => $comment
        ], 201);
    }
}
