<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Article $article)
    {
        $data = $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $article->comments()->create([
            'user_id' => auth()->id(),
            'body' => $data['body'],
        ]);

        return back()->with('success', 'Comment posted.');
    }

    public function destroy(Comment $comment)
    {
        if (!auth()->user()->isAdmin() && $comment->user_id !== auth()->id()) {
            abort(403);
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted.');
    }
}