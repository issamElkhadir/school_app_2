<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    if ($request->hasHeader('Accept-Language')) {
      app()->setLocale($request->header('Accept-Language'));
    }

    $response = $next($request);

    if ($response->headers->has('Content-Language')) {
      $response->headers->set('Content-Language', app()->getLocale());
    }

    return $response;
  }
}
