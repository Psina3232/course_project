<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ad;

class UserController extends Controller
{
    /**
     * Показать список объявлений пользователя.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Contracts\View\View
     */
    public function myAds(Request $request)
    {
        $user = Auth::user();
        $ads = $user->ads()->latest()->get();

        if ($request->wantsJson()) {
            return response()->json($ads);
        }

        return view('user.my_ads', compact('ads'));
    }

    /**
     * Добавить объявление в избранное.
     *
     * @param  int  $adId
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function addFavorite($adId, Request $request)
    {
        $user = auth()->user();
        $ad = Ad::findOrFail($adId);

        $user->favorites()->attach($adId);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Ad added to favorites'
            ], 200);
        }

        return redirect()->route('ads.show', $adId);
    }

    /**
     * Удалить объявление из избранного.
     *
     * @param  int  $adId
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function removeFavorite($adId, Request $request)
    {
        $user = auth()->user();
        $ad = Ad::findOrFail($adId);

        $user->favorites()->detach($adId);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Ad removed from favorites'
            ], 200);
        }

        return redirect()->route('ads.show', $adId);
    }

    /**
     * Получить список избранных объявлений пользователя.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Contracts\View\View
     */
    public function favoriteAds(Request $request)
    {
        $user = auth()->user();
        $favorites = $user->favorites()->latest()->get();

        if ($request->wantsJson()) {
            return response()->json([
                'favorites' => $favorites
            ]);
        }

        return view('user.favorites', compact('favorites'));
    }
}