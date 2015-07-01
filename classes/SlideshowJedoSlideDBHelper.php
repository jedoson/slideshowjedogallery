<?php
/**
 * Class SlideshowJedoSlideDBHelper
 *
 * @since 1.0.0
 * @author: jedoson
 */
final class SlideshowJedoSlideDBHelper extends SlideshowJedoGallery
{
	public function SlideshowJedoSlideDBHelper($oPlugin) {
		parent::SlideshowJedoGallery();
		
		$this->oPlugin = $oPlugin;
		$this->tableName = SlideshowJedoGallery::table_slide();
		
		$this->select_query = "SELECT `id`, `title`, `description`, `order`, 
								`options`,
								`created`, `modified`
		                         FROM `" . $this->tableName . "` slide";
	}
	
	public function new_order() {
		global $wpdb;
		return $wpdb->get_var($wpdb->prepare("SELECT max(`order`)+1 FROM `" . $this->tableName . "`"));
	}
	
	
	public function select($where = array(), $orders = array()) {
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
		if(!empty($orders) && 0 < count($orders)) {
				
			$c = 1;
			$query .= " ORDER BY ";
			foreach ($orders as $column => $order) {
				
				$query .= " `" . $column . "` " . $order;
				if ($c < count($orders)) {
					$query .= ",";
				}
				$c++;
			}
		}
		return $wpdb->get_results($wpdb->prepare($query));
	}
	
	public function selectGallerySlide($gallery_id, $orders = array()) {
		global $wpdb;
		
		$query = "SELECT `id`, `title`, `description`, `order`, `options`, `created`, `modified`
		            FROM `" . $this->tableName . "` slide 
		           WHERE slide.id IN (SELECT slide_id 
		            		            FROM `" . SlideshowJedoGallery::table_galleryslide() . "` galleryslide 
		            		           WHERE galleryslide.gallery_id = " . $gallery_id . ")
		           
		         ";
		if(!empty($orders) && 0 < count($orders)) {
				
			$c = 1;
			$query .= " ORDER BY ";
			foreach ($orders as $column => $order) {
				
				$query .= " `" . $column . "` " . $order;
				if ($c < count($orders)) {
					$query .= ",";
				}
				$c++;
			}
		}
		return $wpdb->get_results($wpdb->prepare($query));
	}
	
	
	private function get_new_file_name($imagepath, $imagename, $idx) {
		
		$imagefull = $imagepath . "JG" . $idx . $imagename;
		
		if(is_file($imagefull)) {
		
			return $this->get_new_file_name($imagepath, $imagename, $idx+1);
		} else {
			return 	array("image_full_name" => $imagefull,
						"image_name" => "JG" . $idx . $imagename
			);
		}
	}
	
	private function save_file() {
		
		try {
			$tmp_name = $_FILES['image_file']['tmp_name'];
			$origin_filename = $_FILES['image_file']['name'];
			$pathinfo = pathinfo($origin_filename);
			$image_nm = strtolower($pathinfo['filename']);
			$image_ext = strtolower($pathinfo['extension']);
			
			$image_name = array_sum(explode(' ',microtime())) . "." . $image_ext;
			$imagefull = SlideshowJedoGallery::uploads_slideshowjedogallery_path() . $image_name;
			
			
			$issafe = false;
			$mimes = get_allowed_mime_types();
			foreach ($mimes as $type => $mime) {
				if (strpos($type, $image_ext) !== false) {
					$issafe = true;
				}
			}
			if ($issafe) {
				if (is_uploaded_file($tmp_name)) {
					
					if(move_uploaded_file($tmp_name, $imagefull)) {
					
						$thumbimage = wp_get_image_editor($imagefull);
						if ( ! is_wp_error( $thumbimage ) ) {
							
							$thumbimage->resize( 250, 250, true );
							$thumbimage->save(SlideshowJedoGallery::thumbnails_slideshowjedogallery_path() . $image_name );
						} else {
							
							throw new Exception(__CLASS__ . " is_wp_error error code[" . $thumbimage->get_error_code() . "] " . $thumbimage->get_error_message());
							wp_die();
						}
					} else {
						throw new Exception(__CLASS__ . " move_uploaded_file error ");
							wp_die();
					}
				} else {
					
					throw new Exception(__CLASS__ . " is_uploaded_file error ");
					wp_die();
				}
			} else {
				
				throw new Exception(__CLASS__ . " mime type error ");
				wp_die();
			}
			return array(
					"image_name" => $image_name,
					"image_url" => SlideshowJedoGallery::uploads_slideshowjedogallery_url() . $image_name,
					"origin_filename" => $origin_filename
			);
		} catch(Exception $e) {
			
			echo " slide save_file " . $e->getMessage();
			wp_die();
		}
	}
	
	
	public function save() {
		global $wpdb;
		


		
		if(empty($_POST['id'])) {
			
			$fdata = array();
			
			if($_POST['type'] == "media") {
				
				$fdata['image_name'] = "";
				$fdata['image_url'] = $_POST['media_file'];
				$fdata['attachment_id'] = $_POST['attachment_id'];
				$fdata['origin_filename'] = "";
				
			} else if($_POST['type'] == "file") {
				
				if ($_FILES['image_file']['error'] <= 0) {
					
					$fdata = $this->save_file();
				} else {
					throw new Exception(__CLASS__ . " upload file error[".$_FILES['image_file']['error']."]");
					wp_die();
				}
			} else if($_POST['type'] == "url") {
				$fdata['image_name'] = "";
				$fdata['image_url'] = $_POST['image_url'];
				$fdata['attachment_id'] = "";
				$fdata['origin_filename'] = "";
			} else {
				
				throw new Exception(__CLASS__ . " upload type is bad ");
				wp_die();
			}
			
			$options->viewinfo = $_POST['viewinfo'];
			$options->opacity_title = $_POST['opacity_title'];
			$options->opacity_description = $_POST['opacity_description'];
			$options->type = $_POST['type'];
			$options->image_name = $fdata['image_name'];
			$options->image_url = $fdata['image_url'];
			$options->attachment_id = $fdata['attachment_id'];
			$options->origin_filename = $fdata['origin_filename'];
			$options->uselink = $_POST['uselink'];
			$options->link_target = $_POST['link_target'];
			$options->link_url = $_POST['link_url'];
			$options->frame_name = $_POST['frame_name'];
			$options->opacity = $_POST['opacity'];
			$options->viewinfo_bgcolor = $_POST['viewinfo_bgcolor'];
			$options->viewinfo_txtcolor = $_POST['viewinfo_txtcolor'];
			
			
			$wpdb->insert($this->tableName, 
						  array(
							  'title' => $_POST['title'], 
						  	  'description' => $_POST['description'],
						      'order' => $_POST['order'],
						  	  'options' => json_encode($options),
							  'created' => date("Y-m-d A h:i:s"),
							  'modified' => date("Y-m-d A h:i:s")
							));
			
			$datas = $this->select(array('title' => $_POST['title'], 
										'description' => $_POST['description'],
										'order' => $_POST['order']));
			if(empty($datas)) {
				throw new Exception(__CLASS__ . "select inserted data error");
				wp_die();
			}
			if(0 < count($_POST['ckGallery'])) {
				try {
					$this->oPlugin->oGallerySlideDBHelper->save($datas[0]->id, $_POST['ckGallery']);
				}catch(Exception $e) {
					
					throw new Exception(__CLASS__ . "oGallerySlideDBHelper inserted data error");
					wp_die();
				}
			}
		} else {
			
			$options->viewinfo = $_POST['viewinfo'];
			$options->opacity_title = $_POST['opacity_title'];
			$options->opacity_description = $_POST['opacity_description'];
			$options->type = $_POST['type'];
			$options->image_name = $_POST['image_name'];
			$options->image_url = $_POST['image_url'];
			$options->attachment_id = $_POST['attachment_id'];
			$options->uselink = $_POST['uselink'];
			$options->link_target = $_POST['link_target'];
			$options->link_url = $_POST['link_url'];
			$options->frame_name = $_POST['frame_name'];
			$options->opacity = $_POST['opacity'];
			$options->viewinfo_bgcolor = $_POST['viewinfo_bgcolor'];
			$options->viewinfo_txtcolor = $_POST['viewinfo_txtcolor'];
			
			
			$wpdb->update($this->tableName, 
						  array(
							  'title' =>  $_POST['title'], 
						  	  'description' => $_POST['description'],
						  	  'order' => $_POST['order'],
						  	  'options' => json_encode($options),
							  'modified' => date("Y-m-d A h:i:s")
						  ), 
						  array(
							  'id' => $_POST['id']
						  ));
			
			$this->oPlugin->oGallerySlideDBHelper->save($_POST['id'], $_POST['ckGallery']);
		}
		
		
		return true;
		
	}


	public function delete($id) {
		global $wpdb;
		
		$datas = $this -> select(array('id'=>$id));
		if(empty($datas)) {
			throw new Exception(__CLASS__ . " delete[id:" . $id . "] select empty");
		}
		
		$data = $datas[0];
		try {
			$options = json_decode($data->options);
			if($options->type == 'file') {
				try {
					
					$full_file_name = SlideshowJedoGallery::uploads_slideshowjedogallery_path() . $options->image_name;
					if(is_file($full_file_name)) {
						unlink($full_file_name);
					}
				} catch(Excepton $e1) {
					
				}
				try {
					$full_thumbnails_name = SlideshowJedoGallery::thumbnails_slideshowjedogallery_path() . $options->image_name;
					if(is_file($full_thumbnails_name)) {
						unlink($full_thumbnails_name);
					}
				} catch(Excepton $e1) {
						
				}
			}
			
			
			$this->oPlugin->oGallerySlideDBHelper->delete_from_slide($id);
			
			$wpdb->delete($this->tableName, array('id' => $id));
			
		} catch(Excepton $e) {
			
			throw new Exception(__CLASS__ . " delete[id:" . $id . "]:"+$e->getMessage());
		}
	}
	
	
}
?>