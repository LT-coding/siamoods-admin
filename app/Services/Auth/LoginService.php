<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\NewAccessToken;
use RuntimeException;

class LoginService
{
    private User|Authenticatable $user;

    private NewAccessToken $token;

    private array $data;

    /**
     * @throws ValidationException
     */
    public function login(array $data): array
    {
        $this->setData($data); // set passed data
        $this->ensureIsNotRateLimited(); // ensure if User attempts is not limited
        $this->auth(); // trying to authenticate
        return $this->answer(); // return the answer
    }

    /**
     * --- Revoke the token that was used to authenticate the current request. --
     */
    public function logout(): void
    {
        if (!Auth::check()) {
            throw new UnauthorizedException('unauthorized');
        }
        Auth::user()?->tokens()->delete();
        Auth::guard('web')->logout();
    }

    private function answer(): array
    {
        return [
            'access_token' => $this->token->plainTextToken,
            'token_type' => 'Bearer',
        ];
    }

    private function createToken(): void
    {
        $this->token = $this->user->createToken('sanctum-auth-thdb');
    }

    /**
     */
    protected function auth(): void
    {
        $this->attempt(); // check credentials and authenticate user
        $this->createToken(); // create token for him
        $this->clearRateLimiter(); // clear user auth attempts const
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws ValidationException
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }
        $seconds = RateLimiter::availableIn($this->throttleKey());
        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    protected function throttleKey(): string
    {
        return Str::lower($this->data['email']) . '|' . $this->data['ip'];
    }

    public function getUser(): User|Authenticatable
    {
        return $this->user;
    }

    private function clearRateLimiter(): void
    {
        RateLimiter::clear($this->throttleKey());
    }

    /**
     */
    private function attempt(): void
    {
        $this->findUser();
        if ($this->ensureIsActive()) {
            Auth::login($this->user, $this->remember());
        } else {
            RateLimiter::hit($this->throttleKey());
            throw new RuntimeException('The employee status is inactive', 403);
        }
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    private function credentials(): array
    {
        return [
            'email' => $this->data['email'],
            'password' => $this->data['password']
        ];
    }

    private function remember()
    {
        return $this->data['remember'] ?? false;
    }

    /**
     */
    private function ensureIsActive(): bool
    {
        if ($this->user->is_employee && !$this->user->is_active) {
            return false;
        }
        return true;
    }

    /**
     */
    private function findUser(): void
    {
        $data = $this->credentials();
        /** @var User|$user */
        $user = User::whereEmail($data['email'])->firstOrFail();
        if (!Hash::check($data['password'], $user->password)) {
            throw new RuntimeException('invalid credentials', 403);
        }

        $this->user = $user;
    }
}
