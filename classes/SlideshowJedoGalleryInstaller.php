<?php
/**
 * Class SlideshowJedoGalleryInstaller
 *
 * @since 1.0.0
 * @author: jedoson
 */
final class SlideshowJedoGalleryInstaller extends SlideshowJedoGallery
{
	public function SlideshowJedoGalleryInstaller() {
		parent::SlideshowJedoGallery();	
		
	}

	public function createTables() {

		$this->create_table_slideshow_jedo_gallery();
		$this->create_table_slideshow_jedo_slide();
		$this->create_table_slideshow_jedo_galleryslide();
	}
	
	public function dropTables() {
		
		$this->drop_table_slideshow_jedo_gallery();
		$this->drop_table_slideshow_jedo_slide();
		$this->drop_table_slideshow_jedo_galleryslide();
	}
	
	public function make_uploaddir() {
		$uploaddir = SlideshowJedoGallery::uploads_slideshowjedogallery_path();
		if (!file_exists($uploaddir)) {
			if (@mkdir($uploaddir, 0777)) {
				@chmod($uploaddir, 0777);
				
				$thumbnaildir = SlideshowJedoGallery::thumbnails_slideshowjedogallery_path();
				if (!file_exists($thumbnaildir)) {
					if (@mkdir($thumbnaildir, 0777)) {
						@chmod($thumbnaildir, 0777);
						return true;
					}
				}
			}
		}
		return false;
	}
	
	public function delete_uploaddir() {
		
		$this->delete_thumbnaildir();
		
		$uploaddir = SlideshowJedoGallery::uploads_slideshowjedogallery_path();
		if (file_exists($uploaddir)) {
			@chmod($uploaddir,0777);//삭제하려는 폴더의 퍼미션을 777로 재 지정
			$directory = dir($uploaddir);
			while($entry = $directory->read()) {
				if ($entry != "." && $entry != "..") {
					if (is_dir($uploaddir."/".$entry)) { //삭제하려는 폴더안에 서브 폴더가 있을경우 재루프
						//@chmod($uploaddir."/".$entry,0777);//삭제하려는 폴더의 퍼미션을 777로 재 지정
						delete_dir($uploaddir."/".$entry);
					} else {
						@chmod($uploaddir."/".$entry,0777);//삭제하려는 폴더안에 파일일 경우 파일 퍼미션을 777로 재지정
						@UnLink ($uploaddir."/".$entry);
					}
				}
			}
			$directory->close();
			@rmdir($uploaddir);
		}
		return false;
	}
	
	private function delete_thumbnaildir() {
		$thumbnailsdir = SlideshowJedoGallery::thumbnails_slideshowjedogallery_path();
		if (file_exists($thumbnailsdir)) {
			@chmod($thumbnailsdir,0777);//삭제하려는 폴더의 퍼미션을 777로 재 지정
			$directory = dir($thumbnailsdir);
			while($entry = $directory->read()) {
				if ($entry != "." && $entry != "..") {
					if (is_dir($thumbnailsdir."/".$entry)) { //삭제하려는 폴더안에 서브 폴더가 있을경우 재루프
						delete_dir($thumbnailsdir."/".$entry);
					} else {
						@chmod($thumbnailsdir."/".$entry,0777);//삭제하려는 폴더안에 파일일 경우 파일 퍼미션을 777로 재지정
						@UnLink ($thumbnailsdir."/".$entry);
					}
				}
			}
			$directory->close();
			@rmdir($thumbnailsdir);
		}
		return false;
	}
	
	private function create_table_slideshow_jedo_gallery() {
		global $wpdb;
		
		if (!$wpdb -> get_var("SHOW TABLES LIKE '" . SlideshowJedoGallery::table_gallery() . "'")) {				
			$query = "CREATE TABLE " . SlideshowJedoGallery::table_gallery() . "  (
						`id` int(11) NOT NULL AUTO_INCREMENT,
						`title` varchar(150) NOT NULL DEFAULT '',
						`layout_width` enum('fix','fluid') NOT NULL DEFAULT 'fluid',
						`order` int(11) NOT NULL DEFAULT '0',
						`options` mediumtext NULL,
						`created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
						`modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
						PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8; " ;
			
			//$wpdb->query($query);
			require_once(ABSPATH . 'wp-admin' . DS . 'upgrade-functions.php');
			dbDelta($query, true);
		}
	}
	
	
	private function create_table_slideshow_jedo_slide() {
		global $wpdb;
		
		if (!$wpdb -> get_var("SHOW TABLES LIKE '" . SlideshowJedoGallery::table_slide() . "'")) {				
			$query = "CREATE TABLE " . SlideshowJedoGallery::table_slide() . " (
						`id` int(11) NOT NULL AUTO_INCREMENT,
						`title` varchar(150) NOT NULL DEFAULT '',
						`description` text NOT NULL,
						`order` int(11) NOT NULL DEFAULT '0',
					    `options` mediumtext NULL,
						`created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
						`modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
						PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8; " ;
			
			
			//$wpdb->query($query);
			require_once(ABSPATH . 'wp-admin' . DS . 'upgrade-functions.php');
			dbDelta($query, true);
		}
	}
	
	private function create_table_slideshow_jedo_galleryslide() {
		global $wpdb;
		
		if (!$wpdb -> get_var("SHOW TABLES LIKE '" . SlideshowJedoGallery::table_galleryslide() . "'")) {				
			$query = "	CREATE TABLE " . SlideshowJedoGallery::table_galleryslide() . " (
							`id` int(11) NOT NULL AUTO_INCREMENT,
							`gallery_id` int(11) NOT NULL DEFAULT '0',
							`slide_id` int(11) NOT NULL DEFAULT '0',
							`order` int(11) NOT NULL DEFAULT '0',
							`created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
							`modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
							PRIMARY KEY (`id`),
									KEY `gallery_id` (`gallery_id`),
									KEY `slide_id` (`slide_id`)
									) ENGINE=MyISAM  DEFAULT CHARSET=utf8; " ;
			
			//$wpdb->query($query);
			require_once(ABSPATH . 'wp-admin' . DS . 'upgrade-functions.php');
			dbDelta($query, true);
		}
	}
	
	

	
	
	private function drop_table_slideshow_jedo_gallery() {
		global $wpdb;
		$query = "DROP TABLE " . SlideshowJedoGallery::table_gallery();
	
		$wpdb->query($query);
		require_once(ABSPATH . 'wp-admin' . DS . 'upgrade-functions.php');
		dbDelta($query, true);
	}
	
	private function drop_table_slideshow_jedo_slide() {
		global $wpdb;
		$query = "DROP TABLE " . SlideshowJedoGallery::table_slide();
	
		$wpdb->query($query);
		require_once(ABSPATH . 'wp-admin' . DS . 'upgrade-functions.php');
		dbDelta($query, true);
	}
	
	private function drop_table_slideshow_jedo_galleryslide() {
		global $wpdb;
		$query = "DROP TABLE " . SlideshowJedoGallery::table_galleryslide();
	
		$wpdb->query($query);
		require_once(ABSPATH . 'wp-admin' . DS . 'upgrade-functions.php');
		dbDelta($query, true);
	}
}

?>