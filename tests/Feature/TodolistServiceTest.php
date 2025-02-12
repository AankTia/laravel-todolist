<?php

namespace Tests\Feature;

use App\Services\TodolistService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TodolistServiceTest extends TestCase
{
    private TodolistService $todolistService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->todolistService = $this->app->make(TodolistService::class);
    }

    public function testTodolistNotNull()
    {
        self::assertNotNull($this->todolistService);
    }

    public function testSaveTodo()
    {
        $this->todolistService->saveTodo("1", "Todo");

        $todolist = Session::get("todolist");
        foreach ($todolist as $value) {
            self::assertEquals("1", $value['id']);
            self::assertEquals("Todo", $value['todo']);
        }
    }

    public function testGetTodolistEmpty()
    {
        $expect = [
            [
                "id" => "1",
                "todo" => "Todo1"
            ],
            [
                "id" => "2",
                "todo" => "Todo2"
            ]
        ];

        $this->todolistService->saveTodo("1", "Todo1");
        $this->todolistService->saveTodo("2", "Todo2");

        self::assertEquals($expect, $this->todolistService->getTodolist());
    }
}
