<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggleArticle(Article $article)
    {
        $existing = Like::where('user_id', auth()->id())
            ->where('likeable_id', $article->id)
            ->where('likeable_type', Article::class)
            ->first();

        if ($existing) {
            $existing->delete();
        } else {
            Like::create([
                'user_id' => auth()->id(),
                'likeable_id' => $article->id,
                'likeable_type' => Article::class,
            ]);
        }

        return back();
    }

    public function toggleComment(Comment $comment)
    {
        $existing = Like::where('user_id', auth()->id())
            ->where('likeable_id', $comment->id)
            ->where('likeable_type', Comment::class)
            ->first();

        if ($existing) {
            $existing->delete();
        } else {
            Like::create([
                'user_id' => auth()->id(),
                'likeable_id' => $comment->id,
                'likeable_type' => Comment::class,
            ]);
        }

        return back();
    }
}