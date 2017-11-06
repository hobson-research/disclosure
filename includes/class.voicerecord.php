<?php

class voicerecord extends disclosure {
	
	// public variables
	public function __construct() {
	
	}

	// function to convert bytes into kb or Mb
	public function formatBytes($size, $precision = 2) {

		$base = log($size) / log(1024); 
		$suffixes = array('', 'Kb', 'Mb', 'Gb', 'Tb'); 

		return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)]; 
		
	}

	// Check whether the 
	public function checkValidWav($file) {
		$handle = fopen($file, 'r');
		$header = fread($handle, 4);
		list($chunk_size) = array_values(unpack('V', fread($handle, 4)));
		$format = fread($handle, 4);
		fclose($handle);
		return $header == 'RIFF' && $format == 'WAVE' && $chunk_size == (filesize($file) - 8);
	}


	/* =====================================================================
		
		Generate a new file name

	===================================================================== */

	public function generateFileName( $unique_confirm_code, $save_folder, $file_format ) {
		
		$fileName = $save_folder . "/" . $unique_confirm_code . "." . $file_format; 

		return $fileName; 

	}
	

}