<?php

namespace App\Http\Controllers;

use Exception;
use Twilio\Rest\Client;
use Illuminate\Http\Request;

class SMSController extends Controller
{
    public function sendSMS()
    {
        try{

            $twilioSid = getenv('TWILIO_SID');
            $twilioToken = getenv('TWILIO_AUTH_TOKEN');
            $twilioPhoneNumber = getenv('TWILIO_PHONE_NUMBER');
            
            $client = new Client($twilioSid, $twilioToken);
            
            $message = $client->messages->create(
                '+63 (955) 458‑7790', // Replace with the recipient's phone number
                [
                    'from' => $twilioPhoneNumber,
                    'body' => 'This is a test message from Laravel using Twilio!',
                    ]
                );

                dd("success");
                
        }catch(Exception $e){

            dd("Error:". $e->getMessage());
        }
        // Optionally, you can handle the response or error here
        // For example, you can log the message ID or handle any exceptions
        // $message->sid will give you the message SID
    }
}
