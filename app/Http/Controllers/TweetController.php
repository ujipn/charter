<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $tweets = Tweet::with('user')->latest()->get();
    return view('tweets.index', compact('tweets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('tweets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'tweet' => 'required|max:255',
            'image' => 'nullable|image', // 画像のバリデーションルールを追加
        ]);
    
        if ($request->hasFile('image')) {
            
            $path = $request->file('image')->store('images', 'public'); // 画像を保存
            $request->user()->tweets()->create([
                'tweet' => $request->tweet,
                'image' => $path, // 画像のパスを保存
            ]);
        } else {
            $request->user()->tweets()->create($request->only('tweet'));
        }
      
          return redirect()->route('tweets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tweet $tweet)
    {
        //
        return view('tweets.show', compact('tweet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tweet $tweet)
    {
        //
        return view('tweets.edit', compact('tweet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tweet $tweet)
    {
        //
        $request->validate([
            'tweet' => 'required|max:255',
            'image' => 'nullable|image', // 画像のバリデーションルールを追加
        ]);
    
        $data = ['tweet' => $request->tweet];
    
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/images'); // 画像を保存
            $data['image'] = $path; // 画像のパスを保存
        }
    
        $tweet->update($data);
      
          return redirect()->route('tweets.show', $tweet);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tweet $tweet)
    {
        //
        $tweet->delete();

    return redirect()->route('tweets.index');
    }
}
