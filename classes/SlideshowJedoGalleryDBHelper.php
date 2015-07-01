<?php
/**
 * Class SlideshowJedoGalleryDBHelper
 *
 * @since 1.0.0
 * @author: jedoson
 */
final class SlideshowJedoGalleryDBHelper extends SlideshowJedoGallery
{
	public function SlideshowJedoGalleryDBHelper($oPlugin) {
		parent::SlideshowJedoGallery();
		
		
		$this->oPlugin = $oPlugin;
		$this->tableName = SlideshowJedoGallery::table_gallery();
		
		$this->select_query = "SELECT `id`, `title`, `layout_width`, `order`, `options`,
									  `created`, `modified`, 
		                              (SELECT COUNT(*) 
		                                 FROM `" . SlideshowJedoGallery::table_galleryslide() . "` slide
		                                WHERE slide.gallery_id = gallery.id) AS slide_count 
                                  FROM `" . $this->tableName . "` gallery";
	}
	
	public function new_order() {
		global $wpdb;
		return $wpdb->get_var($wpdb->prepare("SELECT max(`order`)+1 FROM `" . $this->tableName . "`"));
	}
	
	
	public function select($where = array(), $order = array()) {
		global $wpdb;
		
		$query = $this->select_query;
		if(!empty($where) && 0 < count($where)) {
		
			$query .= " WHERE";
			$c = 1;
			foreach ($where as $ckey => $cval) {
		
				$query .= " `" . $ckey . "` = '" . $cval . "'";
					
				if ($c < count($where)) {
					$query .= " AND";
				}
				$c++;
			}
		}
		if(!empty($order) && 0 < count($order)) {
		
			$query .= " ORDER BY ";
			$c = 1;
			foreach ($order as $val) {
				$query .= " `" . $val . "` ";
					
				if ($c < count($order)) {
					$query .= ",";
				}
				$c++;
			}
		}
		return $wpdb->get_results($wpdb->prepare($query));
	}
	
	
	public function save() {
		global $wpdb;
		
		$options->container_width = $_POST['container_width'];
		$options->container_height = $_POST['container_height'];
		$options->gallery_bgcolor = $_POST['gallery_bgcolor'];
		$options->slide_effect = $_POST['slide_effect'];
		$options->slide_direction = $_POST['slide_direction'];
		$options->auto_slide = $_POST['auto_slide'];
		$options->auto_slide_speed = $_POST['auto_slide_speed'];
		$options->easing = $_POST['easing'];
		$options->slide_speed = $_POST['slide_speed'];
		$options->show_nav_button = $_POST['show_nav_button'];
		$options->show_info = $_POST['show_info'];
		$options->show_thumbnails = $_POST['show_thumbnails'];
		$options->thumbnails_position = $_POST['thumbnails_position'];
		$options->thumbnails_color = $_POST['thumbnails_color'];
		$options->thumbnails_active_color = $_POST['thumbnails_active_color'];
		$options->thumbnails_width = $_POST['thumbnails_width'];
		$options->thumbnails_height = $_POST['thumbnails_height'];
		$options->thumbnails_opacity = $_POST['thumbnails_opacity'];
		$options->thumbnails_scroll_speed = $_POST['thumbnails_scroll_speed'];
		$options->thumbnails_spacing = $_POST['thumbnails_spacing'];
		
		if(empty($_POST['id'])) {
			$result = $wpdb->insert(SlideshowJedoGallery::table_gallery(), 
						  array(
							  'title' => $_POST['title'],
						  	  'layout_width' => $_POST['layout_width'],
							  'order' => $_POST['order'],
						  	  'options' => json_encode($options),
							  'created' => date("Y-m-d A h:i:s"),
							  'modified' => date("Y-m-d A h:i:s")
							));
			if($result == false) {
				throw new Exception("SlideshowJedoGalleryDBHelper save::insert error");
			}
		} else {
			
			$result = $wpdb->update(SlideshowJedoGallery::table_gallery(), 
						  array(
							  'title' => $_POST['title'],
						  	  'layout_width' => $_POST['layout_width'],
							  'order' => $_POST['order'],
						  	  'options' => json_encode($options),
							  'modified' => date("Y-m-d A h:i:s")
						  ), 
						  array(
							  'id' => $_POST['id']
						  ));
			if($result == false) {
				throw new Exception("SlideshowJedoGalleryDBHelper id["+$_POST['id']+"] save::update error");
			}
		}
	}


	public function delete($id) {
		global $wpdb;

		$this->oPlugin->oGallerySlideDBHelper->delete_from_gallery($id);
		
		$wpdb->delete(SlideshowJedoGallery::table_gallery(), array('id' => $id));
	}
}
?>