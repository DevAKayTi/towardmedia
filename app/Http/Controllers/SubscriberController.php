<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\QueryException;

use App\Models\Subscriber;
use App\Mail\Subscribe;


class SubscriberController extends Controller
{

    public function createSubscriber(Request $request)
    {
        $request->validate([
            'email' => 'required',
        ]);

        try {
            $token = Str::random(60);

            $get_subscriber = new Subscriber();
            $get_subscriber->token = $token;
            $get_subscriber->email = $request->email;
            $get_subscriber->save();

            Mail::to($request->email)->send(new Subscribe($token));

            return redirect()->route('subscribe', $request->email)->with(['success' => 'We have sent a verification email to your address.']);
        }catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) { // MySQL unique constraint violation
                return redirect()->back()->withInput()->withErrors(['email' => 'Email address already exists.']);
            } else {
                return redirect()->back();
            }    
        }
    }

    public function verifyMail($token)
    {
        $subscriber = Subscriber::where('token', $token)->first();

        if ($subscriber) {
            $subscriber->is_activated = 1;
            $subscriber->save();
            return redirect()->route('welcome');
        } else {
            return response()->json(['error' => 'Subscriber not found'], 404);
        }

    }
}