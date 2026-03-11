<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Poll;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'users' => User::count(),
            'articles' => Article::count(),
            'polls' => Poll::count(),
            'votes' => \App\Models\PollVote::count(),
        ];

        $recentUsers = User::latest()->take(5)->get();
        $recentArticles = Article::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentArticles'));
    }

    public function users()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function promoteUser(User $user)
    {
        $user->update(['role' => 'admin']);
        return back()->with('success', "{$user->name} is now an admin.");
    }

    public function demoteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Cannot demote yourself.']);
        }
        $user->update(['role' => 'user']);
        return back()->with('success', "{$user->name} demoted to user.");
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Cannot delete yourself.']);
        }
        $user->delete();
        return back()->with('success', 'User deleted.');
    }
}
