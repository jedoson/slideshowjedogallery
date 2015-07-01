<?php 
	global $wpdb;
	$wpdb -> show_errors();
	
	$gallery_id = $_REQUEST['gallery_id'];
	$datas = $this->oSlideDBHelper->select(array('id'=>$_REQUEST['slide_id']));
	
	if(empty($datas)) {
		$page_title = __('제도 슬라이드 추가', $this -> textDomain);
		
		$options = $this->oGallerySetting->select();
		$data->order = $this->oSlideDBHelper->new_order();
		$data->order = empty($data->order) ? 1 : $data->order;
		
	} else {
		$page_title = __('제도 슬라이드 수정', $this -> textDomain);
		
		$data = $datas[0];
	}
?>

	<div class="container-fluid">
		<div class="page-header">
			<h1><?php echo $page_title; ?> <?php echo $_REQUEST['slide_id']; ?></h1>
		</div>
		<form class="form-horizontal" action="<?php echo $this->url; ?>" method="post" enctype="multipart/form-data" onSubmit="return checkSaveJedoSlide();">
			<input type="hidden" name="method" value="save-slide" />
			<input type="hidden" name="id" value="<?php echo $data->id; ?>" />
			<input type="hidden" name="gallery_id" value="<?php echo $gallery_id; ?>" />
			<div class="form-group">
				<label for="title" class="col-md-2 control-label"><?php _e('제목', $this -> textDomain); ?></label>
				<div class="col-md-10">
					<input type="text" class="form-control" name="title" id="title" value="<?php echo $data->title; ?>" placeholder="<?php _e('제목', $this -> textDomain); ?>"/>
				</div>
			</div>
			<div class="form-group">
				<label for="description" class="col-md-2 control-label"><?php _e('설명글', $this -> textDomain); ?></label>
				<div class="col-md-10">
					<textarea type="text" class="form-control" name="description" id="description"><?php echo $data->description; ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="order" class="col-md-2 control-label"><?php _e('순서', $this -> textDomain); ?></label>
				<div class="col-md-10">
					<input type="text" class="form-control" name="order" value="<?php echo $data->order; ?>" placeholder="<?php _e('순서', $this -> textDomain); ?>"/>
				</div>
			</div>
			<div class="form-group">
				<label for="viewinfo" class="col-md-2 control-label"><?php _e('보기 옵션', $this -> textDomain); ?></label>
				<div class="col-md-10">
					<label>
						<input type="radio" name="viewinfo" value="both" /> <?php _e('제목, 설명글 보기', $this -> textDomain); ?>
					</label><br /> 
					<label>
						<input type="radio" name="viewinfo" value="title" /> <?php _e('제목', $this -> textDomain); ?>
					</label><br /> 
					<label>
						<input type="radio" name="viewinfo" value="description" /> <?php _e('설명글', $this -> textDomain); ?>
					</label><br /> 
					<label>
						<input type="radio" name="viewinfo" value="none"/> <?php _e('제목, 설명글 보지 않음', $this -> textDomain); ?>
					</label><br />
				</div>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
						//alert("options.viewinfo:"+options.viewinfo);
						if(typeof options.viewinfo == 'undifined' || options.viewinfo == null) {
							options.viewinfo = "both";
						}
						jQuery("input[name='viewinfo'][value='"+options.viewinfo+"']").attr("checked", "checked");
					});
				</script>
			</div>
			<div class="form-group">
				<label for="opacity_title" class="col-md-2 control-label"><?php _e('슬라이드 타이틀 투명도', $this -> textDomain); ?></label>
				<div class="col-md-10">
					<input type="hidden" name="opacity_title" value=""/>
					<div id="opacity_title"></div>
					<span class="howto" style="padding-top: 5px;">
						<span id="opacity_title_badge" class="badge"></span>
						<?php _e('슬라이드 타이틀 투명도.', $this -> textDomain); ?>
					</span>
				</div>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
						if(!options.opacity_title) {
							options.opacity_title = 10;
						}
						jQuery( "input[name='opacity_title']").val(options.opacity_title);
						jQuery( "#opacity_title_badge").text(options.opacity_title);
						jQuery( "#opacity_title" ).slider({
					        range: "min",
					        min: 1,
					        max: 100,
					        value: options.opacity_title,
					        slide: function( event, ui ) {
					        	jQuery( "input[name='opacity_title']").val( ui.value );
					        	jQuery( "#opacity_title_badge").text( ui.value );
					        }
					      });
					});
				</script>
			</div>
			<div class="form-group">
				<label for="opacity_description" class="col-md-2 control-label"><?php _e('슬라이드 설명글 투명도', $this -> textDomain); ?></label>
				<div class="col-md-10">
					<input type="hidden" name="opacity_description" value=""/>
					<div id="opacity_description"></div>
					<span class="howto" style="padding-top: 5px;">
						<span id="opacity_description_badge" class="badge"></span>
						<?php _e('슬라이드 설명글 투명도.', $this -> textDomain); ?>
					</span>
				</div>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
						if(!options.opacity_description) {
							options.opacity_description = 10;
						}
						jQuery( "input[name='opacity_description']" ).val(options.opacity_description);
			        	jQuery( "#opacity_description_badge").text(options.opacity_description);
						jQuery( "#opacity_description" ).slider({
					        range: "min",
					        min: 1,
					        max: 100,
					        value: options.opacity_description,
					        slide: function( event, ui ) {
					        	jQuery( "input[name='opacity_description']" ).val( ui.value );
					        	jQuery( "#opacity_description_badge").text( ui.value );
					        }
					      });
					});
				</script>
			</div>
			<div class="form-group">
				<label for="order" class="col-md-2 control-label"><?php _e('보기 백그라운드 컬러', $this -> textDomain); ?></label>
				<div class="col-md-10">
					<div class="wp-picker-container">
						<a tabindex="0" id="viewinfo_bgcolor_button" class="wp-color-result" title="<?php _e('선택한 컬러', $this -> textDomain); ?>"></a>
						<span class="wp-picker-input-wrap">
							<input type="text" name="viewinfo_bgcolor" id="viewinfo_bgcolor" value="" class="wp-color-picker" style="display: none;" />
						</span>
					</div>
				</div>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
						if(!options.viewinfo_bgcolor) {
							options.viewinfo_bgcolor = "#FFFFFF";
						}
						jQuery("input[name='viewinfo_bgcolor']").val(options.viewinfo_bgcolor);
						jQuery("#viewinfo_bgcolor_button").css({
							"background-color": options.viewinfo_bgcolor
						});
						jQuery('#viewinfo_bgcolor').iris({
							hide: true,
							change: function(event, ui) {
								jQuery('#viewinfo_bgcolor_button').css('background-color', ui.color.toString());
							}
						});
						jQuery('#viewinfo_bgcolor').click(function(event) {
							event.stopPropagation();
						});
						jQuery('#viewinfo_bgcolor_button').click(function(event) {							
							jQuery(this).attr('title', "<?php _e('현재 컬러', $this -> textDomain); ?>");
							jQuery('#viewinfo_bgcolor').iris('toggle').toggle();								
							event.stopPropagation();
						});
						jQuery('html').click(function() {
							jQuery('#viewinfo_bgcolor').iris('hide').hide();
							jQuery('#viewinfo_bgcolor_button').attr('title', "<?php _e('선택한 컬러', $this -> textDomain); ?>");
						});
					});
				</script>
			</div>
			<div class="form-group">
				<label for="order" class="col-md-2 control-label"><?php _e('보기 텍스터 컬러', $this -> textDomain); ?></label>
				<div class="col-md-10">
					<div class="wp-picker-container">
						<a tabindex="0" id="viewinfo_txtcolor_button" class="wp-color-result" title="<?php _e('선택한 컬러', $this -> textDomain); ?>"></a>
						<span class="wp-picker-input-wrap">
							<input type="text" name="viewinfo_txtcolor" id="viewinfo_txtcolor" value="" class="wp-color-picker" style="display: none;" />
						</span>
					</div>
				</div>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
						if(!options.viewinfo_txtcolor) {
							options.viewinfo_txtcolor = "#000000";
						}
						jQuery("input[name='viewinfo_txtcolor']").val(options.viewinfo_txtcolor);
						jQuery("#viewinfo_txtcolor_button").css({
							"background-color": options.viewinfo_txtcolor
						});
						jQuery('#viewinfo_txtcolor').iris({
							hide: true,
							change: function(event, ui) {
								jQuery('#viewinfo_txtcolor_button').css('background-color', ui.color.toString());
							}
						});
						jQuery('#viewinfo_txtcolor').click(function(event) {
							event.stopPropagation();
						});
						jQuery('#viewinfo_txtcolor_button').click(function(event) {							
							jQuery(this).attr('title', "<?php _e('현재 컬러', $this -> textDomain); ?>");
							jQuery('#viewinfo_txtcolor').iris('toggle').toggle();								
							event.stopPropagation();
						});
						jQuery('html').click(function() {
							jQuery('#viewinfo_txtcolor').iris('hide').hide();
							jQuery('#viewinfo_txtcolor_button').attr('title', "<?php _e('선택한 컬러', $this -> textDomain); ?>");
						});
					});
				</script>
			</div>
			<div class="form-group">
				<label for="galleris" class="col-md-2 control-label"><?php _e('갤러리', $this -> textDomain); ?></label>
				<div class="col-md-10" id="div_galleris">
					<label>
						<input type="checkbox" name="ckGalleris_all" value="all" id="ckGalleris_all" />
						<?php _e('전체 갤러리', $this -> textDomain); ?>
					</label><br />
					<?php 
						$arGallery = $this->oGalleryDBHelper->select(); foreach ($arGallery as $gallery) { 
							$checked = $this->oGallerySlideDBHelper->isGallerySlideIn($gallery->id, $data->id) ? "checked" : "";
					?>
					<label>
						<input type="checkbox" name="ckGallery[]" value="<?php echo $gallery->id; ?>" <?php echo $checked; ?> />
						<?php echo $gallery->title; ?>
					</label><br />
					<?php } ?>
				</div>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
						
						jQuery("#ckGalleris_all").on('change', function(){
							if(jQuery("input[name='ckGalleris_all']").attr('checked') == 'checked') {
								jQuery("input[name='ckGallery[]']").attr('checked', 'checked');
							} else {
								jQuery("input[name='ckGallery[]']").removeAttr('checked');
							}
						});
					});
				</script>
			</div>
			<div class="form-group">
				<label for="imagetype" class="col-md-2 control-label"><?php _e('이미지종류', $this -> textDomain); ?></label>
				<div class="col-md-10">
					<label>
						<input type="radio" name="type" value="media"/>	<?php _e('미디어 파일', $this -> textDomain); ?>
					</label> &nbsp;
					<label>
						<input type="radio" name="type" value="file" />	<?php _e('업로드 파일', $this -> textDomain); ?>
					</label> &nbsp;
					<label>
						<input type="radio" name="type" value="url" /> <?php _e('이미지 URL', $this -> textDomain); ?>
					</label>
				</div>
				<input type="hidden" name="image_name" value=""/> 
				<input type="hidden" name="image_url" value=""/> 
				<input type="hidden" name="attachment_id" value="" />
				<script type="text/javascript">
					jQuery(document).ready(function() {
						var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
						if(!options.type) {
							options.type = "media";
						} else {

							jQuery("input[name='image_name']").val(options.image_name);
							jQuery("input[name='image_url']").val(options.image_url);
							jQuery("input[name='attachment_id']").val(options.attachment_id);
						}

						jQuery("#type_div_"+options.type).show();
						jQuery("input[name='type'][value='"+options.type+"']").attr("checked","checked");
						
						if(jQuery("input[name='id']").val() != "") {
							
							jQuery("input[name='type']").attr("readonly", "readonly");
							jQuery("input[name='type']").on('click', function( event ){
								event.preventDefault();
							});
							jQuery("input[name='mediaupload']").attr("disabled", "disabled");
							jQuery("input[name='image_file']").attr("disabled", "disabled");
						} else {

							jQuery("input[name='type']").on('click', function( event ){

								jQuery("div[class='form-group'][id^='type_div']").hide();
								jQuery("#type_div_"+jQuery(this).val()).show();
							});
						}
						
					});
				</script>
			</div>
			<div id="type_div_media" class="form-group" style="display:none;">
				<label for="imagetype" class="col-md-2 control-label"><?php _e('미디어 선택', $this -> textDomain); ?></label>
				<div class="col-md-10">
					<img style="width:200px;height:200px;display:none;" src="#" id="media_image_file">
					<input type="button" name="mediaupload" value="<?php _e('미디어 선택', $this -> textDomain); ?>" id="mediaupload" class="button button-secondary" /> 
					<input type="text"   name="media_file" style="width: 50%;" id="media_file" value="" /> 
				</div>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
						if(options.image_url) {
							jQuery("#media_image_file").attr("src", options.image_url);
							jQuery("input[name='media_file']").val(options.image_url);
						}
						if(options.attachment_id) {
							jQuery("#attachment_id").val(options.attachment_id);
						}
						if(0 < jQuery("#media_image_file[src!='#']").size()) {

							jQuery("#media_image_file[src!='#']").show();
							jQuery("#mediaupload, #media_file").hide();
							
						}
						
						var file_frame;
						jQuery('#mediaupload').on('click', function( event ){
							event.preventDefault();

							//alert("If the media frame already exists, reopen it.");
							if (file_frame) {
								file_frame.open();
								return;
							}

							//alert(" Create the media frame.");
							file_frame = wp.media.frames.file_frame = wp.media({
								title: '<?php _e('Upload a slide', $this -> textDomain); ?>',
								button: {
									text: '<?php _e('Select as Slide Image', $this -> textDomain); ?>',
								},
								multiple: false  // Set to true to allow multiple files to be selected
							});

							//alert("  When an image is selected, run a callback.");
							file_frame.on( 'select', function() {
								// We set multiple to false so only get one image from the uploader
								attachment = file_frame.state().get('selection').first().toJSON();

								// Do something with attachment.id and/or attachment.url here

								jQuery('#attachment_id').val(attachment.id);
								jQuery('#media_file').val(attachment.url);
								jQuery('#media_image_file').attr("src", attachment.url).show();
								//jQuery('#Slide_mediaupload_image').html('<a href="' + attachment.url + '" class="colorbox" onclick="jQuery.colorbox({href:\'' + attachment.url + '\'}); return false;"><img class="slideshow_dropshadow" style="width:100px;" src="' + attachment.sizes.thumbnail.url + '" /></a>');
							});

							//alert("  Finally, open the modal");
							file_frame.open();
						});
					});
				</script>
			</div>
			<div id="type_div_file" class="form-group" style="display:none;">
				<label for="image_file" class="col-md-2 control-label"><?php _e('이미지 선택', $this -> textDomain); ?></label>
				<div class="col-md-10">
					<input type="file" name="image_file" value=""/>
					<img style="width:200px;height:200px;" src="#" id="upload_image_file">
					<span class="howto"><?php _e('로컬 파일 시스템에서 이미지 파일선택. JPG, PNG, GIF are supported.', $this -> textDomain); ?></span>
				</div>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
						if(options.type == "file") {
							jQuery("#upload_image_file").attr("src", options.image_url).show();
							jQuery("input[name='image_file']").hide();
						}
						jQuery("input[name='image_file']").on('change', function(){
							if (this.files && this.files[0]) {
								var reader = new FileReader();
						        reader.onload = function (e) {
						        	jQuery('#upload_image_file').attr('src', e.target.result);
						        }
						        reader.readAsDataURL(this.files[0]);
							}
						});
					});
				</script>
			</div>
			<div id="type_div_url" class="form-group" style="display:none;">
				<label for="image_url" class="col-md-2 control-label"><?php _e('이미지 URL', $this -> textDomain); ?></label>
				<div class="col-md-10">
					<input class="widefat" type="text" name="link_image_url" value=""/> 
					<span class="howto"><?php _e('이미지 URL 지정 eg. http://yourdomain.com/path/to/image.jpg', $this -> textDomain); ?></span>
				</div>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
						if(options.type == "url" && options.image_url) {
							jQuery("input[name='link_image_url']").val(options.image_url);
						}
					});
				</script>
			</div>
			<div class="form-group">
				<label for="opacity" class="col-md-2 control-label"><?php _e('투명도', $this -> textDomain); ?></label>
				<div class="col-md-10">
					<input type="hidden" name="opacity" value=""/>
					<div id="opacity-silide"></div>
					<span class="howto" style="padding-top: 5px;">
						<span id="opacity-silide_badge" class="badge"></span>
						<?php _e('보여지는 갤러리 슬라이드 이미지의 투명도.', $this -> textDomain); ?>
					</span>
				</div>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
						if(!options.opacity) {
							options.opacity = 90;
						}
						jQuery("input[name='opacity']").val(options.opacity);
						jQuery("#opacity-silide_badge").text(options.opacity);
						jQuery( "#opacity-silide" ).slider({
					        range: "min",
					        min: 10,
					        max: 100,
					        value: options.opacity,
					        slide: function( event, ui ) {
					        	jQuery( "input[name='opacity']" ).val( ui.value );
					        	jQuery("#opacity-silide_badge").text(ui.value);
					        }
					      });
					});
				</script>
			</div>
			<div class="form-group">
				<label for="imagetype" class="col-md-2 control-label"><?php _e('링크 사용', $this -> textDomain); ?></label>
				<div class="col-md-10">
					<label>
						<input type="radio" name="uselink" value="Y" /> <?php _e('Yes', $this -> textDomain); ?>
					</label> &nbsp; &nbsp;
					<label>
						<input type="radio" name="uselink" value="N" /> <?php _e('No', $this -> textDomain); ?>
					</label>
					<span class="howto">
						<?php _e('슬라이드 이미지 클릭시 보여줄 URL', $this -> textDomain); ?>
					</span>
				</div>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
						if(!options.uselink) {
							options.uselink = "N";
						}
						jQuery("input[name='uselink'][value='"+options.uselink+"']").attr("checked", "checked");
						if(options.uselink == "Y") {
							jQuery("#uselink_div_target, #uselink_div_url").show();
						}
						
						jQuery("input[name='uselink']").on('change', function(){

							if(jQuery(this).val() == "Y") {

								jQuery("#uselink_div_target, #uselink_div_url").show();
							} else {
								jQuery("#uselink_div_target, #uselink_div_url").hide();
							}
						});
					});
				</script>
			</div>
			<div id="uselink_div_target" class="form-group" style="display:none;">
				<label for="link_target" class="col-md-2 control-label"><?php _e('링크 target', $this -> textDomain); ?></label>
				<div class="col-md-10">
					<select name="link_target">
						<option value="_self">_self</option>
						<option value="_blank">_blank</option>
						<option value="_parent">_parent</option>
						<option value="frame">프레임명</option>
					</select>
				</div>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
						if(!options.link_target) {
							options.link_target = "_blank";
						}
						jQuery("input[name='link_target']").val(options.link_target);
						jQuery("select[name='link_target']").on('change', function(){
							
							if(jQuery(this).val() == "frame") {

								jQuery("#div_frame_name").show();
							} else {
								jQuery("#div_frame_name").hide();
							}
						});
					});
				</script>
			</div>
			<div id="div_frame_name" class="form-group" style="display:none;">
				<label for="frame_name" class="col-md-2 control-label"><?php _e('프레임명', $this -> textDomain); ?></label>
				<div class="col-md-10">
					<input type="text" class="form-control" name="frame_name" id="frame_name" value="<?php echo $data->frame_name; ?>" placeholder="<?php _e('프레임명', $this -> textDomain); ?>"/>
				</div>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
						
						jQuery("input[name='frame_name']").val(options.frame_name);
					});
				</script>
			</div>
			<div id="uselink_div_url" class="form-group" style="display:none;">
				<label for="link_url" class="col-md-2 control-label"><?php _e('링크 target', $this -> textDomain); ?></label>
				<div class="col-md-10">
					<input type="text" class="form-control" name="link_url" id="link_url" value="<?php echo $data->link_url; ?>" placeholder="<?php _e('링크 target', $this -> textDomain); ?>"/>
				</div>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
						
						jQuery("input[name='link_url']").val(options.link_url);
					});
				</script>
			</div>
			<div class="form-group" >
				<label for="title" class="col-md-2 control-label"><?php _e('OPTIONS', $this -> textDomain); ?></label>
				<div class="col-md-10">
					<textarea class="form-control" name="options"><?php echo $data->options; ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-10">
					<button type="submit" class="btn btn-primary"><?php echo $page_title; ?></button>
				</div>
			</div>
		</form>
		<script type="text/javascript">
			jQuery(document).ready(function() {
	
				//var oContainer = jQuery("div.container-fluid");
				//var oParent = oContainer.parent();
				//oParent.height(oContainer.height());
				console.log("gallery_id:"+jQuery("input[name='gallery_id']").val());
			});
			function checkSaveJedoSlide() {

				try {
					if(jQuery("#title").val() == "") { 
						alert("<?php _e('제목을 입력하세요', $this -> textDomain); ?>");
						return false;
					}
					if(jQuery("#description").val() == "") { 
						alert("<?php _e('설명글을 입력하세요', $this -> textDomain); ?>");
						return false;
					}
					if(jQuery("input[name='order']").val() == "") { 
						alert("<?php _e('순서을 입력하세요', $this -> textDomain); ?>");
						return false;
					}
					var order = parseInt(jQuery("input[name='order']").val());
					if(isNaN(order)) {
						alert("<?php _e('순서는 숫자값입니다.', $this -> textDomain); ?>");
						return false;
					}
					if(jQuery("#viewinfo").val() == "") { 
						alert("<?php _e('보기옵션을 선택하세요!', $this -> textDomain); ?>");
						return false;
					}
					//alert("type:"+jQuery("input[name='type']:checked").val());
					if(jQuery("input[name='type']:checked").val() == "") { 
						alert("<?php _e('이미지 종류를 선택하세요!', $this -> textDomain); ?>");
						return false;
					}
					
					if(jQuery("input[name='uselink']:checked").val() == "Y") {
						if(jQuery("select[name='link_target']").val() == "frame") {

							if(jQuery("select[name='frame_name']").val() == "") {
								alert("<?php _e('프레임명을 입력하세요!', $this -> textDomain); ?>");
								return false;
							}
						}
						if(jQuery("select[name='link_url']").val() == "") {
							alert("<?php _e('링크 URL을 입력하세요!', $this -> textDomain); ?>");
							return false;
						}
					}
						
					return true;
				} catch (e) {
					alert("e:"+e);
				}
				return false;	
			}
		</script>
	</div>