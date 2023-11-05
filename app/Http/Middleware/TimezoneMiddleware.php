<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Settings\GeneralSettings;
use Symfony\Component\HttpFoundation\Response;

class TimezoneMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    $settings = app(GeneralSettings::class);

    $timezone = $settings->timezone ?? config('app.timezone');

    config(['app.timezone' => $timezone]);
    date_default_timezone_set($timezone);

    return $next($request);
  }
}
