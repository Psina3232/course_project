<?php

namespace App\Http\Controllers;

use App\Models\Ad;
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
    
        return response()->json($ad, 201);
    }

    // Метод для получения списка объявлений
    public function index()
    {
        $ads = Ad::all();

        return response()->json($ads);
    }

    // Метод для получения одного объявления
    public function show($id)
    {
        $ad = Ad::with('comments.user')->findOrFail($id);

        return response()->json([
            'ad' => $ad
        ]);
    }

    // Метод для обновления объявления
    public function update(Request $request, Ad $ad)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric',
        ]);

        $ad->update($validated);

        return response()->json([
            'data' => $ad
        ]);
    }

    // Метод для удаления объявления
    public function destroy(Ad $ad)
    {
        $ad->delete();
        return response()->json(['message' => 'Ad deleted successfully']);
    }

    public function search(Request $request)
    {
        $query = $request->input('title');

        $ads = Ad::where('title', 'like', "%{$query}%")->latest()->get();

        return response()->json($ads);
    }
}
