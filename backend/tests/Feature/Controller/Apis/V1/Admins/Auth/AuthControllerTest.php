<?php

namespace Tests\Feature\Controller\Apis\V1\Admins\Auth;

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
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'password',
        ];
        $response = $this->post(route('admins.register'), $params);

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
            'role' => User::ADMIN,
        ]);
    }

    public function testLogin()
    {
        $adminUser = User::factory()->adminUser()->create();
        $params = [
            'name' => 'admin',
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
        $adminUser = User::factory()->adminUser()->create();
        $token = $adminUser->createToken($adminUser->email)->plainTextToken;
        $response = $this->post(route('admins.logout'), [], [
            'Authorization' => "Bearer $token",
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $result = $response->json();
        $this->assertEquals(Response::HTTP_OK, $result['status']);
        $this->assertEquals('Success', $result['message']);
        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $adminUser->id,
            'name' => $adminUser->email,
        ]);
    }

    public function testMe()
    {
        $adminUser = User::factory()->adminUser()->create();
        $token = $adminUser->createToken($adminUser->email)->plainTextToken;
        $response = $this->get(route('admins.me'), [
            'Authorization' => "Bearer $token",
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $result = $response->json();
        $this->assertEquals(Response::HTTP_OK, $result['status']);
        $this->assertEquals('Success', $result['message']);
        $this->assertArrayHasKey('data', $result);
        $data = $result['data'];
        $this->assertEquals($adminUser->id, $data['id']);
        $this->assertEquals($adminUser->name, $data['name']);
        $this->assertEquals($adminUser->email, $data['email']);
        $this->assertEquals($adminUser->convertRoleString(), $data['role']);
    }
}
