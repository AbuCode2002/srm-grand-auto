<?php

namespace App\Auth;

use App\Auth\Repositories\UserRepository;
use App\Models\User;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use stdClass;
use Throwable;

class AuthGuard implements Guard
{
    /**
     * @var User|Authenticatable|null
     */
    private User|Authenticatable|null $user = null;

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @param array $config
     */
    public function __construct(
        private array $config = [],
    )
    {
        $this->userRepository = new UserRepository();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Throwable
     */
    public function check(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return bool
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Throwable
     */
    public function guest(): bool
    {
        return $this->user() === null;
    }

    /**
     * @return User|Authenticatable|null
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function user(): User|Authenticatable|null
    {
        if ($this->user) {
            return $this->user;
        }

        $jwt = $this->getJWTFromRequest();

        if ($jwt) {
            try {
                $this->user = $this->getUserFromPayLoad(
                    JWT::decode($jwt, new Key($this->config['secret'], $this->config['algo'])),
                );
            } catch (Throwable $exception) {
            }
        }

        return $this->user;
    }

    /**
     * @return int|string|null
     */
    public function id(): int|string|null
    {
        return $this->user?->id;
    }

    /**
     * @param array $credentials
     *
     * @return bool
     * @throws Exception
     */
    public function validate(array $credentials = []): bool
    {
        $user = $this->userRepository->byEmail($credentials['email']);

        if (is_null($user)) {
            return false;
        }

        if (is_null($user->password)) {
            throw new Exception('Please try to log in using your social media account.');
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            return false;
        }

        $this->user = $user;

        return true;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Throwable
     */
    public function hasUser(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @param Authenticatable $user
     *
     * @return void
     */
    public function setUser(Authenticatable $user): void
    {
        $this->user = $user;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function getJWTFromRequest()
    {
        $jwt = request()->header('Authorization', request()->get('token', null));

        if (!$jwt) {
            return null;
        }

        return Str::of($jwt)
            ->trim(' ')
            ->explode(' ')
            ->last();
    }

    /**
     * @param stdClass $decode
     *
     * @return User|Authenticatable
     */
    private function getUserFromPayLoad(stdClass $decode): User|Authenticatable
    {
        return $this->userRepository->byId($decode->id);
    }
}