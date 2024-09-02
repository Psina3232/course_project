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

    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $comment = Comment::findOrFail($id);

        // Проверка прав пользователя
        if ($comment->user_id !== auth()->id() && !auth()->user()->is_admin) {
            return response()->json(['message' => 'You are not authorized to edit this comment'], 403);
        }

        $comment->content = $request->content;
        $comment->save();

        return response()->json(['message' => 'Comment updated successfully', 'comment' => $comment], 200);
    }

    // Метод для удаления комментария
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        // Проверка прав пользователя
        if ($comment->user_id !== auth()->id() && !auth()->user()->is_admin) {
            return response()->json(['message' => 'You are not authorized to delete this comment'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully'], 200);
    }
}
