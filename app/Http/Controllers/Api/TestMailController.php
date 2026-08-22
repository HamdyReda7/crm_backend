<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;

class TestMailController extends Controller
{
    public function send()
    {
        Mail::to("اكتب_ايميلك_هنا@gmail.com")
            ->send(new OtpMail(rand(100000, 999999)));

        return response()->json([
            'success' => true,
            'message' => 'Mail Sent Successfully'
        ]);
    }
}