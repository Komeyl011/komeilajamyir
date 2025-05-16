<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ChangeLangController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate(['lang' => 'required']);
        Session::put('locale', $validated['lang']);
        app()->setLocale($validated['lang']);
        return redirect()->back();
    }
}
