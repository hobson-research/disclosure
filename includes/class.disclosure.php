<?php

class disclosure {

	public function __construct() {
	
	}


	/* =====================================================================
		
		Check the validity of the ID Key

	===================================================================== */

	public function checkIdKey($idKey) {

		// Array to store returned information
		$results = array();

		if( !isset($idKey) || $idKey == "" ) {
			$results['valid'] = false;
			$results['message'] = "Please enter an ID Key.";
		} elseif( !is_numeric($idKey) ) {
			$results['valid'] = false;
			$results['message'] = "You have entered an invalid ID Key (non-integer).";
		} else {
			$results['valid'] =  true; 
			$results['message'] = "Success!";
		}

		return $results;
	}



	/* =====================================================================
		
		Get Instruction 

	===================================================================== */

	public function getInstructionBySection( $section ) {

		try {
			$conn = new PDO('mysql:host=localhost;dbname=', '', '');
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

			// Select all the entries of matching idKey
			// Order by reverse timestamp (recent first)
			$stmt = $conn->prepare('SELECT * FROM instructions WHERE section = :section ORDER BY timestamp DESC');
			$stmt->bindParam(':section', $section, PDO::PARAM_STR);
			$stmt->execute(); 

			// Fetch
			$result = $stmt->fetchAll();

			// If there is at least one matching row, return the result set
			// If not, retrn false
			if( count($result) ) {
				return $result[0]['instruction'];
			} else {
				return false; 
			}

		} catch(PDOException $e) {
			return 'ERROR: ' . $e->getMessage(); 
		}
	}



	/* =====================================================================
		
		Generate confirmation code

	===================================================================== */

	public function generateConfirmationCode( $idKey, $disclosureType ) {

		// Check the disclosure type and generate a prefix to be used in the confirmation code
		if( $disclosureType == 1 ) {
			// If voice, add a "V"
			$typePrefix = "V";
		} else {
			// If text, add a "T"
			$typePrefix = "T";
		}

		$entries = $this->getDisclosureByIdKey( $idKey, $disclosureType );

		if( !$entries ) {
			$countPostfix = 1;
		} else {
			$countPostfix = count( $entries ) + 1;
		}
		

		$unique_confirm_code = $idKey . "_" . $typePrefix . sprintf("%02s", $countPostfix);

		return $unique_confirm_code; 

	}



	/* =====================================================================
		
		Find existing disclosure entries by ID Key

	===================================================================== */

	// Example: generateConfirmationCode( 12, 2 )
	// Disclosure type: 1 for voice and 2 for text
	public function getDisclosureByIdKey( $idKey, $disclosureType ) { 

		try {

			$conn = new PDO('mysql:host=localhost;dbname=', '', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

			// Select all the entries of matching idKey
			// Order by reverse timestamp (recent first)
			$stmt = $conn->prepare('SELECT * FROM disclosures WHERE idKey = :idKey AND type = :type ORDER BY timestamp DESC');
			$stmt->bindParam(':idKey', $idKey, PDO::PARAM_STR);
			$stmt->bindParam(':type', $disclosureType, PDO::PARAM_STR);
			$stmt->execute(); 

			// Fetch
			$result = $stmt->fetchAll();

			// If there is at least one matching row, return the result set
			// If not, retrn false
			if( count($result) ) {
				return $result;
			} else {
				return false; 
			}

		} catch(PDOException $e) {

			return 'ERROR: ' . $e->getMessage(); 

		}
	}



	/* =====================================================================
		
		Insert a new entry into the database

	===================================================================== */
	
	public function insertDisclosureByIdKey( $idKey, $content, $confirmation, $type ) {

		try {

			$conn = new PDO('mysql:host=localhost;dbname=', '', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

			// Select all the entries of matching idKey
			// Order by reverse timestamp (recent first)
			$stmt = $conn->prepare('INSERT INTO disclosures (idKey, content, confirmation, type) VALUES (:idKey, :content, :confirmation, :type)');
			$stmt->bindParam(':idKey', $idKey, PDO::PARAM_STR); 
			$stmt->bindParam(':content', $content, PDO::PARAM_STR); 
			$stmt->bindParam(':confirmation', $confirmation, PDO::PARAM_STR); 
			$stmt->bindParam(':type', $type, PDO::PARAM_STR); 
			$stmt->execute(); 

		} catch(PDOException $e) {

			return 'ERROR: ' . $e->getMessage(); 

		}
	}



}