<?php include_once('header.php'); ?>


	<div class="container">
		
		<div id="box-filelist">
			
			<div class="desktop-12 columns">
				<h3>Files List</h3>
			</div>
			
			<div class="desktop-3 columns">
				<h4>ID Key</h4>
			</div>
			
			<div class="desktop-3 columns">
				<h4>Submission Time</h4>
			</div>
			
			<div class="desktop-3 columns">
				<h4>File Type / File Size</h4>
			</div>
			
			<div class="desktop-3 columns">
				<h4>Action</h4>
			</div>
			
			<div class="clear"></div>
			
			<?php
			
			$audioDirPath = 'audio';
			echo "\n"; 
			
			$entryCount = 1; 
			
			// open audio directory
			if ( $audioDir = opendir($audioDirPath) ) {
				
				// check whether files exist and read the directory
				while ( ($entry = readdir($audioDir)) !== false ) {

					if ($entry != "." && $entry != "..") {

						if( $entryCount % 2 == 0 ) {
							$rowClass = "even";
						} else {
							$rowClass = "odd";
						}
						
						$entryPath = "audio/" . $entry;
						$entryModifiedTime = filemtime( $entryPath );

						// Remove file extension
						$entryName = preg_replace("/\\.[^.\\s]{3,4}$/", "", $entry);
						$entryURLEncode = urlencode( $entryPath ); 
						


						$audioNameParts = explode( "_", $entryName ); 
						$audioIdKey = $audioNameParts[0];
						$audioDate = date( "Y/m/d H:i:s", $entryModifiedTime );

						$audioType = preg_match("/\\.[^.\\s]{3,4}$/", $entry, $matches);
						
						
						
						echo "<div class='entry $rowClass'>";
						echo "\n\n"; 
						
						
						// file name
						echo '<div class="desktop-3 columns">';
						echo "\n"; 
						
						echo $audioIdKey; 
						echo "\n"; 
						
						echo '</div><!-- // .desktop-3 -->'; 
						echo "\n\n"; 
						
						
						
						
						// time information
						echo '<div class="desktop-3 columns">';
						echo "\n"; 
						
						echo $audioDate; 
						echo "\n"; 
						
						echo '</div><!-- // .desktop-3 -->';
						echo "\n\n";  
						
						
						
						// file name
						echo '<div class="desktop-3 columns">';
						echo "\n"; 
						
						// $audioLength = filesize($entryPath) / 44068;
						
						// echo '<span class="length">' . gmdate( "i:s", round( $audioLength, 0, PHP_ROUND_HALF_UP ) ) . '</span>';
						// echo "\n"; 
						// echo "<span class='font-color-secondary'> / </span>"; 

						echo '<span class="length">' . $matches[0] . '</span>';
						echo "\n"; 
						echo "<span class='font-color-secondary'> / </span>"; 

						echo '<span class="filesize">' . $voicerecord->formatBytes( filesize($entryPath), 0 ) . '</span>';
						echo "\n";  
						
						echo '</div><!-- // .desktop-3 -->';
						echo "\n\n";  
						
						
						
						// open / delete
						echo '<div class="desktop-3 columns">';echo "\n"; 
						echo "<a href='$entryPath' class='download'>Download</a>";echo "\n"; 
						echo "&nbsp;&nbsp;/&nbsp;&nbsp;";
						echo "<a href='delete.php?deleteFile=$entryURLEncode' class='delete'>Delete</a>";
						echo "\n"; 
						echo "</div><!-- // .desktop-3 -->";
						echo "\n\n"; 
						
						
						
						echo '<div class="clear"></div>';
						echo "\n\n";
						
						echo "</div>"; 
						
						
						// increase entry count
						++$entryCount;
						
						
						
					}
				}
				
				// close audio directory
				closedir($audioDir);
			}
			?>
			
		</div>
		

		<div class="clear"></div>


		<div class="desktop-12 columns">
			<div id="nav">
				<a href="index.php" class="button small">Main page</a>
				
				<a href="record.php" class="button small">Record Page</a>

				<a href="../admin/" class="button small">Admin Page</a>
				
				<a href="list.php?signout=1" class="button small">Sign Out</a>
			</div><!-- // #nav -->
		</div><!-- // .desktop-12 -->
		
		<div class="clear"></div>
		
	</div><!-- // .container -->


<?php include_once('footer.php'); ?>