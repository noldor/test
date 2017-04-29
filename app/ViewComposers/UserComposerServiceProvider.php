<?php
declare(strict_types=1);

namespace App\ViewComposers;

use App\Http\ViewComposers\UserComposer;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\ServiceProvider;

class UserComposerServiceProvider extends ServiceProvider
{
    public function boot(Factory $view)
    {
        $view->composer(['calculations.row', 'calculations.empty'], UserComposer::class);
    }

    public function register()
    {

    }
}