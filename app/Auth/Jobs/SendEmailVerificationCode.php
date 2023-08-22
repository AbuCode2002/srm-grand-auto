<?php

namespace App\Auth\Jobs;

use App\Auth\SendEmailVerificationCodeService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailVerificationCode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    private string $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * @param SendEmailVerificationCodeService $sendEmailVerificationCodeService
     *
     * @return void
     * @throws Exception
     *
     */
    public function handle(SendEmailVerificationCodeService $sendEmailVerificationCodeService): void
    {
        $sendEmailVerificationCodeService->send($this->email);
    }
}
