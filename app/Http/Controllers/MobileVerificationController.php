<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MobileVerificationController extends Controller
{
    public function showForm()
    {
        return view('frontend.verify');
    }

    public function verifySuccess()
    {
        return redirect()->route('next.page'); // Replace with your next page route
    }
}