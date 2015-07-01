<?php
/**
 * Class SlideshowJedoGallerySlideDBHelper
 *
 * @since 1.0.0
 * @author: jedoson
 */
final class SlideshowJedoGallerySlideDBHelper extends SlideshowJedoGallery
{
	public function SlideshowJedoGallerySlideDBHelper($oPlugin) {
		//echo "SlideshowJedoGallerySlideDBHelper >> ";
		parent::SlideshowJedoGallery();


		$this->oPlugin = $oPlugin;
		$this->tableName = SlideshowJedoGallery::table_galleryslide();
	}

	public function select($where) {
		global $wpdb;
		
		$query = "SELECT `id`, `gallery_id`, `slide_id`, `order`, `created`, `modified`,
						(SELECT `title` FROM `" . SlideshowJedoGallery::table_gallery() . "` WHERE id = galleryslide.gallery_id) AS `gallery_title`,
						(SELECT `title` FROM `" . SlideshowJedoGallery::table_slide() . "` WHERE id = galleryslide.slide_id) AS `slide_title`
                    FROM `" . $this->tableName . "` galleryslide ";
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
		return $wpdb->get_results($wpdb->prepare($query));
	}

	public function save($slide_id, $galleris) {
		if(empty($slide_id)) {
			throw new Exception(__CLASS__ . ".save param slide_id is empty");
		}
		if(empty($galleris)) {
			throw new Exception(__CLASS__ . ".save param galleris is empty");
		}
		
		global $wpdb;
		
		$this->delete_from_gallery($galleris);
		$this->delete_from_slide($slide_id);
		foreach ($galleris as $gallery_id) {
			
			$result = $wpdb->insert($this->tableName,
						array(
							'gallery_id' => $gallery_id,
							'slide_id' => $slide_id,
							'order' => 0,
							'created' => date("Y-m-d A h:i:s"),
							'modified' => date("Y-m-d A h:i:s")
						));
			if($result == false) {
				throw new Exception(__CLASS__ . ".save insert galleryslide time error");
			}
		}
	}


	public function delete_from_slide($slide_id) {
		if(empty($slide_id)) {
			throw new Exception(__CLASS__ . ".delete param slide_id is empty");
		}
		
		global $wpdb;
		$result = $wpdb->delete($this->tableName, array('slide_id' => $slide_id));
		
	}
	
	public function delete_from_gallery($gallery_id) {
		if(empty($gallery_id)) {
			throw new Exception(__CLASS__ . ".delete param gallery_id is empty");
		}
	
		global $wpdb;
		$result = $wpdb->delete($this->tableName, array('gallery_id' => $gallery_id));
	
	}
	
	public function isGallerySlideIn($gallery_id, $slide_id) {
		if(empty($gallery_id) || empty($slide_id)) {
			return false;
		}
		
		global $wpdb;
		
		$query = "SELECT COUNT(*) FROM `" . $this->tableName . "` ";
		$query .= " WHERE `gallery_id` = %d AND `slide_id` = %d";
		$result = $wpdb->get_var($wpdb->prepare($query, array($gallery_id, $slide_id)));
		if($result == null) {
			throw new Exception(__CLASS__ . ".get count time error");
		}
		return 0 < $result;
	}
}
?>