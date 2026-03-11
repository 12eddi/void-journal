<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\PollVote;
use Illuminate\Http\Request;

class PollController extends Controller
{
    public function index()
    {
        $polls = Poll::with(['options.votes', 'votes'])
            ->where('is_active', true)
            ->latest()
            ->paginate(6);

        return view('polls.index', compact('polls'));
    }

    public function show(Poll $poll)
    {
        $poll->load('options.votes', 'votes', 'user');
        return view('polls.show', compact('poll'));
    }

    public function create()
    {
        abort_unless(auth()->check(), 401);
        return view('polls.create');
    }

    public function store(Request $request)
    {
        abort_unless(auth()->check(), 401);

        $data = $request->validate([
            'question' => 'required|string|max:500',
            'options' => 'required|array|min:2|max:6',
            'options.*' => 'required|string|max:200',
            'ends_at' => 'nullable|date|after:now',
        ]);

        $poll = auth()->user()->polls()->create([
            'question' => $data['question'],
            'ends_at' => $data['ends_at'] ?? null,
            'is_active' => true,
        ]);

        foreach ($data['options'] as $label) {
            $poll->options()->create(['label' => $label]);
        }

        return redirect()->route('polls.show', $poll)
            ->with('success', 'Poll created!');
    }

    public function vote(Request $request, Poll $poll)
    {
        abort_unless(auth()->check(), 401);

        if ($poll->hasVoted(auth()->user())) {
            return back()->withErrors(['vote' => 'You have already voted.']);
        }

        if ($poll->isExpired() || !$poll->is_active) {
            return back()->withErrors(['vote' => 'This poll is no longer active.']);
        }

        $data = $request->validate([
            'option_id' => 'required|exists:poll_options,id',
        ]);

        // Verify the option belongs to this poll
        $option = $poll->options()->findOrFail($data['option_id']);

        PollVote::create([
            'poll_id' => $poll->id,
            'poll_option_id' => $option->id,
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Vote cast!');
    }

    public function destroy(Poll $poll)
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        $poll->delete();
        return redirect()->route('polls.index')->with('success', 'Poll deleted.');
    }
}
