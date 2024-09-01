<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ad;

class UserController extends Controller
{
    public function myAds()
    {
        $user = Auth::user();

        $ads = $user->ads()->latest()->get();

        return response()->json($ads);
    }

    public function addFavorite($adId)
    {
        $user = auth()->user();
        $ad = Ad::findOrFail($adId);

        // Добавляем объявление в избранное
        $user->favorites()->attach($adId);

        return response()->json([
            'message' => 'Ad added to favorites'
        ], 200);
    }

    /**
     * Удалить объявление из избранного.
     *
     * @param  int  $adId
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeFavorite($adId)
    {
        $user = auth()->user();
        $ad = Ad::findOrFail($adId);

        // Удаляем объявление из избранного
        $user->favorites()->detach($adId);

        return response()->json([
            'message' => 'Ad removed from favorites'
        ], 200);
    }

    /**
     * Получить список избранных объявлений пользователя.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function favoriteAds()
    {
        $user = auth()->user();
        $favorites = $user->favorites()->latest()->get();

        return response()->json([
            'favorites' => $favorites
        ]);
    }
}
