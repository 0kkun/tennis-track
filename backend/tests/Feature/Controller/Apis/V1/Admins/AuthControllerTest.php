<?php

namespace Tests\Feature\Controller\Apis\V1\Admins\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use App\Models\User;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    private $adminUser;

    public function setUp(): void
    {
        parent::setUp();
        // $this->createTestData();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @dataProvider registerDataProvider
     */
    public function testRegister(array $params)
    {
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

    public function registerDataProvider()
    {
        return [
            '正常系' => [
                'params' => [
                    'name' => 'admin',
                    'email' => 'admin@example.com',
                    'password' => 'password',
                ],
            ],
        ];
    }

    // private function createTestData()
    // {
    //     $this->adminUser = User::factory()->adminUser()->create();
    // }
}
