<?php

namespace App\Http\Middleware;

use App\Parsers\Converter;
use Closure;
use Illuminate\Http\Request;

class ConvertCodes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('source')) {
            $parser = (new Converter($request->get('source')))->factory();

            $resultCodes = $parser->getResult(Converter::AS_ARRAY);

            $codes = (!empty($resultCodes)) ? $resultCodes : null;

            $request->offsetSet('codes', $codes);
        }

        return $next($request);
    }
}
