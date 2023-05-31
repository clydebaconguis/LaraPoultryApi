<?php

namespace App\Http\Controllers;

use Twilio\Rest\Client;
use Illuminate\Http\Request;

class SMSController extends Controller
{
    public function sendSMS()
    {
        $twilioSid = config('AC38cfc82cf11ba3870047bd70af58fd6c');
        $twilioToken = config('c1122f11c22765e25b9fd5a2189ed449');
        $twilioPhoneNumber = config('09554587790');
        
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
