<?php
/**
 * Class SlideshowJedoGallery
 *
 * @since 1.0.0
 * @author: jedoson
 */
abstract class SlideshowJedoGallery {
	
	const VERSON = '1.0.0';
	const NAME = "Slideshow Jedo Gallery";
	const OPTION_NAME = 'slideshow_jedo_gallery_plugin_options';
	const PLUGIN_NAME = 'slideshow-jedo-gallery';
	
	const TYPE_MEDIA = 'media';
	const TYPE_FILE = 'file';
	const TYPE_URL = 'url';
	
	
	const VIEWINFO_BOTH = 'both';
	const VIEWINFO_TITLE = 'title';
	const VIEWINFO_DESCRIPTION = 'description';
	const VIEWINFO_NONE = 'none';
	
	
	public function SlideshowJedoGallery () {
		
	}
	
	public static function table_gallery() {
		global $wpdb;
		return $wpdb->prefix . "slideshow_jedo_gallery";
	}
	
	public static function table_slide() {
		global $wpdb;
		return $wpdb->prefix . "slideshow_jedo_slide";
	}
	
	public static function table_galleryslide() {
		global $wpdb;
		return $wpdb->prefix . "slideshow_jedo_galleryslide";
	}
	
	public static function uploads_wordpress_path() {
		if ($upload_dir = wp_upload_dir()) {
			return str_replace("\\", "/", $upload_dir['basedir']);
		}
		return str_replace("\\", "/", WP_CONTENT_DIR . '/uploads');
	}
	
	public static function uploads_wordpress_url() {
		if ($upload_dir = wp_upload_dir()) {
			return $upload_dir['baseurl'];
		}
		return site_url() . '/wp-content/uploads';
	}
	
	public static function uploads_slideshowjedogallery_path() {
		return SlideshowJedoGallery::uploads_wordpress_path() . DS . SlideshowJedoGallery::PLUGIN_NAME . DS;
	}
	
	public static function thumbnails_slideshowjedogallery_path() {
		return SlideshowJedoGallery::uploads_wordpress_path() . DS . SlideshowJedoGallery::PLUGIN_NAME . DS . "jedothumbnails" . DS;
	}
	
	public static function uploads_slideshowjedogallery_url() {
		return SlideshowJedoGallery::uploads_wordpress_url() . '/' . SlideshowJedoGallery::PLUGIN_NAME . '/';
	}
	
	public static function thumbnails_slideshowjedogallery_url() {
		return SlideshowJedoGallery::uploads_wordpress_url() . '/' . SlideshowJedoGallery::PLUGIN_NAME . '/' . "jedothumbnails" . '/';
	}
	
	public static function set_my_error_handler($errno, $errstr, $errfile, $errline) {
		
		echo "<br/><table bgcolor='#cccccc'><tr>";
		echo "<td><p><strong>ERROR:</strong>".$errstr."</p>
			<p>Please type agin, or contact us and tell us 
			that the error occurred in lin ".$errline." of file".$errfile."
			</p>";
		if(($errno == E_USER_ERROR) || ($errno == E_ERROR)) {
			echo "<p>This is error was fatal, program endding</p>";
		}
		echo "</tr></table>";
	}
}

?>