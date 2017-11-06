<?php include_once('header.php'); ?>

<?php
	
	if( !isset($_POST['idKey'] ) ) {
		$idKeyCheck['valid'] = false;  
		$idKeyCheck['message'] = "Please enter an ID Key. ";
	} else {
		$idKey = $_POST['idKey'];
		
		$idKeyCheck = $voicerecord->checkIdKey( $idKey ); 

		$filePattern = "audio/" . $idKey . "_??????????????.mp3"; 
	}

?>


	<div class="container">


		<?php if ( $idKeyCheck['valid'] == false ) { ?>

			<div class="desktop-12 columns">

				<p class="intro"><?php echo $idKeyCheck['message']; ?></p>

			</div><!-- // .desktop-12 -->

		<?php 
			} else { 

				// Search for any existing files with the ID Key
				if( glob( $filePattern ) ) {
		?>

		<div id="box-review">

			<div class="desktop-5 columns">

				<div id="jquery_jplayer_1" class="jp-jplayer"></div>

				<div id="jp_container_1" class="jp-audio">
					<div class="jp-type-single">
						<div class="jp-gui jp-interface">
							<ul class="jp-controls">
								<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
								<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
								<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
								<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
								<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
								<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
							</ul>
							<div class="jp-progress">
								<div class="jp-seek-bar">
									<div class="jp-play-bar"></div>

								</div>
							</div>
							<div class="jp-volume-bar">
								<div class="jp-volume-bar-value"></div>
							</div>
							<div class="jp-current-time"></div>
							<div class="jp-duration"></div>
							<ul class="jp-toggles">
								<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
								<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
							</ul>
						</div>
						<div class="jp-title">
							<ul>
								<li><?php echo $idKey; ?></li>
							</ul>
						</div>
						<div class="jp-no-solution">
							<span>Update Required</span>
							To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
						</div>
					</div><!-- // .jp-type-single -->
				</div><!-- // #jp_container_1 -->

				&nbsp; 
			</div><!-- // .desktop-5 -->


			<div class="desktop-7 columns">
			
				<?php
						$matchFiles = glob( $filePattern ); 
						usort( $matchFiles, create_function( '$a, $b', 'return filemtime($b) - filemtime($a);' ) ); 

						$filename = $matchFiles[0]; 

						echo "<h3>";
						echo $voicerecord->getInstructionBySection( 'voice_review_title' );
						echo "</h3>"; 
						echo "<p class='intro'>";
						echo $voicerecord->getInstructionBySection( 'voice_review_paragraph' );
						echo "</p>"; 

						// To use regular HTML5 <audio> element, uncomment the line below
						// echo "<audio src='$filename' type='audio/mp3' controls='controls'></audio>"; 

				?>

			</div><!-- // .desktop-7 -->

			<div class="clear"></div>

		</div><!-- // #box-review -->

		<?php } ?>




		<div id="box-record">

			<div class="desktop-12 columns">

				<h3><?php echo $voicerecord->getInstructionBySection( 'voice_record_title' ); ?></h3>
				<p id="recording-blink">Recording in progress</p>
				<p id="status">
					Recorder Status...
				</p><!-- // p#status -->
				
				<form id="confirmation-wrapper">
					<label for="confirmation">Confirmation Code</label>
					<input type="text" value="" id="confirmation" name="confirmation" class="selectAll border-box" />
				</form><!-- // form#confirmation-wrapper -->

			</div><!-- // .desktop-12 -->


			<div class="clear"></div>


			<div class="desktop-12 nested columns">
				<div id="control_panel">
					
					<div class="desktop-4 columns">

						<a id="play_button" style="display:none;" onclick="Recorder.playBack('audio');" href="javascript:void(0);" title="Play"><img src="images/play.png" alt="Play"/></a>

					</div><!-- // .desktop-4 -->

					<div class="desktop-4 columns">

						<a id="record_button" onclick="Recorder.record('audio', 'audio.wav');" href="javascript:void(0);" title="Record"><img src="images/record.png" alt="Record"/></a>

					</div><!-- // .desktop-4 -->

					<div class="desktop-4 columns">

						<span id="save_button">
							<span id="flashcontent">
								Your browser must have JavaScript enabled and the Adobe Flash Player installed.
							</span><!-- // span#flashcontent -->
						</span><!-- // span#save_button -->

					</div><!-- // .desktop-4 -->

					<div class="clear"></div>

					<div class="desktop-12 columns">
						<form id="uploadForm" name="uploadForm" action="upload.php">
							<input name="authenticity_token" value="xxxxx" type="hidden">
							<input name="upload_file[parent_id]" value="1" type="hidden">
							<input name="idkey" value="<?php echo $idKey; ?>" type="hidden">
							<input name="format" value="json" type="hidden">
						</form>
					</div><!-- // .desktop-12 -->

				</div><!-- // #control_panel -->
			</div><!-- // .desktop-12 -->



			<div class="clear"></div>
			
			
			
			<div id="recording-info">
				<div class="desktop-4 columns">
					<div id="timeCount">
						<span class="label">Duration</span><br />
						<span id="stopwatch">00:00</span>
						<span id="duration"></span>
					</div>
				</div><!-- // .desktop-4 -->

				<div class="desktop-4 columns">
					<div>
						<span class="label">ID Key</span><br />
						<?php echo $idKey; ?>
						<span id="activity_level">0</span>
					</div>
				</div><!-- // .desktop-4 -->

				<div class="desktop-4 columns">
					<div>
						<span class="label">Upload Status</span><br />
						<span id="upload_status">Not Saved</span>
					</div>
				</div><!-- // .desktop-4 -->

				<div class="clear"></div>
			</div><!-- // #recording-info -->

		</div><!-- // #box-record -->

		<?php } ?>



		<div class="clear"></div>
		
	</div><!-- // .container -->


	<?php if( $idKeyCheck['valid'] && glob( $filePattern ) ) { ?>

	<script>
	$(document).ready(function(){
		
		//	*	*	*	*	*	*	*	*	*	*
		// Misc
		//	*	*	*	*	*	*	*	*	*	*
		$("#jquery_jplayer_1").jPlayer({
			ready: function () {
				$(this).jPlayer("setMedia", {
					mp3:"<?php echo $filename; ?>"
				});
			},
			swfPath: "jplayer",
			supplied: "mp3",
			wmode: "window",
			smoothPlayBar: true,
			keyEnabled: true
		});

	});
	</script>

	<?php } ?>



<?php include_once('footer.php'); ?>