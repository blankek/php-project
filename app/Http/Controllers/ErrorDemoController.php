<?php

namespace App\Http\Controllers;

use App\Support\HttpErrors;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ErrorDemoController extends Controller
{
    public function index(Request $request): Response
    {
        $code = (int) $request->query('code', 0);
        $error = $code ? HttpErrors::get($code) : null;

        return response(
            view('errors.demo', [
                'errors'      => HttpErrors::all(),
                'activeCode'  => $error ? $code : null,
                'activeError' => $error,
            ]),
            $error ? $code : 200,
            $error ? HttpErrors::responseHeaders($code) : ['Cache-Control' => 'no-store, no-cache']
        );
    }
}
