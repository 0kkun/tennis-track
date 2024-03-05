<?php

namespace Tests\Feature\Request\Admins\Auth;

use App\Http\Requests\Admins\Auth\RegisterRequest;
use Tests\TestCase;

class RegisterRequestTest extends TestCase
{
    public function testValidationPasses()
    {
        $request = new RegisterRequest();
        $validator = $this->app['validator']->make([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
        ], $request->rules());

        $this->assertTrue($validator->passes());
    }

    /**
     * @dataProvider validationFailsDataProvider
     */
    public function testValidationFails()
    {
        $request = new RegisterRequest();

        $validator = $this->app['validator']->make([
            'name' => '',
            'email' => 'invalid_email',
            'password' => 'short',
        ], $request->rules());

        $this->assertFalse($validator->passes());
    }

    public function validationFailsDataProvider()
    {
        return [
            'nameが空' => [
                'params' => [
                    'name' => '',
                    'email' => 'admin@example.com',
                    'password' => 'password',
                ],
            ],
            'emailが不正' => [
                'params' => [
                    'name' => 'admin',
                    'email' => 'invalid_email',
                    'password' => 'password',
                ],
            ],
            'emailが空' => [
                'params' => [
                    'name' => 'admin',
                    'email' => '',
                    'password' => 'password',
                ],
            ],
            'passwordが短い' => [
                'params' => [
                    'name' => 'admin',
                    'email' => 'admin@example.com',
                    'password' => 'short',
                ],
            ],
            'passwordが空' => [
                'params' => [
                    'name' => 'admin',
                    'email' => 'admin@example.com',
                    'password' => '',
                ],
            ],
        ];
    }
}
