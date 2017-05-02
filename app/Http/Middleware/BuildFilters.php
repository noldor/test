<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BuildFilters
{
    private $castToInt = [
        '=', '>', '<', '>=', '<=', '!='
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('types') && $request->has('values')) {
            $filters = [];
            $values = $request->get('values');
            foreach ($request->get('types') as $key => $type) {
                if (is_null($type) || is_null($values[$key]) && $type !== 'null' && $type !== 'not null') {
                    continue;
                }

                $filters[] = ['type' => $type, 'value' => in_array($type, $this->castToInt, true) ? intval($values[$key]) : $values[$key]];
            }
            $request->offsetSet('filters', $filters);
        }

        return $next($request);
    }
}
