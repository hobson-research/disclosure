<?php

	include_once('../includes/include.base.typerecord.php'); 
	
	$pageName = basename( $_SERVER['PHP_SELF'], '.php'); 
	
	if( $pageName == "admin" ) {
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
	<title>Text Disclosure</title>
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
	
	<!-- Google Web Font: Lato 300, 300 italic, 400, 400 italic, 700, 700 italic -->
	<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic' rel='stylesheet' type='text/css'>
	
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<![endif]-->

	<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.js'></script>
	<script src='js/jquery-migrate-1.2.1.min.js'></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<body>

	<div class="container">
		<div class="desktop-12 columns">
			<h1><img src="images/icon_microphone.png" alt="" /></h1>
		</div><!-- // .desktop-12 -->
	</div><!-- // .container -->