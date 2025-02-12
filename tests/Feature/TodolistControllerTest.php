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
}
