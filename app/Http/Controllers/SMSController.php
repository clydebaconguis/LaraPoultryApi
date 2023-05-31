<?php

namespace App\Http\Controllers;

use Exception;
use Twilio\Rest\Client;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SMSController extends Controller
{
    public function sendSMS($id)
    {
        $recepient_number = '+63'. ' '. preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $id);
        try{

            $twilioSid = getenv('TWILIO_SID');
            $twilioToken = getenv('TWILIO_AUTH_TOKEN');
            $twilioPhoneNumber = getenv('TWILIO_PHONE_NUMBER');
        
            $client = new Client($twilioSid, $twilioToken);
            
            $otp = random_int(6,6);
            $message = $client->messages->create(
                $recepient_number, // Replace with the recipient's phone number
                [
                    'from' => $twilioPhoneNumber,
                    'body' => 'This your OTP number'. $otp,
                    ]
                );

                return response()->json(['message' => 'success', 'otp' => $otp]);
                
        }catch(Exception $e){

            dd("Error:". $e->getMessage());
        }
        // Optionally, you can handle the response or error here
        // For example, you can log the message ID or handle any exceptions
        // $message->sid will give you the message SID
    }
}
