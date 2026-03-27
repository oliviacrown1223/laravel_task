<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class EmailController extends Controller
{

   /* public function send(Request $request)
    {
        // 🔥 Load Mailtrap settings from DB
        setMailConfig();

        Mail::raw($request->body, function ($message) use ($request) {
            $message->from($request->from)
                ->to($request->to)
                ->subject($request->subject);
        });

        return back()->with('success', 'Email sent successfully!');
    }*/
}
