﻿$(function () {
  log('Requesting Capability Token...');
  $.getJSON('https://crm.industryarc.in/twilio/token.php')
    .done(function (data) {
      log('Got a token.');
		console.log('Token: ' + data.token);
      Twilio.Device.setup(data.token);
      Twilio.Device.ready(function (device) {
        log('Twilio.Device Ready!');
        document.getElementById('call-controls').style.display = 'block';
      });

      Twilio.Device.error(function (error) {
        log('Twilio.Device Error: ' + error.message);
      });

      Twilio.Device.connect(function (conn) {
        log('Successfully established call!');
        document.getElementById('button-call').style.display = 'none';
        document.getElementById('button-hangup').style.display = 'inline';
      });

      Twilio.Device.disconnect(function (conn) {
        log('Call ended.');
        document.getElementById('button-call').style.display = 'inline';
        document.getElementById('button-hangup').style.display = 'none';
      });

    })
    .fail(function () {
      log('Could not get a token from server!');
    });

  // Bind button to make call
  document.getElementById('button-call').onclick = function () {
    // get the phone number to connect the call to
    var params = {
      To: document.getElementById('phone-number').value,
      LeadId: document.getElementById('getleadid').value
    };

    console.log('Calling ' + params.To + '...');
    Twilio.Device.connect(params);
  };

  // Bind button to hangup call
  document.getElementById('button-hangup').onclick = function () {
    log('Hanging up...');
    Twilio.Device.disconnectAll();
  };

});

// Activity log
function log(message) {
  var logDiv = document.getElementById('log');
  logDiv.innerHTML += '<p>&gt;&nbsp;' + message + '</p>';
  logDiv.scrollTop = logDiv.scrollHeight;
}