<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected UserService $userService;

    protected function setUp(): void
    {
        parent::setUp(); // Важно: вызываем parent::setUp()
        $this->userService = new UserService();
    }

    /** @test */
    public function it_can_register_a_new_user()
    {
        // Arrange
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        // Act
        $result = $this->userService->register($userData);

        // Assert
        $this->assertInstanceOf(User::class, $result['user']);
        $this->assertIsString($result['token']);
        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $this->assertTrue(Hash::check('password123', $result['user']->password));
    }

    /** @test */
    public function it_returns_valid_token_on_registration()
    {
        // Arrange
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        // Act
        $result = $this->userService->register($userData);

        // Assert
        $this->assertStringContainsString('|', $result['token']);
        $this->assertTrue(strlen($result['token']) > 40);
    }

    /** @test */
    public function it_can_login_with_valid_credentials()
    {
        // Arrange
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $credentials = [
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        // Act
        $result = $this->userService->login($credentials);

        // Assert
        $this->assertNotNull($result);
        $this->assertInstanceOf(User::class, $result['user']);
        $this->assertIsString($result['token']);
        $this->assertEquals($user->id, $result['user']->id);
    }

    /** @test */
    public function it_returns_null_for_invalid_login_credentials()
    {
        // Arrange
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $invalidCredentials = [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ];

        // Act
        $result = $this->userService->login($invalidCredentials);

        // Assert
        $this->assertNull($result);
    }

    /** @test */
    public function it_returns_null_for_nonexistent_email()
    {
        // Arrange
        $credentials = [
            'email' => 'nonexistent@example.com',
            'password' => 'password123',
        ];

        // Act
        $result = $this->userService->login($credentials);

        // Assert
        $this->assertNull($result);
    }

    /** @test */
    public function it_creates_api_token_with_admin_permissions()
    {
        // Arrange
        $adminUser = User::factory()->create(['is_admin' => true]);

        // Act
        $token = $this->userService->createApiToken($adminUser, 'admin-token');

        // Assert
        $this->assertIsString($token);

        // Проверяем, что токен создан в базе
        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_type' => User::class,
            'tokenable_id' => $adminUser->id,
            'name' => 'admin-token',
        ]);
    }

    /** @test */
    public function it_creates_api_token_with_user_permissions()
    {
        // Arrange
        $regularUser = User::factory()->create(['is_admin' => false]);

        // Act
        $token = $this->userService->createApiToken($regularUser, 'user-token');

        // Assert
        $this->assertIsString($token);
        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_type' => User::class,
            'tokenable_id' => $regularUser->id,
            'name' => 'user-token',
        ]);
    }

    /** @test */
    public function it_can_logout_user_by_deleting_current_token()
    {
        // Arrange
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        // Авторизуем пользователя с токеном
        $this->actingAs($user, 'sanctum');

        // Act
        $this->userService->logout($user);

        // Assert
        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'name' => 'test-token',
        ]);
    }

    /** @test */
    public function it_does_not_throw_error_when_logging_out_without_token()
    {
        // Arrange
        $user = User::factory()->create();

        // Act & Assert - не должно быть исключения
        try {
            $this->userService->logout($user);
            $this->assertTrue(true); // Если дошло сюда, значит исключения не было
        } catch (\Exception $e) {
            $this->fail('Метод logout выбросил исключение: ' . $e->getMessage());
        }
    }

    /** @test */
    public function it_can_revoke_all_tokens_for_user()
    {
        // Arrange
        $user = User::factory()->create();

        // Создаем несколько токенов
        $user->createToken('token-1');
        $user->createToken('token-2');
        $user->createToken('token-3');

        $this->assertCount(3, $user->tokens);

        // Act
        $this->userService->revokeAllTokens($user);

        // Assert
        $this->assertCount(0, $user->fresh()->tokens);
    }

    /** @test */
    public function it_can_revoke_other_tokens_except_current()
    {
        // Arrange
        $user = User::factory()->create();

        // Создаем несколько токенов
        $currentToken = $user->createToken('current-token')->accessToken;
        $user->createToken('old-token-1');
        $user->createToken('old-token-2');

        $this->assertCount(3, $user->tokens);

        // Авторизуем с текущим токеном
        $this->actingAs($user, 'sanctum');

        // Act
        $this->userService->revokeOtherTokens($user);

        // Assert
        $this->assertCount(1, $user->fresh()->tokens);
        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'name' => 'current-token',
        ]);
        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'name' => 'old-token-1',
        ]);
        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'name' => 'old-token-2',
        ]);
    }

    /** @test */
    public function it_returns_current_user()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $result = $this->userService->getCurrentUser($user);

        // Assert
        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals($user->id, $result->id);
        $this->assertEquals($user->email, $result->email);
    }

    /** @test */
    public function it_hashes_password_during_registration()
    {
        // Arrange
        $plainPassword = 'password123';
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => $plainPassword,
        ];

        // Act
        $result = $this->userService->register($userData);

        // Assert
        $this->assertNotEquals($plainPassword, $result['user']->password);
        $this->assertTrue(Hash::check($plainPassword, $result['user']->password));
    }

    /** @test */
    public function it_can_register_multiple_users_with_unique_emails()
    {
        // Arrange
        $userData1 = [
            'name' => 'User 1',
            'email' => 'user1@example.com',
            'password' => 'password123',
        ];

        $userData2 = [
            'name' => 'User 2',
            'email' => 'user2@example.com',
            'password' => 'password456',
        ];

        // Act
        $result1 = $this->userService->register($userData1);
        $result2 = $this->userService->register($userData2);

        // Assert
        $this->assertEquals('user1@example.com', $result1['user']->email);
        $this->assertEquals('user2@example.com', $result2['user']->email);

        $this->assertDatabaseHas('users', ['email' => 'user1@example.com']);
        $this->assertDatabaseHas('users', ['email' => 'user2@example.com']);
    }

    /** @test */
    public function it_creates_different_tokens_for_different_users()
    {
        // Arrange
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Act
        $token1 = $this->userService->createApiToken($user1);
        $token2 = $this->userService->createApiToken($user2);

        // Assert
        $this->assertNotEquals($token1, $token2);

        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $user1->id,
        ]);
        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $user2->id,
        ]);
    }

    /** @test */
    public function login_fails_with_empty_credentials()
    {
        // Arrange
        $emptyCredentials = [];

        // Act
        $result = $this->userService->login($emptyCredentials);

        // Assert
        $this->assertNull($result);
    }

    /** @test */
    public function it_can_create_token_with_custom_name()
    {
        // Arrange
        $user = User::factory()->create();
        $customTokenName = 'mobile-app-token';

        // Act
        $token = $this->userService->createApiToken($user, $customTokenName);

        // Assert
        $this->assertIsString($token);
        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'name' => $customTokenName,
        ]);
    }
}
