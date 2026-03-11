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
        $admin = User::firstOrCreate(
            ['email' => 'admin@void.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $user = User::firstOrCreate(
            ['email' => 'user@void.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        if ($admin->articles()->count() === 0) {
            $articles = [
                ['title' => 'The Architecture of Silence', 'body' => "There is power in restraint.", 'status' => 'published'],
                ['title' => 'On the Tyranny of the Grid', 'body' => "Grids are lies we tell ourselves about control.", 'status' => 'published'],
                ['title' => 'Minimal Is Not Empty', 'body' => "True minimalism is a form of extreme precision.", 'status' => 'published'],
            ];

            foreach ($articles as $data) {
                $admin->articles()->create(array_merge($data, [
                    'slug' => \Illuminate\Support\Str::slug($data['title']) . '-' . \Illuminate\Support\Str::random(5),
                ]));
            }
        }

        if (Poll::count() === 0) {
            $poll = $admin->polls()->create([
                'question' => 'What defines good design in 2024?',
                'is_active' => true,
            ]);
            foreach (['Restraint and precision', 'Bold and expressive', 'Function over form', 'System thinking'] as $label) {
                $poll->options()->create(['label' => $label]);
            }
        }
    }
}