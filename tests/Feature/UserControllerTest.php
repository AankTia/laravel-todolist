<?php

namespace Tests\Feature;

use Database\Seeders\UserSeed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        DB::delete("delete from users");
    }
    public function testLoginPage()
    {
        $this->get('/login')
            ->assertSeeText("Login");
    }

    public function testLoginPageForMember()
    {
        $this->withSession([
            "user" => "tiawidi",
            "password" => "1234"
        ])->get('/login')
            ->assertRedirect("/");
    }

    public function testLoginSuccess()
    {
        $this->seed(UserSeed::class);

        $this->post('/login', [
            "user" => "tiawidi@localhost",
            "password" => "1234"
        ])->assertRedirect("/")
            ->assertSessionHas("user", "tiawidi@localhost");
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            "user" => "tiawidi"
        ])->post('/login', [
            "user" => "tiawidi",
            "password" => "1234"
        ])->assertRedirect("/");
    }

    public function testLoginValidationError()
    {
        $this->post("/login", [])
            ->assertSeeText("User or password is required");
    }

    public function testLoginFailed()
    {
        $this->post('/login', [
            "user" => "tiawidi",
            "password" => "1111"
        ])->assertSeeText("User or password wrong!");
    }

    public function testLogout()
    {
        $this->withSession([
            "user" => "tiawidi"
        ])->post('/logout')
            ->assertRedirect("/")
            ->assertSessionMissing("user");
    }

    public function testLogoutGuest()
    {
        $this->post('/logout')
            ->assertRedirect("/");
    }
}
