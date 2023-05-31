<?php

namespace App\Http\Controllers;

use Twilio\Rest\Client;
use Illuminate\Http\Request;

class SMSController extends Controller
{
    public function sendSMS()
    {
        $twilioSid = config('app.twilio_sid');
        $twilioToken = config('app.twilio_auth_token');
        $twilioPhoneNumber = config('app.twilio_phone_number');
        
        $client = new Client($twilioSid, $twilioToken);
        
        $message = $client->messages->create(
            '09554587790', // Replace with the recipient's phone number
            [
                'from' => $twilioPhoneNumber,
                'body' => 'This is a test message from Laravel using Twilio!',
            ]
        );
        
        // Optionally, you can handle the response or error here
        // For example, you can log the message ID or handle any exceptions
        // $message->sid will give you the message SID
    }
}
