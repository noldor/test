<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Calculation extends Model
{
    protected $table = 'calculations';

    protected $fillable = [
        'name',
        'source',
        'user_id'
    ];

    protected $touches = ['secreteCodes'];

    public $relations = [
        'secreteCodes',
        'user'
    ];

    /**
     * Calculation constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        Carbon::setLocale(config('app.locale'));
    }

    /**
     * Get list of all calculations by user.
     *
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getList(User $user)
    {
        $builder = (new self())
            ->newQuery()
            ->with('secreteCodes', 'user');

        if (!$user->isAdmin()) {
            $builder->where(
                'user_id',
                $user->getAttribute('id')
            );
        }

        return $builder->paginate();
    }

    /**
     * Get all secrete codes associated with current calculation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function secreteCodes()
    {
        return $this->belongsToMany(SecreteCode::class, 'secrete_code_to_calculation');
    }

    /**
     * Get user that add current calculation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
