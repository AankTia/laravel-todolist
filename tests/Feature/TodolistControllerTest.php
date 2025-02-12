<?php

namespace Tests\Feature;

use Database\Seeders\TodoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        DB::delete("delete from todos");
    }

    public function testTodolist()
    {
        $this->seed(TodoSeeder::class);

        $this->withSession([
            "user" => "tiawidi",
        ])->get('/todolist')
            ->assertSeeText("1")
            ->assertSeeText("Todo-1")
            ->assertSeeText("2")
            ->assertSeeText("Todo-2");
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            "user" => "tiawidi"
        ])->post("/todolist", [])
            ->assertSeeText("Todo is required");
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            "user" => "tiawidi"
        ])->post("/todolist", [
            "todo" => "Todo-1"
        ])->assertRedirect("/todolist");
    }

    public function testRemoveTodolist()
    {
        $this->withSession([
            "user" => "tiawidi",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Todo-1"
                ],
                [
                    "id" => "2",
                    "todo" => "Todo-2"
                ],
            ]
        ])->post("/todolist/1/delete")
            ->assertRedirect("/todolist");
    }
}
