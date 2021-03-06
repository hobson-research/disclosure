<?php
	
	/* =====================================================================
		
		1. Set default timezone to central time

		2. Instantiate 'typerecord' object

	===================================================================== */

	// Set default timezone to central time
	date_default_timezone_set("America/Chicago");

	function __autoload($className)
	{
		include_once '../includes/class.' . $className . '.php';  
	}
	
	$typerecord = new typerecord; 