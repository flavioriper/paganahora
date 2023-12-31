<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
		'/api/stats',
		'/api/get_drop',
		'/api/drop',
    '/payments/tefway/callback',
    '/zoop/webhook/process/transaction/success'
    ];
}
