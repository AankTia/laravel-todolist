<?php

namespace App\Services;

interface TodolistService
{
    function saveTodo(string $id, string $todo): void;
}
