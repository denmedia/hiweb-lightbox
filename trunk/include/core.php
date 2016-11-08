<?php
	
	if( !class_exists( 'hw_lightbox' ) ) :
		
		class hw_lightbox{
			
			
			private $modules = array();
			
			
			public function __call( $name, $arguments ){
				$this->console()->warn( 'hiweb_lightbox()->' . $name . '() error: вызван не существующий метод [' . $name . ']', true );
			}
			
			
			/**
			 * @return bool|hw_lightbox_arrays
			 */
			public function arrays(){
				return $this->module( 'arrays' );
			}
			
			
			/**
			 * @return bool|hw_lightbox_backtrace
			 */
			public function backtrace(){
				return $this->module( 'backtrace' );
			}
			
			
			/**
			 * @param null $data
			 * @return bool|hw_lightbox_console
			 */
			public function console( $data = null ){
				if( !is_null( $data ) || trim( $data ) != '' )
					return $this->module( 'console' )->info( $data ); else return $this->module( 'console', $data );
			}
			
			
			/**
			 * @param $file
			 * @return mixed
			 */
			public function css( $file ){
				return $this->module( 'css' )->enqueue( $file );
			}
			
			
			/**
			 * @param       $file
			 * @param array $afterJS - список предварительных JS файлов от WP
			 * @param bool $in_footer - показывать в фтуре
			 * @return mixed
			 */
			public function js( $file, $afterJS = array(), $in_footer = false ){
				return $this->module( 'js' )->enqueue( $file, $afterJS, $in_footer );
			}
			
			
			/**
			 * @return bool|hw_lightbox_path
			 */
			public function path(){
				return $this->module( 'path' );
			}
			
			
			/**
			 * @return bool|hw_lightbox_wp
			 */
			public function wp(){
				return $this->module( 'wp' );
			}
			
			
			/**
			 * Вывести HTML код для оверлея
			 */
			public function _add_action_wp_footer(){
				include 'templates/pswp.php';
			}
			
			
			public function _add_filter_wp_get_attachment_link( $link, $id ){
				$full_image = wp_get_attachment_metadata( $id );
				if( $full_image !== false ){
					$link = str_replace( '<a ', "<a data-full-width='$full_image[width]' data-full-height='$full_image[height]' ", $link );
				}
				return $link;
			}
			
			public function _add_filter_the_content( $content ){
				if( preg_match_all( '/<a.+href=[\\\'\"].+[\\\'\"].*>.*<img.*class=[\\\'\"].*wp-image-([\d]+).*[\\\'\"].*>.*<\/a>/im', $content, $mathes ) ){
					$replaces = array();
					foreach( $mathes[0] as $index => $source ){
						$image = wp_get_attachment_metadata( $mathes[1][ $index ] );
						if( $image != false ){
							$replaces[$source] = str_replace( '<a ','<a data-full-width="'.$image['width'].'" data-full-height="'.$image['height'].'"', $source );
						}
					}
					$content = strtr($content, $replaces);
				}
				return $content;
			}
			
			
			/**
			 * Подключение модуля
			 * @param            $name
			 * @param null|mixed $data
			 * @param bool $newInstance
			 * @return mixed
			 * @version 1.0
			 */
			protected function module( $name, $data = null, $newInstance = false ){
				if( !array_key_exists( $name, $this->modules ) )
					$this->modules[ $name ] = array();
				$index = count( $this->modules[ $name ] );
				if( $index == 0 || $newInstance ){
					$className = 'hw_lightbox_' . $name;
					$this->modules[ $name ][ $index ] = null;
					include_once HIWEB_LB_DIR_MODULES . '/' . $name . '.php';
					$this->modules[ $name ][ $index ] = new $className( $data );
				}
				return end( $this->modules[ $name ] );
			}
			
		}
	
	endif;