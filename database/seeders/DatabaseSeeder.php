<?php

namespace Database\Seeders;

use App\Models\Poll;
use App\Models\User;
use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@void.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create regular user
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'user@void.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Sample articles
        $articles = [
            [
                'title' => 'The Architecture of Silence',
                'body' => "There is power in restraint. In a world saturated with noise — notifications, opinions, content — silence has become the rarest luxury and the most radical statement.\n\nWhen Kanye released Yeezus with nearly no promotional campaign, he wasn't being enigmatic. He was being precise. The absence of explanation forces confrontation. You either receive it or you don't.\n\nDesign operates the same way. The most powerful spaces are those that know what to leave out. Every unnecessary element is a distraction from meaning. Every extra word dilutes the message.\n\nStrip it back. Find the core. Let that breathe.",
                'status' => 'published',
            ],
            [
                'title' => 'On the Tyranny of the Grid',
                'body' => "Grids are lies we tell ourselves about control. The world doesn't organize itself into columns. Mountains don't align to a baseline grid. Rivers don't respect gutters.\n\nYet we build systems — design systems, organizational systems, belief systems — that demand everything fit neatly into predefined containers.\n\nThe breakthrough moment in any creative work is when you realize the grid is a suggestion, not a law. That's when the work becomes alive.",
                'status' => 'published',
            ],
            [
                'title' => 'Minimal Is Not Empty',
                'body' => "There's a misconception that minimalism means absence. That fewer things means less thought. That restraint is the same as emptiness.\n\nTrue minimalism is a form of extreme precision. Every element that remains has survived a process of ruthless editing. What you see is what could not be removed without losing the essential thing.\n\nEmpty is nothing. Minimal is everything distilled.",
                'status' => 'published',
            ],
        ];

        foreach ($articles as $data) {
            $admin->articles()->create(array_merge($data, [
                'slug' => \Illuminate\Support\Str::slug($data['title']) . '-' . \Illuminate\Support\Str::random(5),
            ]));
        }

        $user->articles()->create([
            'title' => 'First Thoughts on Void',
            'slug' => 'first-thoughts-on-void-' . \Illuminate\Support\Str::random(5),
            'body' => "Just joined this platform. Something about the aesthetic feels right — like the design isn't trying to compete with the words. It just holds them.\n\nMost platforms want to be the main character. This one steps back. I appreciate that.",
            'status' => 'published',
        ]);

        // Sample poll
        $poll = $admin->polls()->create([
            'question' => 'What defines good design in 2024?',
            'is_active' => true,
        ]);

        $options = ['Restraint and precision', 'Bold and expressive', 'Function over form', 'System thinking'];
        foreach ($options as $label) {
            $poll->options()->create(['label' => $label]);
        }
    }
}
