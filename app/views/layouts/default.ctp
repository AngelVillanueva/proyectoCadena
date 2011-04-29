<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>

<!DOCTYPE html>
<!-- 
320 and Up boilerplate extension
Author: Andy Clarke
Version: 0.9b
URL: http://stuffandnonsense.co.uk/projects/320andup 
-->

<!--[if IEMobile 7 ]><html class="no-js iem7" manifest="default.appcache?v=1"><![endif]-->
<!--[if lt IE 7 ]><html class="no-js ie6" lang="en"><![endif]-->
<!--[if IE 7 ]><html class="no-js ie7" lang="en"><![endif]-->
<!--[if IE 8 ]><html class="no-js ie8" lang="en"><![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html class="no-js" manifest="default.appcache?v=1" lang="en"><!--<![endif]-->

<head>
	<meta charset="utf-8">
	
	<title><?php echo $title_for_layout; ?></title>
	
	<meta name="description" content="">
  	<meta name="author" content="">

  <!-- http://t.co/dKP3o1e Mobile viewport optimized-->
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, target-densitydpi=160dpi, initial-scale=1">
  
  <!-- favicons -->
	<!-- For iPhone 4 -->
	<?php echo $this->Html->meta('apple.ico','/img/h/apple-touch-icon.png', array('rel'=>'apple-touch-icon', 'type'=>'icon', 'sizes'=>'114x114')); ?>
	<!-- For iPad 1-->
	<?php echo $this->Html->meta('apple.ico','/img/m/apple-touch-icon.png', array('rel'=>'apple-touch-icon', 'type'=>'icon', 'sizes'=>'72x72')); ?>
	<!-- For iPhone 3G, iPod Touch and Android -->
	<?php echo $this->Html->meta('apple.ico','/img/l/apple-touch-icon.png', array('rel'=>'apple-touch-icon', 'type'=>'icon', 'sizes'=>'57x57')); ?>
	<!-- For Nokia -->
	<?php echo $this->Html->meta('apple.ico','/img/l/apple-touch-icon.png', array('rel'=>'apple-touch-icon', 'type'=>'icon', 'sizes'=>'57x57')); ?>
	<!-- For everything else -->
	<?php echo $this->Html->meta('favicon.ico', '/favicon.ico', array('rel'=>'shortcut icon', 'type'=>'icon')); ?>
	
  <!-- stylesheets -->	
	<!-- For less capable mobile browsers -->
	<?php echo $this->Html->css('handheld.css?v=1', null, array('media'=>'handheld')); ?>
	
	<!-- For all browsers -->
	<?php echo $this->Html->css('style.css?v=1', null, array('media'=>'screen')); ?>
	<!-- For progressively larger displays -->
	<?php echo $this->Html->css('480.css?v=1', null,array('media'=>'only screen and (min-width: 480px)')); ?>
	<?php echo $this->Html->css('768.css?v=1', null, array('media'=>'only screen and (min-width: 768px)')); ?>
	<?php echo $this->Html->css('camelidus.css?v=1', null, array('media'=>'only screen and (min-width: 992px)')); ?>
	<?php echo $this->Html->css('camelidus.css?v=1', null, array('media'=>'only screen and (min-width: 1382px)')); ?>
	<!-- For Retina displays -->
	<?php echo $this->Html->css('2x.css?v=1', null, array('media'=>'only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min-device-pixel-ratio: 2)')); ?>

  <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
	<?php echo $this->Html->script('/js/libs/modernizr-1.7.min'); ?>

		
	<!--iOS. Delete if not required -->
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<link rel="apple-touch-startup-image" href="img/splash.png">

	<!--Microsoft. Delete if not required -->
	<meta http-equiv="cleartype" content="on">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<!-- http://t.co/y1jPVnT -->
	<link rel="canonical" href="/">
		
</head>
<body>
	<div id="pagewrap">
		<header role="banner">
			<?php echo $this->element('header', array('username'=>$username, 'user_mail'=>$user_mail)); ?>
		</header>
		<div id="body" role="main" class="clearfix">
			
			<?php echo $this->Session->flash(); ?>

			<?php echo $content_for_layout; ?>

		</div>
		<footer role="contentinfo">
			<?php echo $this->element('footer'); ?>
		</footer>
	</div><!--! end of #pagewrap -->
	
	<!--<?php echo $this->element('sql_dump'); ?>-->
	
	<!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if necessary -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.js"></script>
  <script>window.jQuery || document.write("<script src='js/libs/jquery-1.5.1.min.js'>\x3C/script>")</script>


  <!-- scripts concatenated and minified via ant build script-->
  <?php echo $this->Html->script('plugins'); ?>
  <?php echo $this->Html->script('script'); ?>
  <!-- end scripts-->


  <!--[if lt IE 7 ]>
    <?php echo $this->Html->script('/js/libs/dd_belatedpng.js'); ?>
    <script>DD_belatedPNG.fix("img, .png_bg"); // Fix any <img> or .png_bg bg-images. Also, please read goo.gl/mZiyb </script>
  <![endif]-->
  
  <!--[if (lt IE 9) & (!IEMobile)]>
	<?php echo $this->Html->script('/js/libs/DOMAssistantCompressed-2.8.js'); ?>
 	<?php echo $this->Html->script('/js/libs/selectivizr-1.0.1.js'); ?>
 	<?php echo $this->Html->script('/js/libs/respond.min.js'); ?>
  <![endif]-->


  <!-- mathiasbynens.be/notes/async-analytics-snippet Change UA-XXXXX-X to be your site's ID -->
  <script>
    var _gaq=[["_setAccount","UA-XXXXX-X"],["_trackPageview"]];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
    g.src=("https:"==location.protocol?"//ssl":"//www")+".google-analytics.com/ga.js";
    s.parentNode.insertBefore(g,s)}(document,"script"));
  </script>
  
  <?php echo $scripts_for_layout; ?>
  
</body>
</html>