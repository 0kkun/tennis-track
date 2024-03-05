<?php

namespace Tests\Feature\Controller\Apis\V1\Users\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRegister()
    {
        $params = [
            'name' => 'user',
            'email' => 'user@example.com',
            'password' => 'password',
        ];
        $response = $this->post(route('users.register'), $params);

        $response->assertStatus(Response::HTTP_OK);
        $result = $response->json();
        $this->assertEquals(Response::HTTP_OK, $result['status']);
        $this->assertEquals('Success', $result['message']);
        $this->assertArrayHasKey('data', $result);
        $data = $result['data'];
        $this->assertArrayHasKey('token', $data);
        $this->assertNotNull($data['token']);
        $this->assertDatabaseHas('users', [
            'name' => $params['name'],
            'email' => $params['email'],
            'role' => User::GENERAL,
        ]);
    }

    public function testLogin()
    {
        $adminUser = User::factory()->generalUser()->create();
        $params = [
            'name' => 'user',
            'email' => $adminUser->email,
            'password' => 'password',
        ];
        $response = $this->post(route('admins.login'), $params);

        $response->assertStatus(Response::HTTP_OK);
        $result = $response->json();
        $this->assertEquals(Response::HTTP_OK, $result['status']);
        $this->assertEquals('Success', $result['message']);
        $this->assertArrayHasKey('data', $result);
        $data = $result['data'];
        $this->assertArrayHasKey('token', $data);
        $this->assertNotNull($data['token']);
    }

    public function testLogout()
    {
        $user = User::factory()->adminUser()->create();
        $token = $user->createToken($user->email)->plainTextToken;
        $response = $this->post(route('users.logout'), [], [
            'Authorization' => "Bearer $token",
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $result = $response->json();
        $this->assertEquals(Response::HTTP_OK, $result['status']);
        $this->assertEquals('Success', $result['message']);
        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'name' => $user->email,
        ]);
    }

    public function testMe()
    {
        $user = User::factory()->generalUser()->create();
        $token = $user->createToken($user->email)->plainTextToken;
        $response = $this->get(route('users.me'), [
            'Authorization' => "Bearer $token",
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $result = $response->json();
        $this->assertEquals(Response::HTTP_OK, $result['status']);
        $this->assertEquals('Success', $result['message']);
        $this->assertArrayHasKey('data', $result);
        $data = $result['data'];
        $this->assertEquals($user->id, $data['id']);
        $this->assertEquals($user->name, $data['name']);
        $this->assertEquals($user->email, $data['email']);
        $this->assertEquals($user->convertRoleString(), $data['role']);
    }
}
