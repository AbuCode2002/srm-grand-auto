<?php

namespace App\Auth;

use App\Exceptions\SocialAccountDetachException;
use App\Exceptions\ValidationException;
use App\Lists\Stage\StageStatusList;
use App\Models\Mysql\Stage;
use App\Repositories\General\Stage\StageRepository;
use Exception;
use RuntimeException;
use App\Auth\Data\SocialData;
use App\Auth\Data\TokenData;
use App\Auth\Data\TelegramAccountData;
use Symfony\Component\HttpFoundation\Response;
use App\Auth\Exceptions\GivenEmailAlreadyExistsException;
use App\Auth\Exceptions\ProviderNotInAllowedGroupException;
use App\Auth\Exceptions\SocialAccountAlreadyExistsException;
use App\Auth\Repositories\SocialAccountRepository;
use App\Auth\Repositories\UserRepository;
use App\Models\Mysql\SocialAccount;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class SocialService
{

    const TELEGRAM_PROVIDER = 'telegram';
    /**
     * @var SocialAccountRepository
     */
    private SocialAccountRepository $socialAccountRepository;

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->socialAccountRepository = new SocialAccountRepository();
        $this->userRepository          = new UserRepository();
        $this->stageRepository          = new StageRepository();
    }

    /**
     * @param SocialData $data
     *
     * @return TokenData
     * @throws GivenEmailAlreadyExistsException
     * @throws ProviderNotInAllowedGroupException
     */
    public function login(SocialData $data): TokenData
    {
        $socialUser    = Socialite::driver($data->provider)
            ->userFromToken($data->token);
        $socialAccount = $this->socialAccountRepository->byProviderAndProviderId($data->provider, $socialUser->id);

        $emailSocialAccount = $this->socialAccountRepository->emailProviderByEmail($socialUser->email);

        if($emailSocialAccount){
            $this->socialAccountRepository->createFromProviderVerified($emailSocialAccount->user, $data->provider, $socialUser);
        }


        if(is_null($socialAccount) && is_null($emailSocialAccount)){
            $socialAccount = $this->createAccount($data->provider, $socialUser);
        }

        return $this->userRepository->createJwt($socialAccount->user);
    }

    /**
     * @param TelegramAccountData $data
     *
     * @return TokenData
     * @throws SocialAccountAlreadyExistsException
     * @throws Exception
     */
    public function loginTelegram(TelegramAccountData $data): TokenData
    {
	    $this->verifiedTelegramHash(request()->all());
        $socialAccount = $this->socialAccountRepository
            ->byProviderAndProviderId(self::TELEGRAM_PROVIDER, $data->id);


        if(is_null($socialAccount)){
            throw new Exception(__('login_page.login_teg_unsuccess'));
        }

        return $this->userRepository->createJwt($socialAccount->user);
    }

    /**
     * @param string $provider
     * @param        $socialUser
     *
     * @return SocialAccount
     * @throws GivenEmailAlreadyExistsException
     * @throws ProviderNotInAllowedGroupException
     * @throws Throwable
     */
    private function createAccount(string $provider, $socialUser): SocialAccount
    {
        $this->checkAllowedProviders($provider);

        if($socialUser->email){
            $this->givenEmailAlreadyExists($socialUser->email);
        }


        $socialAccount = null;

        try {
            DB::beginTransaction();

            $user               = $this->userRepository->createByProviderAndSocialUser($provider, $socialUser);
            $socialAccount      = $this->socialAccountRepository->createFromProviderVerified($user, $provider, $socialUser);
            $socialEmailAccount = $this->socialAccountRepository->createVerifiedEmail($user, $socialUser);

            $this->socialAccountRepository->makePrimary($socialEmailAccount);

            $this->userRepository->setPrimaryEmail($user);

            $socialAccount->setRelation('user', $user);

            DB::commit();
        } catch(Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage(), Response::HTTP_UNAUTHORIZED);
        }

        return $socialAccount;
    }

    /**
     * @param string $provider
     *
     * @return void
     * @throws ProviderNotInAllowedGroupException
     */
    private function checkAllowedProviders(string $provider): void
    {
        if(!in_array($provider, ['google', 'discord'])){
            throw new ProviderNotInAllowedGroupException(
                sprintf('Provider [%s] not in allowed group', $provider)
            );
        }
    }

    /**
     * @param string $email
     *
     * @return void
     * @throws Exception
     */
    private function givenEmailAlreadyExists(string $email): void
    {
        //@todo чекнуть
        if($this->socialAccountRepository->emailExists($email)){
            throw new RuntimeException(
                'Given email already exists',
                Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * @param User|Authenticatable $user
     * @param SocialData           $data
     *
     * @return SocialAccount
     * @throws SocialAccountAlreadyExistsException
     */
    public function attach(User|Authenticatable $user, SocialData $data): SocialAccount
    {
        $socialUser    = Socialite::driver($data->provider)
            ->userFromToken($data->token);
        $socialAccount = $this->socialAccountRepository->byProviderAndProviderId($data->provider, $socialUser->id);

        if($socialAccount){
            throw new SocialAccountAlreadyExistsException("Given provider already exists");
        }

        $socialAccount = $this->socialAccountRepository->createFromProviderVerified(
            $user,
            $data->provider,
            $socialUser
        );

        //@TODO сейчас делаю относительно быстро потом вникнуть и поправить по людски
        $checkProviderHaveEmail = $socialAccount->data['email'] ?? NULL;
        $socialAccountEmail     = NULL;

        if($checkProviderHaveEmail){
            $socialAccountEmail = $this->socialAccountRepository->emailProviderByEmail($socialAccount->data['email']);
        }


        if(is_null($socialAccountEmail) && $checkProviderHaveEmail){
            $this->socialAccountRepository->createVerifiedEmail($user, $socialUser);

            return $socialAccount;
        }

        if($socialAccountEmail){
            $this->socialAccountRepository->verify($socialAccountEmail);
        }


        return $socialAccount;
    }

    /**
     * @throws SocialAccountAlreadyExistsException
     */
    public function attachTelegram(
        User|Authenticatable $user,
        array                $data,
    )
    {
        if(
            $this->socialAccountRepository->byProviderAndProviderId(
                'telegram',
                $data['id']
            )
        ){
            throw new SocialAccountAlreadyExistsException("Given provider already exists");
        }

        return $this->socialAccountRepository->createFromProviderVerified($user, 'telegram', $data);
    }


    /**
     * @param User|Authenticatable $user
     * @param int                  $socialAccountId
     *
     * @return void
     * @throws ProviderNotInAllowedGroupException
     * @throws Throwable
     */
    public function detach(User|Authenticatable $user, int $socialAccountId): void
    {
        $socialAccount      = $this->socialAccountRepository->byIdAndUserId($socialAccountId, $user->id);
        $email              = isset($socialAccount->data['email']) ? $socialAccount->data['email'] : NULL;
        $emailSocialAccount = $email ? $this->socialAccountRepository->byEmailAndEmailProvider($email) : NULL;

        if($this->stageRepository->existActiveStageByUserId($user->id)){
            throw new ValidationException('profile_page.social_acc_cant_detach');
        }

        if(is_null($socialAccount)){
            throw new ModelNotFoundException('Given social account not found');
        }

        if($socialAccount->primary){
            throw new SocialAccountDetachException();
        }

        $this->canDetachProvider($socialAccount);

        try {
            DB::beginTransaction();

            //@todo это костыль пока что

            if ($socialAccount->provider === 'phone') {
                $waSocialAccount = $this->socialAccountRepository->byProviderAndProviderId(
                    provider: 'whatsapp',
                    providerId: $socialAccount->provider_id
                );

                $waSocialAccount?->delete();
            }

            $socialAccount->delete();


            $emailSocialAccount?->delete();

            DB::commit();
        } catch(Throwable $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    /**
     * @param SocialAccount $socialAccount
     *
     * @return void
     * @throws ProviderNotInAllowedGroupException
     */
    private function canDetachProvider(SocialAccount $socialAccount): void
    {
        if(!in_array($socialAccount->provider, ['telegram', 'discord', 'google', 'phone', 'whatsapp'])){
            throw new ProviderNotInAllowedGroupException('Provider not in allowed group');
        }
    }
    //@todo потом вынести в отдельный класс для тг

    /**
     * @throws Exception
     */
    public function verifiedTelegramHash(
        $authData
    ): bool
    {
        $check_hash = $authData['hash'];
        unset($authData['hash']);
        $data_check_arr = [];
        foreach($authData as $key => $value) {
            $data_check_arr[] = $key.'='.$value;
        }
        sort($data_check_arr);
        $data_check_string = implode("\n", $data_check_arr);
        $secret_key        = hash('sha256', config('telegram-bots.bugPlayBot.token'), true);
        $hash              = hash_hmac('sha256', $data_check_string, $secret_key);
        if(strcmp($hash, $check_hash) !== 0){
            throw new Exception('Data is NOT from Telegram');
        }
        if((time() - $authData['auth_date']) > 86400){
            throw new Exception('Data is outdated');
        }
        return true;
    }

    /**
     * @param int $socialAccountId
     * @return bool|null
     */
    public function detachSocialAccount(int $socialAccountId): void
    {
        $socialAccount = $this->socialAccountRepository->findById($socialAccountId);
        $this->socialAccountRepository->delete($socialAccount);
    }

}
