<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecreteCode extends Model
{
    protected $table = 'secrete_codes';

    protected $fillable = [
        'value'
    ];

    /**
     * Get all calculations where this code exists.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getCalculations()
    {
        return $this->belongsToMany(Calculation::class, 'secrete_code_to_calculation');
    }
}
