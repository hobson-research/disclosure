<?

include_once('../includes/include.base.voicerecord.php'); 

$save_folder = dirname(__FILE__) . "/audio";
if(! file_exists($save_folder)) {
	if(! mkdir($save_folder)) {
		die("failed to create save folder $save_folder");
	}
}

$key = 'filename';
$tmp_name = $_FILES["upload_file"]["tmp_name"][$key];
$upload_name = $_FILES["upload_file"]["name"][$key];
$type = $_FILES["upload_file"]["type"][$key];

// Retrieve ID Key from the upload form
$idkey = $_POST['idkey']; 

$unique_confirm_code = $voicerecord->generateConfirmationCode($idkey, 1); 


// store the filename into a variable
// two versions - one for .wav and one for .mp3
$fileName = $voicerecord-> generateFileName($unique_confirm_code, $save_folder, "wav"); 
$convertName = $voicerecord->generateFileName($unique_confirm_code, $save_folder, "mp3"); 

// Variable to store upload success
$saved = 0;

// Upload the recorded file
if($type == 'audio/x-wav' && preg_match('/^[a-zA-Z0-9_\-]+\.wav$/', $upload_name) && $voicerecord->checkValidWav($tmp_name)) {
	$saved = move_uploaded_file($tmp_name, $fileName) ? 1 : 0;
}

// Run Ubuntu Command to convert the uploaded wav file into mp3 format
// Enforce 128 kbps to avoid error in playback through audio.js or mediaelement.js

$execCommand = "lame -b 128 -h " . $fileName . " " . $convertName;

// exec('lame -b 128 -h original.wav output.mp3');
exec($execCommand); 

// Insert a log
$voicerecord->insertDisclosureByIdKey( $idkey, "Audio File", $unique_confirm_code, 1 );


if($_POST['format'] == 'json') {

	header('Content-type: application/json');

	// return save results and the confirmation code
	print "{\"saved\":$saved, \"confirm_code\":\"$unique_confirm_code\"}";

} else {
	
	print $saved ? "Saved" : 'Not saved';
}

exit;
?>