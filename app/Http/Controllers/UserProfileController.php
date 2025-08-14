<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;

class UserProfileController extends Controller
{
    public function show(Request $request): Response
    {
        return inertia('user/profile/index', [
            'two_factor_qr_code' => inertia()->optional(fn () => $request->user()->twoFactorQrCodeSvg()),
            'recovery_codes' => inertia()->optional(fn () => $request->user()->recoveryCodes())
        ]);
    }
}
