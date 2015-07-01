<?php
	$gallery_id = $this->shortcodeparam['gallery_id'];
	$design_mode = $this->shortcodeparam['design_mode'];
	$design_mode = empty($design_mode) ? false : $design_mode;
	$view_handle_id = $this->shortcodeparam['view_handle_id'];
	
	$div_gallery_id = "slideshowjedogallery".$gallery_id;
?>
<div id="outter_<?php echo $div_gallery_id; ?>" class="outterslideshowjedogallery" 
	style="background: url(<?php echo plugin_dir_url( __FILE__ );?>images/loading.gif); 
	background-attachment: fixed;
	background-position: center; 
	background-repeat: no-repeat;">
	<div id="<?php echo $div_gallery_id; ?>" class="slideshowjedogallery" ></div>
</div>
<script type="text/javascript">
jQuery(document).ready(function() {
	var oJQueryJedoGallery =  jQuery("#<?php echo $div_gallery_id; ?>");
	var oSlideshowJedoGallery = new jedo.SlideshowJedoGallery(oJQueryJedoGallery);
	oJQueryJedoGallery.data("oSlideshowJedoGallery", oSlideshowJedoGallery);
	jQuery.when(jedo.SlideshowJedoGallery.ajaxGallerySlides("<?php echo $gallery_id; ?>")).done(function(response) {
		//alert(response);
		//return;
		var datas = jQuery.parseJSON(response);
		if(datas.result == true) {
			datas.div_gallery_id = "slideshowjedogallery" + datas.gallery_id;
			datas.design_mode = <?php echo $design_mode ? "true" : "false"; ?>;
			datas.view_handle_id = "<?php echo $view_handle_id; ?>";
			datas.view_handle_id = datas.view_handle_id.length == 0 ? null : datas.view_handle_id;
			oSlideshowJedoGallery.initThisJedoGallery(datas);
			jQuery.when(oSlideshowJedoGallery.initSlideshowJedoGallery()).done(function(){
				if(oSlideshowJedoGallery.datas.gallery.options.auto_slide == "Y") {

					if(0 < jQuery("#"+datas.div_gallery_id).parents(":hidden").length) {
						
					} else {
						oSlideshowJedoGallery.startAutoSliding();
					}
				}
			});
		} else {
			alert("datas.result:"+datas.message);
		}
	}).fail(function(jqXHR, textStatus){
		alert( "Request -- failed: " + textStatus );
	});
});
</script>
