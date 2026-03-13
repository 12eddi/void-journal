<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['article_id', 'user_id', 'body'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function likes()
{
    return $this->morphMany(\App\Models\Like::class, 'likeable');
}

public function isLikedBy($user): bool
{
    if (!$user) return false;
    return $this->likes()->where('user_id', $user->id)->exists();
}

}