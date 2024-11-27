<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdController extends Controller
{

    // Метод для создания объявления
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);
    
        $ad = new Ad();
        $ad->title = $validatedData['title'];
        $ad->description = $validatedData['description'];
        $ad->price = $validatedData['price'];
        $ad->user_id = auth()->id(); // Устанавливаем user_id
    
        $ad->save();

        if ($request->wantsJson()) {
            return response()->json($ad, 201);
        }

        // Вернуть HTML-страницу, например, перенаправить обратно на список объявлений
        return redirect()->route('ads.index');
    }

    public function create()
{
    return view('ads.create');
}

    // Метод для получения списка объявлений
    public function index(Request $request)
    {
        $ads = Ad::all();

        if ($request->wantsJson()) {
            return response()->json($ads);
        }

        return view('ads.index', compact('ads'));
    }

    // Метод для получения одного объявления
    public function show($id, Request $request)
    {
        $ad = Ad::with('comments.user')->findOrFail($id);

        if ($request->wantsJson()) {
            return response()->json([
                'ad' => $ad
            ]);
        }

        return view('ads.show', compact('ad'));
    }

    // Метод для обновления объявления
    public function update(Request $request, Ad $ad)
{
    // Проверяем, является ли текущий пользователь владельцем объявления или администратором
    if ($ad->user_id != auth()->id() && !auth()->user()->isAdmin()) {
        return response()->json(['message' => 'You are not authorized to edit this ad'], 403);
    }

    // Валидация данных
    $validated = $request->validate([
        'title' => 'sometimes|string|max:255',
        'description' => 'sometimes|string',
        'price' => 'sometimes|numeric',
    ]);

    // Обновляем объявление
    $ad->update($validated);

    // Ответ в формате JSON, если запрос был через API
    if ($request->wantsJson()) {
        return response()->json([
            'data' => $ad
        ]);
    }

    // Перенаправление, если запрос не через API
    return redirect()->route('ads.show', $ad->id);
}


    // Метод для удаления объявления
    public function destroy(Ad $ad, Request $request)
    {
        if (auth()->user()->id !== $ad->user_id && !auth()->user()->is_admin) {
            return response()->json(['message' => 'you do not have permission to remove this ad.'], 403);
        }

        $ad->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Ad deleted successfully']);
        }

        return redirect()->route('ads.index');
    }

    public function search(Request $request)
    {
        $query = $request->input('title');

        $ads = Ad::where('title', 'like', "%{$query}%")->latest()->get();

        if ($request->wantsJson()) {
            return response()->json($ads);
        }

        return view('ads.index', compact('ads'));
    }
}