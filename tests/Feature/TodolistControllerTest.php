<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodolist()
    {
        $this->withSession([
            "user" => "tiawidi",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Todo1"
                ],
                [
                    "id" => "2",
                    "todo" => "Todo2"
                ],
            ]
        ])->get('/todolist')
            ->assertSeeText("1")
            ->assertSeeText("Todo1")
            ->assertSeeText("2")
            ->assertSeeText("Todo2");
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
            "todo" => "Todo1"
        ])->assertRedirect("/todolist");
    }
}
