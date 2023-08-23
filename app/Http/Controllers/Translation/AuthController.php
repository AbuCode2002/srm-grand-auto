<?php

namespace App\Http\Controllers\Translation;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;


class AuthController extends Controller
{
    /**
     * @return Factory|View|Application
     */
    public function loginView(): Factory|View|Application
    {
        return view('translation.auth.login');
    }
}
