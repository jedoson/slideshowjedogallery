<?php
/*
Plugin Name: Slideshow Jedo Gallery
Plugin URI: http://www.jedoson.com/
Author: jedoson
Author URI: http://www.jedoson.com/
Description: 슬라이드쇼
Version: 1.0.0
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: slideshow gallery, slideshow, gallery, slider, jquery, galleries, photos, images
Text Domain: slideshow-jedo-gallery
Domain Path: /languages
*/

if (!defined('DS')) { define('DS', DIRECTORY_SEPARATOR); }
require_once(dirname(__FILE__) . DS . 'classes' . DS . 'SlideshowJedoGallery.php');
require_once(dirname(__FILE__) . DS . 'classes' . DS . 'SlideshowJedoGalleryInstaller.php');
require_once(dirname(__FILE__) . DS . 'classes' . DS . 'SlideshowJedoGalleryDBHelper.php');
require_once(dirname(__FILE__) . DS . 'classes' . DS . 'SlideshowJedoSlideDBHelper.php');
require_once(dirname(__FILE__) . DS . 'classes' . DS . 'SlideshowJedoGallerySlideDBHelper.php');
require_once(dirname(__FILE__) . DS . 'classes' . DS . 'SlideshowJedoGallerySetting.php');
require_once(dirname(__FILE__) . DS . 'classes' . DS . 'SlideshowJedoGalleryAjax.php');
require_once(dirname(__FILE__) . DS . 'classes' . DS . 'SlideshowJedoGalleryPlugin.php');
$oSlideshowJedoGalleryPlugin = new SlideshowJedoGalleryPlugin(dirname(__FILE__));

register_activation_hook(__FILE__, array($oSlideshowJedoGalleryPlugin, 'slideshow_jedo_gallery_install'));
register_deactivation_hook(__FILE__, array($oSlideshowJedoGalleryPlugin, 'slideshow_jedo_gallery_uninstall'));

if (!function_exists('slideshowjedogallery')) {
	function slideshowjedogallery($output = true, $gallery_id = null, $post_id = null, $params = array()) {
		$params['gallery_id'] = $gallery_id;
		$params['post_id'] = $post_id;

		$content = $oSlideshowJedoGalleryPlugin -> shortcode_slideshowjedogallery($params, false);

		if ($output == true) {
			echo $content;
		} else {
			return $content;
		}
	}
}
?>
