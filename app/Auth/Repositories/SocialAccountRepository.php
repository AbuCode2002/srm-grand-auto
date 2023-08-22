<?php

namespace App\Auth\Repositories;

use App\Models\Mysql\SocialAccount;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SocialAccountRepository extends BaseRepository
{
    /**
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = SocialAccount::class;
    }
    /**
     * @param User   $user
     * @param string $email
     *
     * @return SocialAccount
     */
    public function createNotVerifiedEmailAccount(User $user, string $email): SocialAccount
    {
        $account = new SocialAccount();

        $account->user_id     = $user->id;
        $account->provider    = 'email';
        $account->provider_id = $user->id;
        $account->data        = [
            'email' => $email
        ];

        $account->save();

        return $account;
    }

    /**
     * @param int $socialAccountId
     *
     * @return SocialAccount|Model|null
     */
    public function byId(int $socialAccountId): Model|SocialAccount|null
    {
        return SocialAccount::query()
            ->where('id', '=', $socialAccountId)
            ->first();
    }

    /**
     * @param int $socialAccountId
     * @param int $userId
     *
     * @return Model|SocialAccount|null
     */
    public function byIdAndUserId(int $socialAccountId, int $userId): Model|SocialAccount|null
    {
        return SocialAccount::query()
            ->where('id', '=', $socialAccountId)
            ->where('user_id', '=', $userId)
            ->first();
    }

    /**
     * @param string $email
     *
     * @return SocialAccount|null
     */
    public function emailProviderByEmail(string $email): SocialAccount|null
    {
        return SocialAccount::query()
            ->where('provider', '=', 'email')
            ->where('data->email', '=', $email)
            ->first();
    }

    /**
     * @param SocialAccount $socialAccount
     *
     * @return SocialAccount
     */
    public function verify(SocialAccount $socialAccount): SocialAccount
    {
        $socialAccount->code            = null;
        $socialAccount->code_created_at = null;
        $socialAccount->verified_at     = now();

        $socialAccount->save();

        return $socialAccount;
    }

    /**
     * @param SocialAccount $socialAccount
     *
     * @return void
     */
    public function makePrimary(SocialAccount $socialAccount): void
    {
        #make all account related to user_id non-primary
        SocialAccount::query()
            ->where('user_id', '=', $socialAccount->user_id)
            ->update(['primary' => false]);

        #set given account primary
        SocialAccount::query()
            ->where('id', '=', $socialAccount->id)
            ->update(['primary' => true]);
    }

    /**
     * @param SocialAccount $socialAccount
     *
     * @return SocialAccount
     */
    public function createCode(SocialAccount $socialAccount): SocialAccount
    {
        $socialAccount->code            = Str::ulid();
        $socialAccount->code_created_at = now();
        $socialAccount->verified_at     = null;

        $socialAccount->save();

        return $socialAccount;
    }

    /**
     * @param string|null $provider
     * @param string      $providerId
     *
     * @return SocialAccount|Model|null
     */
    public function byProviderAndProviderId(?string $provider, string $providerId): SocialAccount|Model|null
    {
        return SocialAccount::query()
            ->with('user')
            ->where('provider', '=', $provider)
            ->where('provider_id', '=', $providerId)
            ->first();
    }

    /**
     * @param User   $user
     * @param string $provider
     * @param        $socialUser
     *
     * @return SocialAccount
     */
    public function createFromProviderVerified(User $user, string $provider, $socialUser): SocialAccount
    {
        $socialAccount = new SocialAccount();

        $socialAccount->verified_at = now();
        $socialAccount->user_id     = $user->id;
        $socialAccount->provider    = $provider;
        $socialAccount->provider_id = $socialUser->id ?? $socialUser['id'];
        $socialAccount->data        = (array)$socialUser;

        $socialAccount->save();

        return $socialAccount;
    }

    /**
     * @param User       $user
     * @param Model|User $socialUser
     *
     * @return SocialAccount
     */
    public function createVerifiedEmail(User $user, $socialUser): SocialAccount
    {
        $socialAccount = new SocialAccount();

        $socialAccount->verified_at = now();
        $socialAccount->user_id     = $user->id;
        $socialAccount->provider    = "email";
        $socialAccount->provider_id = $user->id;
        $socialAccount->data        = ['email' => $socialUser->email];

        $socialAccount->save();

        //@todo пока для фронтов нада так сделать потом обсудим
        if(!$user->email){
            $user->email = $socialUser->email;
            $user->save();
        }

        return $socialAccount;
    }

    /**
     * @param string $email
     *
     * @return bool
     */
    public function emailExists(string $email): bool
    {
        return SocialAccount::query()
            ->where('data->email', '=', $email)
            ->exists();
    }

    /**
     * @param string $provider
     * @param int    $providerId
     *
     * @return bool
     */
    public function existByProviderId(
        string $provider,
        int    $providerId
    ): bool
    {
        return SocialAccount::query()
            ->where('provider_id', '=', $providerId)
            ->where('provider', $provider)
            ->exists();
    }

    /**
     * @param mixed $email
     *
     * @return SocialAccount|Model|null
     */
    public function byEmailAndEmailProvider(mixed $email): SocialAccount|Model|null
    {
        return SocialAccount::query()
            ->where('data->email', '=', $email)
            ->where('provider', '=', 'email')
            ->where('primary', '!=', 1)
            ->first();
    }
}
