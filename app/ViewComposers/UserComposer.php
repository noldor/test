<?php
declare(strict_types=1);

namespace App\Http\ViewComposers;

use App\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\View\View;

class UserComposer
{
    /**
     * The user repository implementation.
     *
     * @var User
     */
    protected $user;

    /**
     * Create a new profile composer.
     *
     * @param  Guard $guard
     */
    public function __construct(Guard $guard)
    {
        $this->user = $guard->user();
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('user', $this->user);
    }
}