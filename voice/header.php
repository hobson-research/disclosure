<?php

	include_once('../includes/include.base.voicerecord.php'); 
	
	$pageName = basename( $_SERVER['PHP_SELF'], '.php'); 
	
	if( $pageName == "list" ) {
		require('typeprotect.php');
	}
	
?>

<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->

<head>

	<!-- Basic Page Needs
	================================================== -->
	<meta charset="utf-8">
	<title>Voice Record Submit</title>
	<meta name="description" content="">
	<meta name="author" content="Jessen Hobson">
	
	<!-- CSS

	* cssreset-min.css 				- CSS reset
	* typegrid.css 					- Grid structure
	* style.css 					- Page style
	================================================== -->
	<link rel="stylesheet" href="http://yui.yahooapis.com/3.8.0/build/cssreset/cssreset-min.css">
	<link rel="stylesheet" href="css/typegrid.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="jplayer/jplayer.pink.flag.css">
	
	<!-- Google Web Font: Lato 300, 300 italic, 400, 400 italic, 700, 700 italic -->
	<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic' rel='stylesheet' type='text/css'>

	<!-- Google Analytics
	================================================== -->
	<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	ga('create', 'UA-43739447-6', 'jessenhobson.com');
	ga('send', 'pageview');
	</script>

	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<![endif]-->

	<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.js'></script>
	<script src='js/jquery-migrate-1.2.1.min.js'></script>

	<script src="jplayer/jquery.jplayer.min.js"></script>

	<?php
		if( $pageName == "record") {
	?>
	<script src="js/swfobject.js"></script>
	<script src="js/recorder.js"></script>

	<script>
	$(function() {
		var gain = 100;
		var silenceLevel = 0;

		var appWidth = 160;
		var appHeight = 40;
		var flashvars = {'event_handler': 'microphone_recorder_events', 'upload_image': 'images/upload.png'};
		var params = {};
		var attributes = {'id': "recorderApp", 'name':  "recorderApp"};
		swfobject.embedSWF("recorder.swf", "flashcontent", appWidth, appHeight, "11.0.0", "", flashvars, params, attributes);
	});

	function configureMicrophone() {
		if(! Recorder.isReady) {
			return;
		}

		// Recorder.configure($('#rate').val(), $('#gain').val(), $('#silenceLevel').val(), $('#silenceTimeout').val());
		Recorder.configure(22, 100, 0, 2000);
		Recorder.setUseEchoSuppression(0);
		Recorder.setLoopBack(0);
	}
	</script>
	
	<?php } ?>
</head>

<body>

	<section id="header">
		<div class="container">
			<div class="desktop-4 columns">
				<h1><img src="images/title_record.png" alt="Record" /></h1>
			</div><!-- // .desktop-4 -->
		</div><!-- // .container -->
	</section><!-- section#header -->