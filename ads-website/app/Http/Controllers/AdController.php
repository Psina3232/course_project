<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdController extends Controller
{

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
        $ad->user_id = auth()->id();
    
        $ad->save();

        if ($request->wantsJson()) {
            return response()->json($ad, 201);
        }

        return redirect()->route('ads.index');
    }

    public function create()
{
    return view('ads.create');
}

    public function index(Request $request)
    {
        $ads = Ad::all();

        if ($request->wantsJson()) {
            return response()->json($ads);
        }

        return view('ads.index', compact('ads'));
    }

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

    public function update(Request $request, Ad $ad)
{
    if ($ad->user_id != auth()->id() && !auth()->user()->isAdmin()) {
        return response()->json(['message' => 'You are not authorized to edit this ad'], 403);
    }

    $validated = $request->validate([
        'title' => 'sometimes|string|max:255',
        'description' => 'sometimes|string',
        'price' => 'sometimes|numeric',
    ]);

    $ad->update($validated);

    if ($request->wantsJson()) {
        return response()->json([
            'data' => $ad
        ]);
    }

    return redirect()->route('ads.show', $ad->id);
}


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