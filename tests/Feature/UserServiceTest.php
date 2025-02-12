<?php

namespace Tests\Feature;

use App\Services\UserService;
use Database\Seeders\UserSeed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();

        DB::delete("delete from users");

        $this->userService = $this->app->make(UserService::class);
    }

    public function testLoginSuccess()
    {
        $this->seed(UserSeed::class);
        self::assertTrue($this->userService->login('tiawidi@localhost', '1234'));
    }

    public function testLoginUserNotFound()
    {
        self::assertFalse($this->userService->login("test", "test"));
    }

    public function testLoginWrongPassword()
    {
        self::assertFalse($this->userService->login('tiawidi', '1111'));
    }
}
