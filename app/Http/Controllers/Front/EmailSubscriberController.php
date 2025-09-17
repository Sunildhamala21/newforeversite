<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\EmailSubscriber;
use Illuminate\Http\Request;

class EmailSubscriberController extends Controller
{
    public function store(Request $request)
    {
        $status = 0;
        $message = '';
        $request->validate([
            'email' => 'required|unique:email_subscribers,email',
        ], [
            'email.unique' => 'You are already subscribed.',
        ]);

        try {
            $subscriber = new EmailSubscriber;
            $subscriber->fill($request->all());

            if ($subscriber->save()) {
                $status = 1;
                $message = 'You have been subscribed.';
            } else {
                $message = 'Something went wrong. Please try again.';
            }
        } catch (\Throwable $th) {
            $th->getMessage();
            $message = $th->getMessage();
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }
}
