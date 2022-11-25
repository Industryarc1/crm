<?php
include('Twilio/autoload.php');
include('config.php');
include('randos.php');

use Twilio\Jwt\ClientToken;

$identity = randomUsername();

$capability = new ClientToken($TWILIO_ACCOUNT_SID, $TWILIO_AUTH_TOKEN);
$capability->allowClientOutgoing($TWILIO_TWIML_APP_SID);
$token = $capability->generateToken();

// return serialized token and the user's randomly generated ID
header('Content-Type: application/json');
echo json_encode(array(
    'identity' => $identity,
    'token' => $token,
));
