<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateUser extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // use RefreshDatabase;
     /** @test */
     public function it_shows_create_user_form()
     {
         $response = $this->get('/user/create');
         $response->assertStatus(200);
         $response->assertSee('Create User');
     }
    /** @test */
    public function it_creates_user_and_redirects()
    {
        // Bỏ qua middleware CSRF cho bài kiểm thử này
        $response = $this->withoutMiddleware()->post('/user', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/user/create');
        $response->assertSessionHas('success', 'Tạo thành viên thành công.');
    }
}
