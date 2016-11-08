<?php
	/*
	Plugin Name: hiWeb Lightbox
	Plugin URI: http://plugins.hiweb.moscow/lightbox
	Description: Auto-open all <a[href="*.jpg"]> in Lightbox
	Version: 1.0.0.0
	Author: Den Media
	Author URI: http://hiweb.moscow
	*/
	
	require_once 'define.php';
	require_once 'include/core.php';
	require_once 'include/short_functions.php';
	require_once 'include/hooks.php';
	
	if( !is_admin() ){
		hiweb_lightbox()->js( '/js/hw_lightbox.js', array( 'jquery' ) );
		hiweb_lightbox()->js( '/assets/photoswipe/photoswipe.min.js' );
		hiweb_lightbox()->js( '/assets/photoswipe/photoswipe-ui-default.min.js' );
		hiweb_lightbox()->css( '/assets/photoswipe/photoswipe.css' );
		hiweb_lightbox()->css( '/assets/photoswipe/default-skin/default-skin.css' );
	}