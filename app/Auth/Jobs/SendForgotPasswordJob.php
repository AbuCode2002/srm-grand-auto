<?php

namespace App\Auth\Jobs;

use App\Auth\Repositories\ForgotPasswordRepository;
use App\Auth\Repositories\NotificationRepository;
use App\Notification\UserNotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendForgotPasswordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var ForgotPasswordRepository
     */
    private ForgotPasswordRepository $forgotPasswordRepository;

    /**
     * @var NotificationRepository
     */
    private NotificationRepository $notificationRepository;

    /**
     * @var UserNotificationService
     */
    private UserNotificationService $userNotification;

    public function __construct(
        public string $hash,
    )
    {
        $this->forgotPasswordRepository = new ForgotPasswordRepository();
        $this->notificationRepository   = new NotificationRepository();
        $this->userNotification         = new UserNotificationService();
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $forgotPassword = $this->forgotPasswordRepository->byHashAndLastWithUserAndSocialAccounts($this->hash);
        $resetPasswordLink = config('app.frontend_url').'/password/confirmation?code='.$forgotPassword->hash;
        if ($forgotPassword) {
            $notifiaction = $this->notificationRepository->store([
                'subject' => __('letters.change_password_header'),
                'body'    => __('letters.change_password_description') . $resetPasswordLink
            ]);

            $this->userNotification->send($forgotPassword->user, $notifiaction);
        }
    }

}