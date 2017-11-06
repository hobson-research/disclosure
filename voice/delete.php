<?php

	// grab the delete file header
	if( $_GET['deleteFile'] ) {
		$deleteFile = urldecode( $_GET['deleteFile'] );
		unlink( $deleteFile );
		echo "<meta http-equiv='refresh' content='0; url=list.php'>";
	} else {
		
	}
	
	
	
?>