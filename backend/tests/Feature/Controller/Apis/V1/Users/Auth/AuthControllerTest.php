<?php

namespace Tests\Feature\Controller\Apis\V1\Users\Auth;

use App\Eloquents\EloquentUser;
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
        ]);
    }

    public function testLogin()
    {
        $user = EloquentUser::factory()->create();
        $params = [
            'email' => $user->email,
            'password' => 'password',
        ];
        $response = $this->post(route('users.login'), $params);

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
        $user = EloquentUser::factory()->create();
        $token = $user->createToken($user->email)->plainTextToken;
        $response = $this->delete(route('users.logout'), [], [
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
        $user = EloquentUser::factory()->create();
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
    }
}
