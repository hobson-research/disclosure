// Refer to RecorderJSInterface.as to edit arguments[n] strings
// $('#status').text("Status " + arguments[0]);

var blinkHandle; 

function microphone_recorder_events()
{

	// Variable used to store status message
	var statusMsg;

	// Blink recording status
	function blinkRecordingStatus() {
		$('#recording-blink').delay(800).fadeTo(300, 0.2).delay(400).fadeTo(300, 1).delay(700); 
	}


	// Inner function to start the counter with an optional parameter to blink the recording status
	function startRecordingCounter( blinkRecord ) {

		$('#stopwatch').text('00:00').show().stopwatch({'format': '{MM}:{ss}'}).stopwatch('stop').stopwatch('reset').stopwatch('start');
		$('#timeCount').addClass('active'); 
		$('#duration').hide(); 

		if( blinkRecord ) {
			$('#recording-blink').show(); 
			blinkHandle = setInterval( blinkRecordingStatus, 400 );
		}
	}


	// Inner function to stop the counter
	function stopRecordingCounter() {
		$('#stopwatch').stopwatch('stop').removeClass('active').hide(); 
		$('#duration').show(); 
		$('#timeCount').removeClass('active'); 

		clearInterval( blinkHandle ); 
		$('#recording-blink').stop().hide(); 

	}


	// Display duration
	function displayDuration( duration ) {
		$('#duration').show().text( formatSeconds( duration.toFixed(0) ) ) ;
	}


	// Format number of seconds to MM:SS
	function formatSeconds( seconds ) {
		return jintervals( seconds, "{MM}:{SS}"); 
	}


	
	switch(arguments[0]) {
	case "ready":
		var width = parseInt(arguments[1]);
		var height = parseInt(arguments[2]);
		Recorder.uploadFormId = "#uploadForm";
		Recorder.uploadFieldName = "upload_file[filename]";
		Recorder.connect("recorderApp", 0);
		Recorder.recorderOriginalWidth = width;
		Recorder.recorderOriginalHeight = height;
		 // $('#play_button').css({'margin-left': width + 8});
		$('#save_button').css({'width': '240px', 'height': '80px'});

		// Hide duration (only to be displayed after the recording is complete)
		$('#duration').hide(); 

		// Set the status message
		statusMsg = 'Press <span class="highlight-red">record</span> below when you\'re ready to begin recording. ';
	break;

	case "no_microphone_found":

		// Set the status message
		statusMsg = "No microphone has been detected. ";

		break;

	case "microphone_user_request":
		Recorder.showPermissionWindow();

		// Set the status message
		statusMsg = 'Click "Allow" if the browser and/or flash player requests access to your hardware devices. Then, click <span class="highlight-red">record</span> again to begin recording. ';

		break;

	case "microphone_connected":
		var mic = arguments[1];
		Recorder.defaultSize();
		Recorder.isReady = true;
		if(configureMicrophone) {
			configureMicrophone();
		}
		$('#upload_status').text("Microphone: " + mic.name);

		// Set the status message
		statusMsg = 'Ready to record. Click <span class="highlight-red">record</span> below to begin recording. ';

		break;

	case "microphone_not_connected":
		Recorder.defaultSize();

		// Set the status message
		statusMsg = "We could not connect to the microphone. ";

		break;

	case "microphone_activity":
		$('#activity_level').text(arguments[1]);
		break;

	case "recording":
		var name = arguments[1];
		Recorder.hide();
		$('#record_button img').attr('src', 'images/stop.png');
		$('#play_button').hide();
		startRecordingCounter( 1 ); 

		// Set the status message
		statusMsg = 'You must hit <span class="highlight-violet">stop</span> and then <span class="highlight-turquoise">submit</span> to submit your recording.';

		break;

	case "recording_stopped":
		var name = arguments[1];
		var duration = arguments[2];
		Recorder.show();
		$('#record_button img').attr('src', 'images/record.png');
		displayDuration( duration ); 
		$('#play_button').show();
		stopRecordingCounter(); 

		// Set the status message
		statusMsg = '<p class="font-color-red">Your recording has not been submitted yet!</p> Press <span class="highlight-violet">play</span> to listen to the file, or press <span class="highlight-red">record</span> to discard the previous file and start a new recording. When finished, click <span class="highlight-turquoise">submit</span> to submit the recording and receive a confirmation code.';

		break;

	case "playing":
		var name = arguments[1];
		$('#record_button img').attr('src', 'images/record.png');
		$('#play_button img').attr('src', 'images/stop.png');

		// Set the status message
		statusMsg = "Playback in progress ";

		break;

	case "playback_started":
		var name = arguments[1];
		var latency = arguments[2];
		startRecordingCounter();

		// Set the status message
		statusMsg = "Playing your recorded file ";

		break;

	case "stopped":
		var name = arguments[1];
		$('#record_button img').attr('src', 'images/record.png');
		$('#play_button img').attr('src', 'images/play.png');
		stopRecordingCounter();
		
		// Set the status message
		statusMsg = 'Playback stopped. You can click <span class="highlight-red">record</span> to delete your previous recording or <span class="highlight-turquoise">submit</span> to submit your recording and receive a confirmation code.';

		break;

	case "save_pressed":
		Recorder.updateForm();

		// Set the status message
		statusMsg = "Submitting the file ";

		break;

	case "saving":
		var name = arguments[1];

		// Set the status message
		statusMsg = "Uploading file to the server ";

		break;

	case "saved":
		var name = arguments[1];
		var data = $.parseJSON(arguments[2]);
		if(data.saved) {
			$('#upload_status').text(name + " was saved"); 
			$('#confirmation-wrapper').addClass('show'); 
			$('#confirmation').val(data.confirm_code).select(); 
			
			// Set the status message
			statusMsg = "The file has been successfully uploaded. Please copy the confirmation code below and paste it into your online survey. Please close this window and go back to the survey when you have copied the confirmation code. ";
		} else {
			$('#upload_status').text(name + " was not saved");

			statusMsg = "The file was not saved, please try again. ";
		}
		break;

	case "save_failed":
		var name = arguments[1];
		var errorMessage = arguments[2];
		$('#upload_status').text(name + " failed: " + errorMessage);

		statusMsg = "Failed to save. ";

		break;

	case "save_progress":
		var name = arguments[1];
		var bytesLoaded = arguments[2];
		var bytesTotal = arguments[3];
		$('#upload_status').text(name + " progress: " + bytesLoaded + " / " + bytesTotal);

		statusMsg = "Upload in progress ";

		break;
	}

	$('#status').html(statusMsg);
}

(function() {
	window.Recorder = {
		recorder: null,
		recorderOriginalWidth: 0,
		recorderOriginalHeight: 0,
		uploadFormId: null,
		uploadFieldName: null,
		isReady: false,

		connect: function(name, attempts) {
			if(navigator.appName.indexOf("Microsoft") != -1) {
				Recorder.recorder = window[name];
			} else {
				Recorder.recorder = document[name];
			}

			if(attempts >= 40) {
				return;
			}

			// flash app needs time to load and initialize
			if(Recorder.recorder && Recorder.recorder.init) {
				Recorder.recorderOriginalWidth = Recorder.recorder.width;
				Recorder.recorderOriginalHeight = Recorder.recorder.height;
				if(Recorder.uploadFormId && $) {
					var frm = $(Recorder.uploadFormId); 
					Recorder.recorder.init(frm.attr('action').toString(), Recorder.uploadFieldName, frm.serializeArray());
				}
				return;
			}

			setTimeout(function() {Recorder.connect(name, attempts+1);}, 100);
		},

		playBack: function(name) {
			Recorder.recorder.playBack(name);
		},

		record: function(name, filename) {
			Recorder.recorder.record(name, filename);
		},

		resize: function(width, height) {
			Recorder.recorder.width = width + "px";
			Recorder.recorder.height = height + "px";
		},

		defaultSize: function(width, height) {
			Recorder.resize(Recorder.recorderOriginalWidth, Recorder.recorderOriginalHeight);
		},

		show: function() {
			Recorder.recorder.show();
		},

		hide: function() {
			Recorder.recorder.hide();
		},

		duration: function(name) {
			return Recorder.recorder.duration(name || Recorder.uploadFieldName);
		},

		updateForm: function() {
			var frm = $(Recorder.uploadFormId); 
			Recorder.recorder.update(frm.serializeArray());
		},

		showPermissionWindow: function() {
			Recorder.resize(240, 160);
			// need to wait until app is resized before displaying permissions screen
			setTimeout(function(){Recorder.recorder.permit();}, 1);
		},

		configure: function(rate, gain, silenceLevel, silenceTimeout) {
			rate = parseInt(rate || 22);
			gain = parseInt(gain || 100);
			silenceLevel = parseInt(silenceLevel || 0);
			silenceTimeout = parseInt(silenceTimeout || 4000);
			switch(rate) {
			case 44:
			case 22:
			case 11:
			case 8:
			case 5:
				break;
			default:
				throw("invalid rate " + rate);
			}

			if(gain < 0 || gain > 100) {
				throw("invalid gain " + gain);
			}

			if(silenceLevel < 0 || silenceLevel > 100) {
				throw("invalid silenceLevel " + silenceLevel);
			}

			if(silenceTimeout < -1) {
				throw("invalid silenceTimeout " + silenceTimeout);
			}

			Recorder.recorder.configure(rate, gain, silenceLevel, silenceTimeout);
		},

		setUseEchoSuppression: function(val) {
			if(typeof(val) != 'boolean') {
				throw("invalid value for setting echo suppression, val: " + val);
			}

			Recorder.recorder.setUseEchoSuppression(val);
		},

		setLoopBack: function(val) {
			if(typeof(val) != 'boolean') {
				throw("invalid value for setting loop back, val: " + val);
			}

			Recorder.recorder.setLoopBack(val);
		}
	};
})();