<?php
include('Twilio/autoload.php');
include('config.php');

use Twilio\Twiml;

$response = new Twiml;

// get the phone number from the page request parameters, if given
if (isset($_REQUEST['To']) && strlen($_REQUEST['To']) > 0) {
    $number = htmlspecialchars($_REQUEST['To']);
    $dial = $response->dial(array('callerId' => $TWILIO_CALLER_ID,'record' => 'record-from-answer-dual',
    'recordingStatusCallback' => 'http://crm.industryarc.com/twilio_test/call_response.php'));
    $dial->number($number);
} else {
    $response->say("Thanks for calling!");
}

header('Content-Type: text/xml');
echo $response;
