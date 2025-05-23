<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VerifyWebhookSignature
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
        // In production, verify Paymongo webhook signature
        // This is a simplified example - you would normally verify the signature
        // $signature = $request->header('Paymongo-Signature');
        
        return $next($request);
    }
}