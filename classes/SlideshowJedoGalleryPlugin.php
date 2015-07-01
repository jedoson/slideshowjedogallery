<?php
/**
 * Class SlideshowJedoGalleryPlugin
 *
 * @since 1.0.0
 * @author: jedoson
 */
final class SlideshowJedoGalleryPlugin extends SlideshowJedoGallery
{
	public function SlideshowJedoGalleryPlugin($plugin_dir) {
		parent::SlideshowJedoGallery();
		
		$this -> plugin_dir = $plugin_dir;
		
		$url = explode("&", $_SERVER['REQUEST_URI']);
		$this -> url = $url[0];
		$this -> referer = (empty($_SERVER['HTTP_REFERER'])) ? $this -> url : $_SERVER['HTTP_REFERER'];
		$this -> textDomain = basename($this->plugin_dir);
		
		$this->oGallerySetting = new SlideshowJedoGallerySetting($this);
		$this->oGalleryDBHelper = new SlideshowJedoGalleryDBHelper($this);
		$this->oSlideDBHelper = new SlideshowJedoSlideDBHelper($this);
		$this->oGallerySlideDBHelper = new SlideshowJedoGallerySlideDBHelper($this);
		
		wp_register_style('slideshow_jedo_gallery_plugin_style', plugin_dir_url( __FILE__ ) . '../css/jedo.SlideshowJedoGallery.css' );
		wp_register_script(	'slideshow_jedo_gallery_plugin_script',
							plugin_dir_url( __FILE__ ) . '../js/jedo.SlideshowJedoGallery.js',
							array( 'jquery' ) );
		
		$this->oAjax = new SlideshowJedoGalleryAjax($this);
		
		add_action('admin_menu', array($this, 'slideshow_jedo_gallery_create_menu'));
		add_action('admin_print_styles', array($this, 'slideshow_jedo_gallery_admin_styles'));
		add_action('admin_print_scripts', array($this, 'slideshow_jedo_gallery_admin_scripts'));
		
		add_shortcode("slideshowjedogallery", array($this, 'shortcode_slideshowjedogallery'));
	}
	
	public function slideshow_jedo_gallery_install() {

		try {
			$installer = new SlideshowJedoGalleryInstaller();
			$installer->createTables();
			$installer->make_uploaddir();
		} catch (Exception $e) {
			die('<script>alert("' . $e->getMessage() . '");history.go(-1);</script>');
		}
	}

	public function slideshow_jedo_gallery_uninstall() {
	
		$installer = new SlideshowJedoGalleryInstaller();
		$installer->dropTables();
		$installer->delete_uploaddir();
	}
	
	public function slideshow_jedo_gallery_create_menu() {
		
		add_menu_page('슬라이드쇼 제도', '슬라이드쇼 제도', 'administrator', 'slideshow_jedo_gallery', array($this, 'slideshow_jedo_gallery')); 
		add_submenu_page('slideshow_jedo_gallery',	'gallery',	'갤러리 관리',	'administrator',	'slideshow_jedo_gallery',	array($this, 'slideshow_jedo_gallery')); 
		add_submenu_page('slideshow_jedo_gallery',	'slide',	'슬라이드 관리',	'administrator',	'slideshow_jedo_slide',		array($this, 'slideshow_jedo_slide'));
		//add_submenu_page('slideshow_jedo_gallery',	'setting',	'설정 관리',	'administrator',	'slideshow_jedo_setting',	array($this, 'slideshow_jedo_setting'));
	}
	
	public function slideshow_jedo_setting() {
		try {
			switch ($_GET['method']) {
				case 'save-setting' :
					$this->oGallerySetting->save();
					$this->redirect($this->url);
					break;
				default :
					include($this->plugin_dir . DS . "views" . DS . "admin" . DS . "jedo-setting" . DS . "index.php");
					break;
			}
		} catch (Exception $e) {
			die('<script>alert("' . $e->getMessage() . '");history.go(-1);</script>');
		}
	}
	
	public function slideshow_jedo_slide() {
		try {
			switch ($_REQUEST['method']) {
				case 'save-slide-form' :
					include($this->plugin_dir . DS . "views" . DS . "admin" . DS . "jedo-slide" . DS . "save.php");
					break;
				case 'save-mslide-form' :
					include($this->plugin_dir . DS . "views" . DS . "admin" . DS . "jedo-slide" . DS . "msave.php");
					break;
				case 'save-mslide' :
					foreach ($_POST['ckGallery'] as $id) {
						$this->oSlideDBHelper->delete($id);
					}
					$this->oSlideDBHelper->save($_POST['id'], $_POST['title'], $_POST['order']);
					$this->redirect($this->url);
					break;
				case 'save-slide-all' :
					if($_POST['action'] == "delete" ) {
			
						foreach ($_POST['ckSlide'] as $id) {
							$this->oSlideDBHelper->delete($id);
						}
					}
					$this->redirect($this->url);
					break;
				case 'delete' :
					try {
						$this->oSlideDBHelper->delete($_REQUEST['slide_id']);
						$this->redirect($this->url);
			
					} catch (Exception $e) {
			
						$this->redirect($this->url, $e->getMessage());
					}
					break;
				case 'save-slide' :
						$this->oSlideDBHelper->save();
						//$this->redirect($this->url);
						//break;
				case 'select-gallery-slide' :
				default :
					include($this->plugin_dir . DS . "views" . DS . "admin" . DS . "jedo-slide" . DS . "index.php");
					break;
			}
		} catch (Exception $e) {
			die('<script>alert("' . $e->getMessage() . '");history.go(-1);</script>');
		}
	}

	public function slideshow_jedo_gallery() {
		try {
			switch ($_GET['method']) {
			case 'save-gallery-form' :
				include($this->plugin_dir . DS . "views" . DS . "admin" . DS . "jedo-gallery" . DS . "save.php");
				break;
			case 'save-gallery' :
				$this->oGalleryDBHelper->save();
				$this->redirect($this->url);
				break;
			case 'save-gallery-all' :
				if($_POST['action'] == "delete" ) {
	
					foreach ($_POST['ckGallery'] as $id) {
						$this->oGalleryDBHelper->delete($id);
					}
				}
				$this->redirect($this->url);
				break;
			case 'delete' :
				$this->oGalleryDBHelper->delete($_GET['id']);
				$this->redirect($this->url);
				break;
			case 'select-gallery-slide' :
				include($this->plugin_dir . DS . "views" . DS . "admin" . DS . "jedo-slide" . DS . "index.php");
				break;
			default :
				include($this->plugin_dir . DS . "views" . DS . "admin" . DS . "jedo-gallery" . DS . "index.php");
				break;
			}
		} catch (Exception $e) {
			die('<script>alert("' . $e->getMessage() . '");history.go(-1);</script>');
		}
	}
	
	public function slideshow_jedo_gallery_admin_styles() {
		
		wp_enqueue_style('bootstrap-style',
				'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css',
				array());

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
	}
	
	public function slideshow_jedo_gallery_admin_scripts() {
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
	
	public function redirect($url, $message = NULL) {
		?>
		<script type="text/javascript">
		var message = '<?php echo ($message == NULL) ? '' : $message; ?>';
		if(message != "") {

			alert(message);
		}  
		window.location = '<?php echo $url; ?>';
		</script>
		<?php
	}
	
	public function shortcode_slideshowjedogallery($atts = array(), $content = null) {
		$this->shortcodeparam = $atts;
		include($this->plugin_dir . DS . "slideshow-jedo-gallery-shortcode.php");
	}
}
?>



