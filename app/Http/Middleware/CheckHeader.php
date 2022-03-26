<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckHeader
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function handle(Request $request, Closure $next)
  {

    $acceptHeader = $request->header('Accept');
    if ($acceptHeader != 'application/json') {
      return response()->json(format_return([], [], 406, "Ooopp only accept application/json header"), 406);
    }

    return $next($request);
  }
}
