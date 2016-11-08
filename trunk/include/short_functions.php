<?php
	
	if(!function_exists('hiweb_lightbox')){
		
		function hiweb_lightbox(){
			static $class;
			if(!$class instanceof hw_lightbox) $class = new hw_lightbox();
			return $class;
		}
		
	}