<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Calculation extends Model
{
    protected $table = 'calculations';

    protected $fillable = [
        'name',
        'source',
        'user_id'
    ];

    protected $touches = ['secretCodes'];

    public $with = [
        'secretCodes',
        'user'
    ];

    public $relations = [
        'secretCodes',
        'user'
    ];

    private $reverseOperators = [
        '!='         => '=',
        'not like'   => 'like',
        'not regexp' => 'regexp'
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
     * @param array            $filters
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getList(User $user, $filters = [])
    {
        $builder = self::scopeFilter(self::newQuery()->without('secretCodes'), $filters);

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
            $codes[] = new SecretCode(['value' => $code]);
        }

        $calculation->secretCodes()->saveMany($codes);
    }

    /**
     * Get all secrete codes associated with current calculation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function secretCodes()
    {
        return $this->hasMany(SecretCode::class);
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

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param                                       $filters
     *
     * @return Builder
     */
    public function scopeFilter(Builder $query, $filters)
    {
        foreach ($filters as $filter) {
            if (array_key_exists($filter['type'], $this->reverseOperators)) {
                $query->whereDoesntHave('secretCodes', function ($query) use ($filter) {
                    /** @var \Illuminate\Database\Query\Builder $query */
                    $query->where('secrete_codes.value', $this->reverseOperators[$filter['type']], $filter['value']);
                });
            } else if ($filter['type'] === 'null') {
                $query->doesntHave('secretCodes');
            } else {
                $query->whereHas('secretCodes', function ($query) use ($filter) {
                    /** @var \Illuminate\Database\Query\Builder $query */
                    if ($filter['type'] === 'not null') {
                        $query->whereNotNull('secrete_codes.value');
                    } else {
                        $query->where('secrete_codes.value', $filter['type'], $filter['value']);
                    }
                });
            }
        }

        return $query;
    }
}
