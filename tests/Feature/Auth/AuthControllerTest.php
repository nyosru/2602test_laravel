<?php

namespace Feature\Auth;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\UsesContainerForControllers;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{

    use RefreshDatabase;
    use UsesContainerForControllers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userServiceMock = $this->mock(UserService::class);
        $this->app->instance(UserService::class, $this->userServiceMock);
    }

//    /**
//     * A basic feature test example.
//     */
//    public function test_example(): void
//    {
//        $response = $this->get('/');
//
//        $response->assertStatus(200);
//    }
//
//    /** @test */
//    public function user_can_register_with_valid_data()
//    {
//        $data = [
//            'name'                  => 'Иван Петров',
//            'email'                 => 'ivan@example.com',
//            'password'              => 'password123',
//            'password_confirmation' => 'password123',
//        ];
//
//        $fakeUser = User::factory()->make([
////            'id'    => 999,
//            'name'  => $data['name'],
//            'email' => $data['email'],
//        ]);
//
//        $this->userServiceMock
//            ->shouldReceive('register')
//            ->with($data)
//            ->once()
//            ->andReturn([
//                'user'  => $fakeUser,
//                'token' => 'fake-token-1234567890',
//            ]);
//
//        $response = $this->postJson('/api/register', $data);
//
////        $response
////            ->assertStatus(201)
////            ->assertJsonStructure([
////                'success',
////                'data' => [
////                    'token',
////                    'user' => ['id', 'name', 'email'],
////                ],
////                'message',
////                'code',
////            ])
////            ->assertJson([
////                'success' => true,
////                'data'    => [
////                    'token' => 'fake-token-1234567890',
////                    'user'  => [
////                        'id'    => 999,
////                        'name'  => 'Иван Петров',
////                        'email' => 'ivan@example.com',
////                    ],
////                ],
////                'message' => 'Успешная регистрация',
////                'code'    => 201,
////            ]);
//
//        $this->assertDatabaseHas('users', [
//            'email' => 'ivan@example.com',
//            'name'  => 'Иван Петров',
//        ]);
//    }

}
