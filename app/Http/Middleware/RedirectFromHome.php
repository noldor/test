<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\RedirectResponse;

class RedirectFromHome
{
    /**
     * RedirectFromHome constructor.
     *
     * @param \Illuminate\Contracts\Routing\UrlGenerator $urlGenerator
     */
    public function __construct(UrlGenerator $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (empty($request->getBasePath())) {
            return new RedirectResponse($this->urlGenerator->route('calculations.index'));
        }

        return $next($request);
    }
}
