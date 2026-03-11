<?php

namespace Tests\Feature\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

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

    public function testLoginSuccessReturnsTokenAndUser()
    {
        $data = [
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        $user = User::factory()->create($data);

        $token = 'test-token-123';
        $this->userServiceMock
            ->shouldReceive('login')
            ->once()
            ->with($data)
            ->andReturn([
                'token' => $token,
                'user' => $user,
            ]);

        $response = $this->postJson('/api/login', $data);
        dump([
            'status' => $response->status(),
            'body' => $response->json(),
        ]);

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'token',
                    'user' => ['id', 'name', 'email'],
                ],
                'code',
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Успешный вход',
                'code' => 200,
            ]);
    }

    public function testLoginInvalidCredentialsThrowsValidationException()
    {
        $data = [
            'email' => 'invalid@example.com',
            'password' => 'wrong',
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

    public function testLoginValidationFailsForInvalidEmail()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'invalid-email',
            'password' => 'password',
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

    public function testRegisterValidationFailsForDuplicateEmail()
    {
        $email = 'duplicate@example.com';

        $existingUser = User::factory()->create(['email' => $email]);

        $response = $this->postJson('/api/register', [
            'name' => 'Test',
            'email' => $email,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function testRegisterValidationFailsForPasswordMismatch()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }

    public function testLogoutCallsUserServiceAndReturnsSuccess()
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
                'message' => 'Успешный выход',
            ]);
    }

    public function testUserReturnsCurrentUserInfo()
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
                'message' => 'Информация о пользователе',
            ])
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    public function testUserRequiresAuthentication()
    {
        $response = $this->getJson('/api/user');

        $response->assertUnauthorized();
    }

    public function testLogoutRequiresAuthentication()
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
