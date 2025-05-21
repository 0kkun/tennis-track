<?php

namespace Tests\Feature\Middleware;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class BasicAuthenticateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Route::middleware('basic.auth')->get('/test-basic-auth', function () {
            return response('認証成功', 200);
        });
    }

    /**
     * @dataProvider basicAuthDataProvider
     */
    public function testBasicAuth(array $data, array $expected)
    {
        $headers = [];

        if (isset($data['auth'])) {
            $headers['Authorization'] = 'Basic '.base64_encode($data['auth']);
        }

        $response = $this->get('/test-basic-auth', $headers);

        $response->assertStatus($expected['status']);

        if (isset($expected['body'])) {
            $response->assertSee($expected['body']);
        }

        foreach ($expected['headers'] as $header => $value) {
            $response->assertHeader($header, $value);
        }
    }

    public function basicAuthDataProvider(): array
    {
        return [
            '正常' => [
                'data' => [
                    'auth' => 'testuser:testpass',
                ],
                'expected' => [
                    'status' => 200,
                    'headers' => [],
                    'body' => '認証成功',
                ],
            ],
            '未認証' => [
                'data' => [],
                'expected' => [
                    'status' => 401,
                    'headers' => [
                        'WWW-Authenticate' => 'Basic realm="Sample Private Page"',
                    ],
                    'body' => 'Enter username and password.',
                ],
            ],
            '認証失敗（誤パスワード）' => [
                'data' => [
                    'auth' => 'testuser:wrongpass',
                ],
                'expected' => [
                    'status' => 401,
                    'headers' => [
                        'WWW-Authenticate' => 'Basic realm="Sample Private Page"',
                    ],
                    'body' => 'Enter username and password.',
                ],
            ],
            '認証失敗（誤ユーザー）' => [
                'data' => [
                    'auth' => 'wronguser:testpass',
                ],
                'expected' => [
                    'status' => 401,
                    'headers' => [
                        'WWW-Authenticate' => 'Basic realm="Sample Private Page"',
                    ],
                    'body' => 'Enter username and password.',
                ],
            ],
        ];
    }
}
