<?php
	
	//Render Lightbox
	add_action( 'wp_footer', array( hiweb_lightbox(), '_add_action_wp_footer' ) );
	//Add full image size attrs to link
	add_filter( 'wp_get_attachment_link', array( hiweb_lightbox(), '_add_filter_wp_get_attachment_link' ), 999, 2 );
	add_filter( 'the_content', array( hiweb_lightbox(), '_add_filter_the_content' ) );