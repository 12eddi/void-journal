<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PollOption extends Model
{
    protected $fillable = ['poll_id', 'label'];

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    public function votes()
    {
        return $this->hasMany(PollVote::class);
    }

    public function voteCount(): int
    {
        return $this->votes()->count();
    }

    public function percentage(int $total): float
    {
        if ($total === 0) return 0;
        return round(($this->votes()->count() / $total) * 100, 1);
    }
}
