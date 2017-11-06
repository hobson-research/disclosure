<?php include_once('header.php'); ?>
<?php
	
	if( !isset($_POST['idKey'] ) ) {
		$idKeyCheck['valid'] = false; 
		$idKeyCheck['message'] = "Please enter an ID Key. "; 
	} else {
		$idKey = $_POST['idKey'];
		
		$idKeyCheck = $typerecord->checkIdKey( $idKey ); 
	}
?>
	<div class="container">
		<?php if ( $idKeyCheck['valid'] == false ) { ?>
			<div class="desktop-12 columns">
				<p class="intro"><?php echo $idKeyCheck['message']; ?></p>
			</div><!-- // .desktop-12 -->
		<?php  
			} elseif ( count( $typerecord->getDisclosureByIdKey( $idKey, 2 ) ) >= 2 ) { 
		 ?>
			<div class="desktop-12 columns">
				<p class="intro"><?php echo $typerecord->getInstructionBySection( 'exceed_maximum_submissions' ); ?></p>
			</div><!-- // .desktop-12 -->
		<?php
			} else {
				if ( $typerecord->getDisclosureByIdKey( $idKey, 2 ) ) { 
					$results = $typerecord->getDisclosureByIdKey( $idKey, 2 );
		?>
		<div id="box-review" class="fade-out-on-preview">
			<div class="desktop-12 columns">
			
				<h3><?php echo $typerecord->getInstructionBySection( 'type_prediction_title' ); ?></h3>
				<p class="intro"><span class="font-color-gray">Confirmation#</span> <span class="font-color-white"><?php echo( nl2br( $results[0]['confirmation'] ) ); ?></span></p>
				<p class="review"><?php echo( nl2br( $results[0]['content'] ) ); ?></p>
			</div><!-- // .desktop-7 -->
			<div class="clear"></div>
		</div><!-- // #box-review -->
		<?php } ?>
		<div id="box-record">
			<div class="desktop-12 nested columns">
				<form id="new-entry" action="update.db.php" method="post">
					<div class="desktop-12 columns">
						<div class="hide-on-preview">
							<h3><?php echo $typerecord->getInstructionBySection( 'type_new_entry_title' ); ?></h3>
							
							<p class="intro"><?php echo $typerecord->getInstructionBySection( 'type_new_entry_description' ); ?></p>
						</div><!-- // .hide-on-preview -->
						<div class="show-on-preview">
							<h3><?php echo $typerecord->getInstructionBySection( 'type_preview_entry_title' ); ?></h3>
							
							<p class="intro"><?php echo $typerecord->getInstructionBySection( 'type_preview_entry_description' ); ?></p>
						</div><!-- // .show-on-preview -->
						<textarea name="typecontent" id="typecontent" placeholder="Type here"></textarea>
						<input name="idKey" value="<?php echo $idKey; ?>" type="hidden" />
						<input name="auth_token" value="dbaac26839aa1ae7d156c46adc5af63db15f8ae3" type="hidden" />
						<!-- Preview Submission -->
						<a id="submit-preview" href="#" class="button full hide-on-preview">Preview</a>
					</div><!-- // .desktop-12 -->
					<div class="clear"></div>
					<div class="show-on-preview">
						<div class="desktop-6 columns">
							<!-- Go back or submit form -->
							<a id="submit-back" href="#">&larr; Back to Edit</a>
						</div><!-- // .desktop-6 -->
						<div class="desktop-6 columns">
							<input type="submit" name="submit" id="submit" value="Submit" />
						</div><!-- // .desktop-6 -->
					</div><!-- // .show-on-preview -->
					<div class="clear"></div>
				</form><!-- // form#new-entry -->
				<div class="desktop-12 columns">
					<p id="submitResult"></p><!-- // #submitResult -->
					<!--  = = = = = = = = = = = = = = = = = = = = = = = = = = = = 
						Confirmation code 
					= = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = -->
					<form id="confirmation-wrapper">
						<label for="confirmation">Confirmation Code</label>
						<input type="text" value="" id="confirmation" name="confirmation" class="selectAll border-box" />
					</form><!-- // form#confirmation-wrapper -->
				</div><!-- // .desktop-12 -->
			</div><!-- // .desktop-12 .nested -->
			<div class="clear"></div>
			<div class="desktop-12 columns">
			</div><!-- // .desktop-12 -->
			<div class="clear"></div>
			
			
			
			<div id="recording-info" class="fade-out-on-preview">
				<div class="desktop-4 columns">
					<span class="label">ID Key</span><br />
					<?php echo $idKey; ?>
				</div><!-- // .desktop-4 -->
				<div class="clear"></div>
			</div><!-- // #recording-info -->
		</div><!-- // #box-record -->
		<?php } ?>
		<div class="clear"></div>
		
	</div><!-- // .container -->
<?php include_once('footer.php'); ?>