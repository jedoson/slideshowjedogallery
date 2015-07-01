<?php
/**
 * Class SlideshowJedoGalleryAjax
 *
 * @since 1.0.0
 * @author: jedoson
 */
final class SlideshowJedoGalleryAjax extends SlideshowJedoGallery {
	
	
	public function SlideshowJedoGalleryAjax ($oPlugin) {
		parent::SlideshowJedoGallery();
		
		$this->oPlugin = $oPlugin;
		
		
		
		add_action( 'wp_enqueue_scripts', array($this, 'slideshow_jedo_gallery_ajax_scripts'));
		
		add_action( 'wp_ajax_get_gallery_slides', array($this, 'ajax_get_gallery_slides'));
		add_action( 'wp_ajax_nopriv_get_gallery_slides', array($this, 'ajax_get_gallery_slides'));
	}
	
	
	public function slideshow_jedo_gallery_ajax_scripts() {
		
		wp_enqueue_script('json2');
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-effects-core');
		wp_enqueue_script('jquery-effects-blind');
		wp_enqueue_script('jquery-effects-bounce');
		wp_enqueue_script('jquery-effects-clip');
		wp_enqueue_script('jquery-effects-drop');
		wp_enqueue_script('jquery-effects-explode');
		wp_enqueue_script('jquery-effects-fade');
		wp_enqueue_script('jquery-effects-fold');
		wp_enqueue_script('jquery-effects-highlight');
		wp_enqueue_script('jquery-effects-pulsate');
		wp_enqueue_script('jquery-effects-scale');
		wp_enqueue_script('jquery-effects-shake');
		wp_enqueue_script('jquery-effects-slide');
		wp_enqueue_script('jquery-effects-transfer');
		wp_enqueue_script('jquery-ui-slider');
		wp_enqueue_script('jquery-ui-position');
		wp_enqueue_script('jquery-ui-draggable');
		wp_enqueue_script('jquery-ui-resizable');
		wp_enqueue_script('jquery-ui-dialog');
		wp_enqueue_script('iris');
		
		wp_enqueue_script('bootstrap-script',
				'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js',
				array('jquery'), null, true);
		
		wp_enqueue_style('bootstrap-theme-style',
				'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css',
				array());
			
		wp_enqueue_style('jquery-ui-style',
				'//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css',
				array());
		
		if(!wp_style_is('kboard-skin-default')) {
			wp_enqueue_style('font-awesome-style',
					'//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',
					array());
		}
		
		if ($_GET['method'] == "save-slide-form" || $_GET['method'] == "save-mslide-form") {
			wp_enqueue_media();
		}
		
		wp_enqueue_style('slideshow_jedo_gallery_plugin_style');
		wp_enqueue_script('slideshow_jedo_gallery_plugin_script');
		
		wp_localize_script(
				'slideshow_jedo_gallery_plugin_script',
				'SlideshowJedoGalleryAjax',
				array(
						'AJAX_URL' => admin_url( 'admin-ajax.php' ),
				));
	}
	
	public function ajax_get_gallery_slides() {
		if ( ! empty( $_REQUEST['m'] ) ) {
			
			
			$method = $_REQUEST['m'];
			$gallery_id = $_REQUEST['gallery_id'];
			
			$galleris = $this->oPlugin->oGalleryDBHelper->select(array('id'=>$gallery_id));
			if(0 < count($galleris)) {
				$slides = $this->oPlugin->oSlideDBHelper->selectGallerySlide($gallery_id);
				$gallery = $galleris[0];
				$gallery->options = json_decode($gallery->options);
				
				foreach ($slides as $slide) {
					$slide->options = json_decode($slide->options);
				}
				$data = array(
						'm' => $method,
						'result' => true, 
						'gallery_id' => $gallery_id,
						'gallery' => $gallery,
						'slides' => $slides
						);
			} else {
				$data = array(
						'm' => $method,
						'result' => false,
						'message' => 'not found galleris',
						'gallery_id' => $gallery_id,
						'gallery' => $gallery,
						'slides' => $slides
						);
			}
			echo json_encode( $data );
		} 
		wp_die();
	}
}

?>