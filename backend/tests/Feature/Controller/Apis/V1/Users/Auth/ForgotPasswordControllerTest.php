<?php

namespace Tests\Feature\Controller\Apis\V1\Users\Auth;

use App\Models\User;
use App\Notifications\Auth\ResetPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgotPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccess()
    {
        Notification::fake();

        $user = User::factory()->generalUser()->create();
        $params = [
            'email' => $user->email,
        ];
        $response = $this->post(route('password.forgot'), $params);

        $response->assertStatus(Response::HTTP_OK);
        $result = $response->json();
        $this->assertEquals(Response::HTTP_OK, $result['status']);
        $this->assertEquals('Success', $result['message']);

        Notification::assertSentTo(
            [$user], ResetPasswordNotification::class
        );
    }

    public function testNotExistsEmail()
    {
        Notification::fake();

        $params = [
            'email' => 'test@example.com',
        ];
        $response = $this->post(route('password.forgot'), $params);
        $response->assertStatus(422);
        $result = $response->json();
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $result['status']);
        Notification::assertNothingSent();
    }
}
