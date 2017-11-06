<?php
	
	// Check for authentication token and prevent access if wrong auth_token
	if ( !isset( $_POST['auth_token'] ) || $_POST['auth_token'] != "dbaac26839aa1ae7d156c46adc5af63db15f8ae3" ) {

		echo "<h1>Unauthorized access</h1>";
		exit;

	} else {

		include_once('../includes/include.base.typerecord.php');

		$idKey = $_POST['idKey']; 
		$content = $_POST['typecontent']; 

		// If not epmty
		if( trim($content) ) {

			// Generate a confirmation code
			$unique_confirm_code = $typerecord->generateConfirmationCode( $idKey, 2 );
			
			// Insert the new entry into the database
			$typerecord->insertDisclosureByIdKey( $idKey, $content, $unique_confirm_code, 2 );


			header('Content-Type: application/json');
			echo json_encode(
				array(
					'saved' => 1, 
					'confirm_code' => $unique_confirm_code
				)
			);


		} else {

			// If empty
			echo "empty";

		}

	}