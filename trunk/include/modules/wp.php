<?php
	/**
	 * Created by PhpStorm.
	 * User: d9251
	 * Date: 31.08.2016
	 * Time: 17:36
	 */




	/**
	 * Класс для работы с WordPress
	 * Class hiweb_wp
	 */
	class hw_lightbox_wp{


		/**
		 * Возвращает TRUE, если текущий запрос происходит через AJAX
		 * @return bool
		 */
		public function is_ajax(){
			return ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || ( !empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' );
		}


	}