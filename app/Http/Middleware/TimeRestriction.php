<?php

namespace App\Http\Middleware;

use Closure;

class TimeRestriction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (date('l') == 'Sunday' || date('l') == 'Saturday') {
            return die('ซื้อขายได้เฉพาะวันที่ SET/mai เปิดทำการ');
        }
        if ( intval(date('G')) < 17 || intval(date('G')) > 20 ) {
            return die('ซื้อขายได้ในช่วงเวลา 17.05 - 21.00');
        } elseif (intval(date('G')) == 17 && intval(date('i')) <= 5 ) {
            return die('ซื้อขายได้ในช่วงเวลา 17.05 - 21.00');
        }
        return $next($request);
    }
}
