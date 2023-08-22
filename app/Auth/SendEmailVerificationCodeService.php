<?php

namespace App\Auth;

use App\Auth\Exceptions\VerificationCodeNotExpiredException;
use App\Auth\Repositories\NotificationRepository;
use App\Auth\Repositories\SocialAccountRepository;
use App\Models\Mysql\SocialAccount;
use App\Notification\NotificationService;
use Exception;

class SendEmailVerificationCodeService
{
    /**
     * @var NotificationService
     */
    private NotificationService $notificationService;

    /**
     * @var SocialAccountRepository
     */
    private SocialAccountRepository $socialAccountRepository;

    /**
     * @var NotificationRepository
     */
    private NotificationRepository $notificationRepository;

    public function __construct()
    {
        $this->notificationService     = new NotificationService();
        $this->socialAccountRepository = new SocialAccountRepository();
        $this->notificationRepository  = new NotificationRepository();
    }

    /**
     * @param string $email
     *
     * @return void
     * @throws Exception
     */
    public function send(string $email): void
    {
        $socialAccount = $this->socialAccountRepository->emailProviderByEmail($email);

        $this->isCodeNotExpired($socialAccount);

        $socialAccount = $this->socialAccountRepository->createCode($socialAccount);

        $notification = $this->notificationRepository->createModelWithAttributes([
            'subject' => 'Для активации перейдите по ссылке',
            'body'    => config('app.frontend_url') . "/profile#code=".$socialAccount->code,
        ]);

        $this->notificationService->send($socialAccount, $notification);
    }

    /**
     * @param SocialAccount $socialAccount
     *
     * @return void
     * @throws VerificationCodeNotExpiredException
     */
    private function isCodeNotExpired(SocialAccount $socialAccount): void
    {
        if ($socialAccount->code_expired_at && $socialAccount->code_created_at->gt(now()->subMinutes(5))) { #@todo вынесты в конфиг
            throw new VerificationCodeNotExpiredException('Code not expired');
        }
    }
}