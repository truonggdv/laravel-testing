<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class ValidationCreateUser extends TestCase
{
    // use RefreshDatabase; // Đảm bảo cơ sở dữ liệu được làm mới giữa các bài kiểm thử

    /** @test */
    public function it_validates_user_creation()
    {
        // Bỏ qua CSRF middleware cho bài kiểm thử này
        $response = $this->withoutMiddleware()->post('/user', [
            'name' => '',
            'email' => 'invalid-email',
            'password' => '123',
        ]);

        // Kiểm tra xem có redirect về đúng route hay không
        $response->assertRedirect('/user/create');
        // Kiểm tra xem có lỗi nào trong session hay không
        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    /** @test */
    public function it_creates_a_user()
    {
        // Bỏ qua CSRF middleware cho bài kiểm thử này
        $response = $this->withoutMiddleware()->post('/user', [
            'name' => 'truongdev19',
            'email' => 'truongdev19@gmail.com',
            'password' => '123@@123',
            'password_confirmation' => '123@@123',
        ]);

        // Kiểm tra xem dữ liệu có được lưu vào cơ sở dữ liệu hay không
        $this->assertDatabaseHas('users', [
            'name' => 'truongdev19',
            'email' => 'truongdev19@gmail.com',
        ]);
    }
}
