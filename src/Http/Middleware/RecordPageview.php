<?php

namespace Jakeydevs\Analytics\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Jakeydevs\Analytics\Models\Pageview;

class RecordPageview
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
        $response = $next($request);

        //-- Record
        $pv = new Pageview();
        $pv->session_id = session()->getId();
        $pv->user_agent = $request->header('User-Agent');
        $pv->ip = $request->ip();
        $pv->path = $request->path();
        $pv->method = $request->method();
        $pv->code = $response->status();
        $pv->save();

        //-- Dispatch to our parsers
        //-- TODO

        //-- Return our response
        return $response;
    }
}
