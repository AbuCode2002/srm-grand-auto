<?php

namespace App\Auth\Repositories;

use App\Auth\Data\LoginData;
use App\Auth\Data\RegisterData;
use App\Auth\Data\TokenData;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRepository
{
    /**
     * @param RegisterData $data
     *
     * @return User
     */
    public function create(RegisterData $data): User
    {
        $user = new User();

        $user->name  = $data->name;
        $user->email  = $data->email;
        $user->password   = bcrypt($data->password);
        $user->role_id = $data->role_id;


        $user->save();

        return $user;
    }

    public function createJwtForLogin(LoginData $data): TokenData
    {
        $passHash = User::query()->where('email', $data->email);

        if (Hash::check($data->password, $passHash->value('password'))) {
            $user = $passHash->get()->first();
            return $user->jwt();
        }
        return throw new Exception('Не правильный логин или пароль!');
    }

    /**
     * @param string $email
     *
     * @return User|Model|null
     */
    public function byEmail(string $email): User|Model|null
    {
        return User::query()
            ->where('email', '=', $email)
            ->whereNotNull('password')
            ->first();
    }

    /**
     * @param int $id
     *
     * @return User|Model|null
     */
    public function byId(int $id): User|Model|null
    {
        return User::query()
            ->where('id', '=', $id)
            ->first();
    }

    /**
     * @return User|Model
     */
    public function createRandom(): User|Model
    {
        $user = new User();

        $user->password = null;

        $user->save();

        return $user;
    }

    /**
     * @param $provider
     * @param $socialUser
     *
     * @return User|Model
     * @throws \Exception
     */
    public function createByProviderAndSocialUser($provider, $socialUser): User|Model
    {
        $user = new User();
        //@todo вот тут даем юзеру рандомный пароль
        $user->password = bcrypt(Str::random(10));

        if($provider === 'google') {
            $user->username = Str::slug($socialUser->name,'_','en') . "#". random_int(1,100000);
        }

        if($provider === 'discord') {
            $user->username = $socialUser->nickname . "#". random_int(1,100000);
        }


        $user->save();

        return $user;
    }

    /**
     * @param User|Model|Authenticatable $user
     * @param string                     $password
     *
     * @return User|Model|Authenticatable
     */
    public function setPassword(User|Model|Authenticatable $user, string $password): User|Model|Authenticatable
    {
        $user->password = bcrypt($password);

        $user->save();

        return $user;
    }
}
