<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Http;

class ArticleController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::latest()->get();

        $pokemon = null;
        try {
            $randomId = rand(1, 151);
            $response = Http::get("https://pokeapi.co/api/v2/pokemon/{$randomId}");
            if ($response->successful()) {
                $pokemon = $response->json();
            }
        } catch (\Exception $e) {
            \Log::error("Error: " . $e->getMessage());
        }

        return view('articles.index', compact('articles', 'pokemon'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Article::class);
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Article::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Article::create($validated);

        return redirect()->route('articles.index')->with('success', 'Статья была создана!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $this->authorize('update', $article);
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $this->authorize('update', $article);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $article->update($validated);

        return redirect()->route('articles.index')->with('success', 'Статья была обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Статья была удалена!');
    }

//    public function checkTitle(Request $request)
//    {
//        $title = $request->query('title');
//
//        $exists = Article::where('title', $title)->exists();
//
//        return response()->json([
//            'available' => !$exists
//        ]);
//    }
}
