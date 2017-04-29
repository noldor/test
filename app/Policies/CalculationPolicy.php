<?php

namespace App\Policies;

use App\Models\Calculation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CalculationPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the calculation.
     *
     * @param  \App\Models\User        $user
     * @param  \App\Models\Calculation $calculation
     *
     * @return mixed
     */
    public function view(User $user, Calculation $calculation)
    {
        return $user->id === $calculation->user_id;
    }

    /**
     * Determine whether the user can create calculations.
     *
     * @param  \App\Models\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the calculation.
     *
     * @param  \App\Models\User        $user
     * @param  \App\Models\Calculation $calculation
     *
     * @return mixed
     */
    public function update(User $user, Calculation $calculation)
    {
        return $user->id === $calculation->user_id;
    }

    /**
     * Determine whether the user can delete the calculation.
     *
     * @param  \App\Models\User        $user
     * @param  \App\Models\Calculation $calculation
     *
     * @return mixed
     */
    public function delete(User $user, Calculation $calculation)
    {
        return $user->id === $calculation->user_id;
    }
}
