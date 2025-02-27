<?php

namespace Database\Seeders;

use App\Models\Todo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $todo = new Todo();
        $todo->id = "1";
        $todo->todo = "Todo-1";
        $todo->save();

        $todo = new Todo();
        $todo->id = "2";
        $todo->todo = "Todo-2";
        $todo->save();
    }
}
