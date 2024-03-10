<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Note;
use App\Models\User;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::get()->each(function (User $user){
            Note::factory()->count(10)->create([
                'user_id' => $user->id
            ]);
        });
    }
}
