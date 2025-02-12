<?php

namespace Tests\Feature;

use App\Services\TodolistService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Testing\Assert;
use Tests\TestCase;

class TodolistServiceTest extends TestCase
{
    private TodolistService $todolistService;

    protected function setUp(): void
    {
        parent::setUp();

        DB::delete("delete from todos");

        $this->todolistService = $this->app->make(TodolistService::class);
    }

    public function testTodolistNotNull()
    {
        self::assertNotNull($this->todolistService);
    }

    public function testSaveTodo()
    {
        $this->todolistService->saveTodo("1", "Todo");

        $todolist = $this->todolistService->getTodolist();
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
                "todo" => "Todo-1"
            ],
            [
                "id" => "2",
                "todo" => "Todo-2"
            ]
        ];

        $this->todolistService->saveTodo("1", "Todo-1");
        $this->todolistService->saveTodo("2", "Todo-2");

        // Assert::assertArraySubset()

        Assert::assertArraySubset($expect, $this->todolistService->getTodolist());
    }

    public function testRemoveTodo()
    {
        $this->todolistService->saveTodo("1", "Todo-1");
        $this->todolistService->saveTodo("2", "Todo-2");
        self::assertEquals(2, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo("1");
        self::assertEquals(1, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo("2");
        self::assertEquals(0, sizeof($this->todolistService->getTodolist()));
    }
}
