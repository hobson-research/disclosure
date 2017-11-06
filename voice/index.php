<?php include_once('header.php'); ?>

	<div class="container">
		
		<div class="desktop-12 columns">

			<p class="intro">
				<?php echo $voicerecord->getInstructionBySection( 'voice_intro_paragraph' ); ?>
			</p><!-- // p.intro -->

		</div><!-- // .desktop-12 -->


		<div class="clear"></div>


		<form id="id-wrapper" action="record.php" method="post">

			<div class="desktop-12 columns">
				<label for="idKey"><?php echo $voicerecord->getInstructionBySection( 'enter_id_key' ); ?></label>
			</div><!-- // .desktop-12 -->

			<div class="clear"></div>

			<div class="desktop-7 columns">
				<input type="text" name="idKey" id="idKey" />
			</div><!-- // .desktop-8 -->

			<div class="desktop-5 columns">
				<input type="submit" value="<?php echo $voicerecord->getInstructionBySection( 'voice_enter_button' ); ?>" class="button small check" />
			</div><!-- // .desktop-4 -->

		</form><!-- // #id-wrapper -->
		
	</div><!-- // .container -->
	


<?php include_once('footer.php'); ?>