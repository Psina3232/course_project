<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;

class AdController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Ad::query()->latest();

        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        $ads = $query->get();

        return view('ads.index', compact('ads'));
    }

    public function create()
    {
        return view('ads.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        $ad = new Ad($request->all());
        $ad->user_id = auth()->id();
        $ad->save();

        return redirect()->route('ads.index');
    }

    public function show($id)
    {
        $ad = Ad::findOrFail($id);
        return view('ads.show', compact('ad'));
    }

    public function edit($id)
    {
        $ad = Ad::findOrFail($id);

        if ($ad->user_id !== auth()->id()) {
            return redirect()->route('ads.index')->with('error', 'У вас нет прав для редактирования этого объявления');
        }

        return view('ads.edit', compact('ad'));
    }

    public function update(Request $request, $id)
    {
        $ad = Ad::findOrFail($id);

        if ($ad->user_id !== auth()->id()) {
            return redirect()->route('ads.index')->with('error', 'У вас нет прав для редактирования этого объявления');
        }

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        $ad->update($request->all());

        return redirect()->route('ads.show', $ad->id);
    }

    public function destroy($id)
    {
        $ad = Ad::findOrFail($id);

        if ($ad->user_id !== auth()->id()) {
            return redirect()->route('ads.index')->with('error', 'У вас нет прав для удаления этого объявления');
        }

        $ad->delete();

        return redirect()->route('ads.index');
    }

    public function myAds()
{
    $ads = auth()->user()->ads()->latest()->get();
    return view('my_ads', compact('ads'));
}

}
