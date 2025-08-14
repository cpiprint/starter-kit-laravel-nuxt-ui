<?php

namespace App\Http\Controllers;

class PricingController extends Controller
{
    /**
     * Display the pricing page.
     */
    public function index()
    {
        return inertia('pricing/index');
    }
}
