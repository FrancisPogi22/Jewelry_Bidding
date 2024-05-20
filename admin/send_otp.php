<?php 
	
	session_start();
	if(isset($_POST['contact'])) {
		$contact = $_POST['contact'];

		$otp = rand(100000, 999999);

		$ch = curl_init();

		$_SESSION['otp'] = $otp;

		$parameters = array(
		    'apikey' => 'd1b5a0adcd7417ad48185e027dcc4e3d', //Your API KEY
		    'number' => $contact,
		    'message' => "Good day!\n"
		                 . "Your Burgos Jewelry OTP is: $otp.\n Do not share this OTP with other people."
		                 . "Thank you!",
		    'sendername' => 'SEMAPHORE'
		);
		curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
		curl_setopt( $ch, CURLOPT_POST, 1 );

		//Send the parameters set above with the request
		curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

		// Receive response from server
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		$output = curl_exec( $ch );
		curl_close ($ch);

		// Return OTP in JSON response
    	echo json_encode(['success' => true, 'otp' => $otp]);
	} else {
	    echo json_encode(['success' => false, 'message' => 'Contact number not provided']);
	}	
	
?>