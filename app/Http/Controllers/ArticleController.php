<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('user')
            ->where('status', 'published')
            ->latest()
            ->paginate(9);

        return view('articles.index', compact('articles'));
    }

    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'status' => 'in:draft,published',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $uploaded = Cloudinary::upload($request->file('cover_image')->getRealPath());
            $coverPath = $uploaded->getSecurePath();
        }

        $article = auth()->user()->articles()->create([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']) . '-' . Str::random(5),
            'body' => $data['body'],
            'status' => $data['status'] ?? 'published',
            'cover_image' => $coverPath,
        ]);

        return redirect()->route('articles.show', $article)
            ->with('success', 'Article created successfully.');
    }

    public function edit(Article $article)
    {
        $this->authorizeEdit($article);
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $this->authorizeEdit($article);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'status' => 'in:draft,published',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        if ($request->hasFile('cover_image')) {
            $uploaded = Cloudinary::upload($request->file('cover_image')->getRealPath());
            $data['cover_image'] = $uploaded->getSecurePath();
        } else {
            unset($data['cover_image']);
        }

        $article->update($data);

        return redirect()->route('articles.show', $article)
            ->with('success', 'Article updated.');
    }

    public function destroy(Article $article)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admins can delete articles.');
        }

        $article->delete();

        return redirect()->route('articles.index')
            ->with('success', 'Article deleted.');
    }

    private function authorizeEdit(Article $article): void
    {
        if (!auth()->user()->isAdmin() && $article->user_id !== auth()->id()) {
            abort(403);
        }
    }
}