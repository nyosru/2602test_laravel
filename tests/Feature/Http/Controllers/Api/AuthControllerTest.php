<?php

namespace Tests\Feature\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Auth\AuthController;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use Mockery;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    private $userServiceMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userServiceMock = Mockery::mock(UserService::class);
        $this->app->instance(UserService::class, $this->userServiceMock);
    }

    public function test_login_success_returns_token_and_user()
    {
        $data = [
            'email' => 'test@example.com',
            'password' => 'password123'
        ];

        $user = User::factory()->create($data);

        $token = 'test-token-123';
        $this->userServiceMock
            ->shouldReceive('login')
            ->once()
            ->with($data)
            ->andReturn([
                'token' => $token,
                'user' => $user
            ]);

        $response = $this->postJson('/api/login', $data);
        dump([
            'status' => $response->status(),
            'body' => $response->json()
        ]);

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'token',
                    'user' => ['id', 'name', 'email']
                ],
                'code'
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Успешный вход',
                'code' => 200
            ]);
    }

    public function test_login_invalid_credentials_throws_validation_exception()
    {
        $data = [
            'email' => 'invalid@example.com',
            'password' => 'wrong'
        ];

        $this->userServiceMock
            ->shouldReceive('login')
            ->once()
            ->with($data)
            ->andReturn(null);

        $response = $this->postJson('/api/login', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_login_validation_fails_for_invalid_email()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'invalid-email',
            'password' => 'password'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

//    public function test_register_success_creates_user_and_returns_token()
//    {
//        $data = [
//            'name' => 'New User',
//            'email' => 'new@example.com',
//            'password' => 'password123',
//            'password_confirmation' => 'password123'
//        ];
//
//        // ✅ Создаем объект User
//        $user = User::create([
//            'name' => $data['name'],
//            'email' => $data['email'],
//            'password' => bcrypt('password123'),
//        ]);
//
//        $token = 'new-token-456';
//
//        // ✅ Mock ожидает ТОЛЬКО валидированные данные (БЕЗ password_confirmation)
//        // ✅ Возвращает ПОЛНЫЙ результат с 'user'
//        $this->userServiceMock
//            ->shouldReceive('register')
//            ->once()
//            ->with([
//                'name' => $data['name'],
//                'email' => $data['email'],
//                'password' => $data['password']
//            ])  // ← Laravel удалит password_confirmation после валидации
//            ->andReturn([
//                'token' => $token,
//                'user' => $user  // ← Обязательно!
//            ]);
//
//        $response = $this->postJson('/api/register', $data);
//
//        $response->assertCreated()
//            ->assertJsonStructure([
//                'success', 'data' => ['token', 'user' => ['id', 'name', 'email']], 'message', 'code'
//            ])
//            ->assertJson([
//                'success' => true,
//                'message' => 'Успешная регистрация',
//                'code' => 201
//            ]);
//    }


    public function test_register_validation_fails_for_duplicate_email()
    {
        $email = 'duplicate@example.com';

        $existingUser = User::factory()->create(['email' => $email]);

        $response = $this->postJson('/api/register', [
            'name' => 'Test',
            'email' => $email,
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_register_validation_fails_for_password_mismatch()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }

    public function test_logout_calls_user_service_and_returns_success()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->userServiceMock
            ->shouldReceive('logout')
            ->once()
            ->with($user);

        $response = $this->postJson('/api/logout');

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Успешный выход'
            ]);
    }

    public function test_user_returns_current_user_info()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->userServiceMock
            ->shouldReceive('getCurrentUser')
            ->once()
            ->with($user)
            ->andReturn($user);

        $response = $this->getJson('/api/user');
        dump($response->json());


        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Информация о пользователе'
            ])
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    public function test_user_requires_authentication()
    {
        $response = $this->getJson('/api/user');

        $response->assertUnauthorized();
    }

    public function test_logout_requires_authentication()
    {
        $response = $this->postJson('/api/logout');

        $response->assertUnauthorized();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
