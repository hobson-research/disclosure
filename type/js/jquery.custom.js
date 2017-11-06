$(document).ready(function(){
	
	/*	= = = = = = = = = = = = = = = = = = = = = = = = = = = = = 
	
		Select all content in textarea for easier copy & paste

	= = = = = = = = = = = = = = = = = = = = = = = = = = = = = = */
	
	$('.selectAll').click(function () {
		$(this).select();
	});



	/*	= = = = = = = = = = = = = = = = = = = = = = = = = = = = = 
	
		Autogrow disclosure textarea

	= = = = = = = = = = = = = = = = = = = = = = = = = = = = = = */

	$('#typecontent').autosize({append: "\n"}); 





	/*	= = = = = = = = = = = = = = = = = = = = = = = = = = = = = 
	
		Handle Form Submission

	= = = = = = = = = = = = = = = = = = = = = = = = = = = = = = */

	// Variables
	// Retrieve form object to a variable
	var newEntryForm = $('form#new-entry'); 

	var submitPreviewButton = $('#submit-preview');
	var submitBackButton = $('#submit-back'); 
	var submitButton = $('input[type=submit]', newEntryForm);
	var submitTextarea = $('#typecontent');

	var showOnPreview = $('.show-on-preview');
	var hideOnPreview = $('.hide-on-preview');
	var fadeOutOnPreview = $('.fade-out-on-preview');

	showOnPreview.hide(); 



	/*	= = = = = = = = = = = = = = = = = = = = = = = = = = = = = 
	
		Transparency Control on Preview

	= = = = = = = = = = = = = = = = = = = = = = = = = = = = = = */

	var enterPreviewMode = function() {

		showOnPreview.stop().fadeIn(); 
		hideOnPreview.stop().fadeOut(); 
		fadeOutOnPreview.stop().fadeTo(300, 0.2); 

		submitTextarea.attr('readonly', true).addClass('readonly'); 

	}


	var exitPreviewMode = function() {

		showOnPreview.stop().fadeOut(); 
		hideOnPreview.stop().fadeIn(); 
		fadeOutOnPreview.stop().fadeTo(300, 1); 
		
		submitTextarea.attr('readonly', false).removeClass('readonly'); 

	}



	/*	= = = = = = = = = = = = = = = = = = = = = = = = = = = = = 
	
		Button for preview, not actual submission

	= = = = = = = = = = = = = = = = = = = = = = = = = = = = = = */
	

	submitPreviewButton.click(function(e){
		enterPreviewMode();

		e.preventDefault(); 
	});


	submitBackButton.click(function(e){
		exitPreviewMode();

		e.preventDefault(); 
	});

	

	/*	= = = = = = = = = = = = = = = = = = = = = = = = = = = = = 
	
		Seralize typed disclosure and post AJAX request

	= = = = = = = = = = = = = = = = = = = = = = = = = = = = = = */

	// Attach 'submit' handler instead of click
	newEntryForm.submit(function() {

		// Disable the submit button to prevent multiple clicks
		submitButton.attr( 'disabled', 'disabled' );

		$.ajax({
			type: "POST",
			url: newEntryForm.attr( 'action' ), 
			data: newEntryForm.serialize(), 
			success: function( response ) {

				console.log( response );
				
				if( response.saved ) {

					// Hide the form
					newEntryForm.fadeOut(); 

					// Display success message
					$('#submitResult').text('The file has been successfully uploaded. Please copy the confirmation code below and paste it into your online survey. Please close this window and go back to the survey when you have copied the confirmation code. ').stop().fadeIn(); 

					$('#confirmation-wrapper').addClass('show'); 
					$('#confirmation').val( response.confirm_code ).select(); 

					fadeOutOnPreview.stop().fadeTo(300, 1); 

					$('#box-review').fadeOut();
					
				} else {

					// Disable the submit button to prevent multiple clicks
					submitButton.removeAttr('disabled'); 

					// Display failure message
					$('#submitResult').text('Could not save the entry. Please try again or contact the administrator. ').stop().fadeIn().delay(1500).fadeOut(); 
				}

			}
		});

		// Prevent default action
		return false;
	});

});