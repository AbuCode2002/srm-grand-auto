<?php

namespace App\Auth\Repositories;

use App\Models\ForgotPassword;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ForgotPasswordRepository extends BaseRepository
{
    /**
     * @param Model|User $user
     *
     * @return ForgotPassword|Model
     */
    public function createForUser(Model|User $user): ForgotPassword|Model
    {
        $forgotPassword = new ForgotPassword();

        $forgotPassword->hash         = Str::ulid()->generate();
        $forgotPassword->user_id      = $user->id;
        $forgotPassword->old_password = $user->password;

        $forgotPassword->save();

        return $forgotPassword;
    }

    /**
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = ForgotPassword::class;
    }

    /**
     * @param int $userId
     *
     * @return ForgotPassword|Model|null
     */
    public function byUserIdAndLast(int $userId): ForgotPassword|Model|null
    {
        return $this->model::query()
            ->where('user_id', '=', $userId)
            ->whereNull('password')
            ->where('created_at', '>=', now()->subMinutes(5))
            ->first();
    }

    /**
     * @param string $hash
     *
     * @return ForgotPassword|Model|null
     */
    public function byHashAndLastWithUserAndSocialAccounts(string $hash): ForgotPassword|Model|null
    {
        return $this->model::query()
            ->with(['user.socialAccounts'])
            ->where('hash', '=', $hash)
            ->whereNull('password')
            ->where('created_at', '>=', now()->subMinutes(5))
            ->first();
    }

    /**
     * @param string $hash
     *
     * @return ForgotPassword|Model|null
     */
    public function byHashAndLastWithUser(string $hash): ForgotPassword|Model|null
    {
        return $this->model::query()
            ->with(['user'])
            ->where('hash', '=', $hash)
            ->whereNull('password')
            ->where('created_at', '>=', now()->subMinutes(5))
            ->first();
    }

    /**
     * @param ForgotPassword|Model $forgotPassword
     * @param string               $password
     *
     * @return ForgotPassword|Model
     */
    public function setPassword(ForgotPassword|Model $forgotPassword, string $password): ForgotPassword|Model
    {
        $forgotPassword->password = bcrypt($password);

        $forgotPassword->save();

        return $forgotPassword;
    }
}