<?php
/**
 * Class SlideshowJedoGallerySetting
 *
 * @since 1.0.0
 * @author: jedoson
 */
final class SlideshowJedoGallerySetting extends SlideshowJedoGallery
{
	public function SlideshowJedoGallerySetting($oPlugin) {
		parent::SlideshowJedoGallery();
		
		
		$this->oPlugin = $oPlugin;
	}
	
	public function select() {
		return get_option(SlideshowJedoGallery::OPTION_NAME, array(
				'gallery_width' => '500',
				'gallery_height' => '400',
				'slideshow_effect' => 'slide',
				'slide_speed' => '2000',
				'slide_direction' => 'LR',
				'auto_slide' => 'Y',
				'easing' => 'linear',
				'show_nav_button' => 'Y',
				'show_info' => 'Y',
				'slide_opacity' => '70'
		));
	}
	
	public function save() {
		$sjg_options_arr = array(
				'gallery_width' => $_POST['gallery_width'],
				'gallery_height' => $_POST['gallery_height'],
				'slideshow_effect' => $_POST['slideshow_effect'],
				'slide_speed' => $_POST['slide_speed'],
				'slide_direction' => $_POST['slide_direction'],
				'auto_slide' => $_POST['auto_slide'],
				'easing' => $_POST['easing'],
				'show_nav_button' => $_POST['show_nav_button'],
				'show_info' => $_POST['show_info'],
				'slide_opacity' => $_POST['slide_opacity']
		);
		update_option(SlideshowJedoGallery::OPTION_NAME, $sjg_options_arr);
	}
	
	
}
?>