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
     * Save entity with relation.
     *
     * @param string   $name
     * @param string   $source
     * @param int      $userId
     * @param iterable $sourceCodes
     */
    public function store(string $name, string $source, int $userId, iterable $sourceCodes)
    {
        $calculation = $this->setRawAttributes([
            'name'    => $name,
            'source'  => $source,
            'user_id' => $userId
        ]);

        $calculation->save();

        $codes = [];
        foreach ($sourceCodes as $code) {
            $codes[] = new SecreteCode(['value' => $code]);
        }

        $calculation->secreteCodes()->saveMany($codes);
    }

    /**
     * Get all secrete codes associated with current calculation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function secreteCodes()
    {
        return $this->hasMany(SecreteCode::class);
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
