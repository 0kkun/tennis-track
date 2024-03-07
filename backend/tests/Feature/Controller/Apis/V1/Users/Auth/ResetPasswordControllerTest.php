<?php

namespace Tests\Feature\Controller\Apis\V1\Users\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ResetPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccess()
    {
        $user = User::factory()->generalUser()->create();
        $token = Password::createToken($user);
        $params = [
            'email' => $user->email,
            'password' => 'new_password',
            'token' => $token,
        ];
        $response = $this->post(route('password.reset'), $params);

        $response->assertStatus(Response::HTTP_OK);
        $result = $response->json();
        $this->assertEquals(Response::HTTP_OK, $result['status']);
        $this->assertEquals('Success', $result['message']);
    }

    public function testInvalidToken()
    {
        $user = User::factory()->generalUser()->create();
        $params = [
            'email' => $user->email,
            'password' => 'new_password',
            'password_confirmation' => 'new_password',
            'token' => 'invalid_token',
        ];
        $response = $this->post(route('password.reset'), $params);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $result = $response->json();
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $result['status']);
    }

    public function testNotExistsEmail()
    {
        $params = [
            'email' => 'test@example.com',
            'password' => 'new_password',
            'token' => 'token',
        ];
        $response = $this->post(route('password.reset'), $params);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $result = $response->json();
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $result['status']);
    }
}
