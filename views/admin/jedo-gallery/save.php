<?php
	global $wpdb;
	$wpdb -> show_errors(true);
	
	$datas = $this->oGalleryDBHelper->select(array('id'=>$_GET['id']));
	
	if(empty($datas)) {
		$page_title = __('제도 갤러리 추가', $this -> textDomain);
		
		$data->layout_width = "fluid";
		$data->order = $this->oGalleryDBHelper->new_order();
		$data->order = empty($data->order) ? 1 : $data->order;
	} else {
		$page_title = __('제도 갤러리 수정', $this -> textDomain);
		$data = $datas[0];
	}
?>
<div class="container-fluid">
	<div class="page-header">
		<h1><?php echo $page_title; ?></h1>
	</div>
	<div class="row">
		<div class="col-md-12">
			<button type="button" id="btnDispaly" class="btn btn-defualt"><?php _e('입력필드 숨기기', $this -> textDomain); ?></button>
			&nbsp;&nbsp;
			<button type="button" id="btnGoIndex" class="btn btn-defualt"><?php _e('갤러리 리스트 보기', $this -> textDomain); ?></button>
		</div>
	</div>
	<form class="form-horizontal" action="<?php echo $this->url; ?>&amp;method=save-gallery" method="post" onSubmit="return checkSaveJedoGallery();">
		<input type="hidden" name="id" value="<?php echo $data->id; ?>"/>
		<div class="form-group">
			<label for="title" class="col-md-2 control-label"><?php _e('갤러리 제목', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<input type="text" class="form-control" name="title" value="<?php echo $data->title; ?>" placeholder="<?php _e('갤러리 제목', $this -> textDomain); ?>"/>
			</div>
		</div>
		<div class="form-group">
			<label for="order" class="col-md-2 control-label"><?php _e('슬라이드 폭 유형', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<label>
					<input type="radio" name="layout_width" value="fix" id="layout_width_fix" <?php echo ($data->layout_width == 'fix') ? 'checked' : ''; ?> /> 
					<?php _e('고정폭', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="layout_width" value="fluid" id="layout_width_fluid" <?php echo ($data->layout_width == 'fluid') ? 'checked' : ''; ?> /> 
					<?php _e('유동폭', $this -> textDomain); ?>
				</label>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
					
					if(jQuery("input[name='layout_width']:checked").size() == 0) {

						jQuery("input[name='layout_width'][value='fix']").attr("checked", "checked");
						jQuery("#div_row_width,#div_row_height").show();
					} else {

						if(jQuery("input[name='layout_width']:checked").val() == "fix") {

							jQuery("#div_row_width,#div_row_height").show();
						} else {
							jQuery("#div_row_width,#div_row_height").hide();
						}
					}

					jQuery("input[name='layout_width']").on('click', function( event ){

						if(jQuery("input[name='layout_width']:checked").val() == "fix") {

							jQuery("#div_row_width,#div_row_height").show();
						} else {
							jQuery("#div_row_width,#div_row_height").hide();
						}
					});
					
				});
			</script>
		</div>
		<div class="form-group" id="div_row_width">
			<label for="width" class="col-md-2 control-label"><?php _e('갤러리 폭', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<input type="text" class="form-control" name="container_width" value="" placeholder="<?php _e('갤러리 폭', $this -> textDomain); ?>"/>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
					if(!options.container_width) options.container_width = 500;
					jQuery("input[name='container_width']").val(options.container_width);
				});
			</script>
		</div>
		<div class="form-group" id="div_row_height">
			<label for="height" class="col-md-2 control-label"><?php _e('갤러리 높이', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<input type="text" class="form-control" name="container_height" value="" placeholder="<?php _e('갤러리 높이', $this -> textDomain); ?>"/>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
					if(!options.container_height) options.container_height = 400;
					jQuery("input[name='container_height']").val(options.container_height);
				});
			</script>
		</div>
		<div class="form-group">
			<label for="order" class="col-md-2 control-label"><?php _e('갤러리 순서', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<input type="text" class="form-control" name="order" value="<?php echo $data->order; ?>" placeholder="<?php _e('갤러리 순서', $this -> textDomain); ?>"/>
			</div>
		</div>
		<div class="form-group">
			<label for="order" class="col-md-2 control-label"><?php _e('갤러리 백그라운드 컬러', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<div class="wp-picker-container">
					<a tabindex="0" id="gallery_bgcolor_button" class="wp-color-result" title="<?php _e('선택한 컬러', $this -> textDomain); ?>"></a>
					<span class="wp-picker-input-wrap">
						<input type="text" name="gallery_bgcolor" id="gallery_bgcolor" value="" class="wp-color-picker" style="display: none;" />
					</span>
				</div>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
					if(!options.gallery_bgcolor) {
						options.gallery_bgcolor = "#ffffff";
					}
					jQuery("#gallery_bgcolor_button").css({
						"background-color": options.gallery_bgcolor
					});
					jQuery("input[name='gallery_bgcolor']").val(options.gallery_bgcolor);
					
					jQuery('#gallery_bgcolor').iris({
						hide: true,
						change: function(event, ui) {
							jQuery('#gallery_bgcolor_button').css('background-color', ui.color.toString());
						}
					});
					jQuery('#gallery_bgcolor').click(function(event) {
						event.stopPropagation();
					});
					jQuery('#gallery_bgcolor_button').click(function(event) {							
						jQuery(this).attr('title', "<?php _e('현재 컬러', $this -> textDomain); ?>");
						jQuery('#gallery_bgcolor').iris('toggle').toggle();								
						event.stopPropagation();
					});
					jQuery('html').click(function() {
						jQuery('#gallery_bgcolor').iris('hide').hide();
						jQuery('#gallery_bgcolor_button').attr('title', "<?php _e('선택한 컬러', $this -> textDomain); ?>");
					});
				});
			</script>
		</div>
		<div class="form-group">
			<label for="order" class="col-md-2 control-label"><?php _e('슬라이드 효과', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<label>
					<input type="radio" name="slide_effect" value="blind" /> 
					<?php _e('blind', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="slide_effect" value="fold" /> 
					<?php _e('fold', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="slide_effect" value="scale" /> 
					<?php _e('scale', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="slide_effect" value="size" /> 
					<?php _e('size', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="slide_effect" value="slide" /> 
					<?php _e('slide', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<!-- 
				<label>
					<input type="radio" name="slide_effect" value="bounce" /> 
					<?php _e('bounce', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="slide_effect" value="clip" /> 
					<?php _e('clip', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="slide_effect" value="drop" /> 
					<?php _e('drop', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="slide_effect" value="explode" /> 
					<?php _e('explode', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="slide_effect" value="highlight" /> 
					<?php _e('highlight', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="slide_effect" value="puff" /> 
					<?php _e('puff', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="slide_effect" value="pulsate" /> 
					<?php _e('pulsate', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="slide_effect" value="shake" /> 
					<?php _e('shake', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				 -->
			</div>
			<script type="text/javascript">
				var mapSlideDirection = [];
				var slide_effect = null;
				var slide_direction = null;
				
				jQuery(document).ready(function() {
					var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
					slide_effect = options.slide_effect;
					slide_direction = options.slide_direction;
					

					
					jQuery('div.slide_direction').hide();

					if(slide_effect) {
						
						jQuery('input[name="slide_effect"][value="'+slide_effect+'"]').attr("checked","checked");
						jQuery('div.slide_direction[data-slide-effect~="'+slide_effect+'"]').show();

						if(slide_direction) {
							jQuery('div.slide_direction:visible input[name="slide_direction"][value="'+slide_direction+'"]').attr("checked", "checked");
							mapSlideDirection[slide_effect] = slide_direction;
						}
					} else {
						
						jQuery('input[name="slide_effect"][value="slide"]').attr("checked","checked");
						
						jQuery('div.slide_direction[data-slide-effect~="slide"]').show();
						jQuery('input[name="slide_direction"][value="LR"]').attr("checked", "checked");
						mapSlideDirection["slide"] = "LR";
					}
					jQuery('input[name="slide_effect"]').on("change", function(){

						var slide_effect = jQuery(this).val();
						var slide_direction = mapSlideDirection[slide_effect];
						jQuery('input[name="slide_direction"]:checked').attr("checked", "");
						if(slide_direction) {
							jQuery('input[name="slide_direction"][value="'+slide_direction+'"]').attr("checked", "checked");
						}
						jQuery('div.slide_direction').hide();
						jQuery('div.slide_direction[data-slide-effect~="'+slide_effect+'"]').show();
					});
					jQuery('input[name="slide_direction"]').on("change", function(){

						var slide_effect = jQuery('input[name="slide_effect"]:checked').val();
						mapSlideDirection[slide_effect] = jQuery(this).val();
					});
				});
			</script>
		</div>
		<div class="form-group slide_direction" data-slide-effect="blind slide">
			<label for="height" class="col-md-2 control-label"><?php _e('슬라이드 방양', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<label>
					<input type="radio" name="slide_direction" value="LR" /> <?php _e('왼쪽 -> 오른쪽', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="slide_direction" value="RL" /> <?php _e('오른쪽 -> 왼쪽', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="slide_direction" value="UD" /> <?php _e('위 -> 아래', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="slide_direction" value="DU" /> <?php _e('아래 -> 위', $this -> textDomain); ?>
				</label>
			</div>
		</div>
		<div class="form-group slide_direction" data-slide-effect="size">
			<label for="height" class="col-md-2 control-label"><?php _e('슬라이드 방양', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<label>
					<input type="radio" name="slide_direction" value="ULRD" /> <?php _e('위.왼쪽 -> 아래.오른쪽', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="slide_direction" value="URLD" /> <?php _e('위.오른쪽 -> 아래.왼쪽', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="slide_direction" value="DLRU" /> <?php _e('아래.왼쪽 -> 위.오른쪽', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="slide_direction" value="DRLU" /> <?php _e('아래.오른쪽 -> 위.왼쪽', $this -> textDomain); ?>
				</label>
			</div>
		</div>
		<div class="form-group slide_direction" data-slide-effect="fold">
			<label for="height" class="col-md-2 control-label"><?php _e('슬라이드 방양', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<label>
					<input type="radio" name="slide_direction" value="ULRD" /> <?php _e('위.왼쪽 -> 오른쪽 -> 아래', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="slide_direction" value="URLD" /> <?php _e('위.오른쪽 -> 왼쪽 -> 아래', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="slide_direction" value="DLRU" /> <?php _e('아래.왼쪽 -> 오른쪽 -> 위', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="slide_direction" value="DRLU" /> <?php _e('아래.오른쪽 -> 왼쪽 -> 위', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="slide_direction" value="LUDR" /> <?php _e('왼쪽.위 -> 아래 -> 오른쪽', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="slide_direction" value="LDUR" /> <?php _e('왼쪽.아래 -> 위 -> 오른쪽', $this -> textDomain); ?>
				</label>
				<label>
					<input type="radio" name="slide_direction" value="RUDL" /> <?php _e('오른쪽.위 -> 아래 -> 왼쪽', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="slide_direction" value="RDUL" /> <?php _e('오른쪽.아래 -> 위 -> 왼쪽', $this -> textDomain); ?>
				</label>
			</div>
		</div>
		<div class="form-group">
			<label for="height" class="col-md-2 control-label"><?php _e('자동 슬라이드', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<label>
					<input type="radio" name="auto_slide" value="Y"/><?php _e('YES', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="auto_slide" value="N"/><?php _e('NO', $this -> textDomain); ?>
				</label>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
					if(options.auto_slide) {
						jQuery("input[name='auto_slide'][value='"+options.auto_slide+"']").attr("checked", "checked");
					}
					
					if(jQuery("input[name='auto_slide']:checked").length == 0) {
						jQuery("input[name='auto_slide'][value='Y']").attr("checked", "checked");
					}
					if(jQuery("input[name='auto_slide']:checked").val() == "Y") {
						jQuery("#div_auto_slide_speed").show();
					} else {
						jQuery("#div_auto_slide_speed").hide();
					}
					jQuery("input[name='auto_slide']").on("change", function(){

						if(jQuery(this).val() == "Y") {

							jQuery("#div_auto_slide_speed").show();
						} else {
							jQuery("#div_auto_slide_speed").hide();
						}
					});
				});
			</script>
		</div>
		<div class="form-group" id="div_auto_slide_speed">
			<label for="auto_slide_speed" class="col-md-2 control-label"><?php _e('자동 슬라이드 속도', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<input type="hidden" class="form-control" name="auto_slide_speed" value=""/>
				<div id="auto_slide_speed"></div>
				<span class="howto" style="padding-top:5px;">
					<span id="auto_slide_speed_badge" class="badge"></span>
					<?php _e('자동 슬라이딩시 다음 슬라이딩 시작시점 까지의 시간.', $this -> textDomain); ?>
				</span>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
					console.log("options.auto_slide_speed:"+options.auto_slide_speed);
					if(typeof options.auto_slide_speed == "undefined") {
						options.auto_slide_speed = 15000;
					}

					jQuery("input[name='auto_slide_speed']").val(options.auto_slide_speed);
					jQuery("#auto_slide_speed_badge").text(options.auto_slide_speed);
					jQuery( "#auto_slide_speed" ).slider({
				        range: "min",
				        min: 1000,
				        max: 20000,
				        step: 1000,
				        value: options.auto_slide_speed,
				        slide: function( event, ui ) {
				        	jQuery( "input[name='auto_slide_speed']" ).val( ui.value );
				        	jQuery( "#auto_slide_speed_badge" ).text( ui.value );
				        }
				      });
				});
			</script>
		</div>
		<div class="form-group">
			<label for="height" class="col-md-2 control-label"><?php _e('Easing', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<select name="easing"></select>
				<div id="graphs"></div>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
					
					var jSelectEasing = jQuery("select[name='easing']");
					 var i = 0,
				      width = 250,
				      height = 250;
					
					jQuery.each( jQuery.easing, function( name, impl ) {
						jQuery("<option>").val(name).text(name).appendTo(jSelectEasing);

						var graph = jQuery( "<div>" ).addClass( "graph" ).appendTo( "#graphs" ),
				        text = jQuery( "<div>" ).text( ++i + ". " + name ).appendTo( graph ),
				        wrap = jQuery( "<div>" ).appendTo( graph ).css( 'overflow', 'hidden' ),
				        canvas = jQuery( "<canvas>" ).appendTo( wrap )[ 0 ];

						graph.attr("id", "graph_"+name);
						canvas.width = width;
						canvas.height = height;
						var drawHeight = height * 0.8,
							cradius = 10;
						ctx = canvas.getContext( "2d" );
						ctx.fillStyle = "black";
				 
						// draw background
						ctx.beginPath();
						ctx.moveTo( cradius, 0 );
						ctx.quadraticCurveTo( 0, 0, 0, cradius );
						ctx.lineTo( 0, height - cradius );
						ctx.quadraticCurveTo( 0, height, cradius, height );
						ctx.lineTo( width - cradius, height );
						ctx.quadraticCurveTo( width, height, width, height - cradius );
						ctx.lineTo( width, 0 );
						ctx.lineTo( cradius, 0 );
						ctx.fill();
				 
						// draw bottom line
						ctx.strokeStyle = "#555";
						ctx.beginPath();
						ctx.moveTo( width * 0.1, drawHeight + .5 );
						ctx.lineTo( width * 0.9, drawHeight + .5 );
						ctx.stroke();
				 
						// draw top line
				 		ctx.strokeStyle = "#555";
						ctx.beginPath();
						ctx.moveTo( width * 0.1, drawHeight * .3 - .5 );
						ctx.lineTo( width * 0.9, drawHeight * .3 - .5 );
						ctx.stroke();
				 
						// plot easing
						ctx.strokeStyle = "white";
						ctx.beginPath();
						ctx.lineWidth = 2;
						ctx.moveTo( width * 0.1, drawHeight );
						jQuery.each( new Array( width ), function( position ) {
				 			var state = position / width,
								val = impl( state, position, 0, 1, width );
							ctx.lineTo( position * 0.8 + width * 0.1,
										drawHeight - drawHeight * val * 0.7 );
						});
						ctx.stroke();
				 
						// animate on click
						graph.click(function() {
							wrap.animate( { height: "hide" }, 2000, name )
				  				.delay( 800 )
								.animate( { height: "show" }, 2000, name );
						});
						graph.width( width ).height( height + text.height() + 10 );

						graph.hide();
					});
					
					if(options.easing) {
						jQuery("select[name='easing'] option[value='"+options.easing+"']").attr("selected", "selected");

						jQuery("#graph_"+options.easing).show();
					} else {

						easing_name = jQuery("select[name='easing'] > option:first").val();
						console.log("easing_name:"+easing_name);
					}

					jQuery("select[name='easing']").on("change",function(){

						console.log("val:"+jQuery(this).val());

						jQuery(".graph").hide();
						jQuery("#graph_"+jQuery(this).val()).show();
					});
					
				});
			</script>
		</div>

		<div class="form-group">
			<label for="height" class="col-md-2 control-label"><?php _e('슬라이딩 속도', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<input type="hidden" class="form-control" name="slide_speed" value=""/>
				<div id="speed-silide"></div>
				<span class="howto" style="padding-top:5px;">
					<span id="slide_speed_badge" class="badge"></span>
					<?php _e('슬라이딩 시작 시점부터 슬라이딩이 끝나는 시점 까지의 시간.', $this -> textDomain); ?>
				</span>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
					if(typeof options.slide_speed == "undefined") {
						options.slide_speed = 2500;
					}
					jQuery("input[name='slide_speed']").val(options.slide_speed);
					jQuery("#slide_speed_badge").text(options.slide_speed);
					jQuery( "#speed-silide" ).slider({
				        range: "min",
				        min: 1000,
				        max: 5000,
				        step: 100,
				        value: options.slide_speed,
				        slide: function( event, ui ) {
				        	jQuery( "input[name='slide_speed']" ).val( ui.value );
				        	jQuery( "#slide_speed_badge" ).text( ui.value );
				        }
				      });
				});
			</script>
		</div>
		<div class="form-group">
			<label for="height" class="col-md-2 control-label"><?php _e('슬라이드 전환 버튼보기', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<label>
					<input type="radio" name="show_nav_button" value="Y" /> <?php _e('YES', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="show_nav_button" value="N"/> <?php _e('NO', $this -> textDomain); ?>
				</label>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
					if(options.show_nav_button) {
						jQuery("input[name='show_nav_button'][value='"+options.show_nav_button+"']").attr("checked", "checked");
					}
				});
			</script>
		</div>
		<div class="form-group">
			<label for="height" class="col-md-2 control-label"><?php _e('슬라이드 정보보기', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<label>
					<input type="radio" name="show_info" value="Y" /><?php _e('YES', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="show_info" value="N" /><?php _e('NO', $this -> textDomain); ?>
				</label>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
					if(typeof options.show_info == 'undefined' || options.show_info == null) {
						options.show_info = "Y";
					}
					jQuery("input[name='show_info'][value='"+options.show_info+"']").attr("checked", "checked");
				});
			</script>
		</div>

		<div class="form-group">
			<label for="height" class="col-md-2 control-label"><?php _e('썸네일 보기', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<label>
					<input type="radio" name="show_thumbnails" value="Y" /> <?php _e('YES', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="show_thumbnails" value="N" /> <?php _e('NO', $this -> textDomain); ?>
				</label>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
					if(options.show_thumbnails) {
						jQuery("input[name='show_thumbnails'][value='"+options.show_thumbnails+"']").attr("checked", "checked");
					}
					
					jQuery("input[name='show_thumbnails']").on("change", function(){
						if(jQuery(this).val() == "Y") {
							jQuery(".thumbnails_row").show();
						} else {
							jQuery(".thumbnails_row").hide();
						}
					});
					var oShowThumbnails = jQuery("input[name='show_thumbnails']:checked");
					if(oShowThumbnails.length == 0 || oShowThumbnails.val() == "N") {

						jQuery("input[name='show_thumbnails'][value='N']").attr("checked","checked");
						jQuery(".thumbnails_row").hide();
					}
				});
			</script>
		</div>
		<div class="form-group thumbnails_row">
			<label for="height" class="col-md-2 control-label"><?php _e('썸네일 위치', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<label>
					<input type="radio" name="thumbnails_position" value="top"/><?php _e('TOP', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="thumbnails_position" value="bottom"/><?php _e('BOTTOM', $this -> textDomain); ?>
				</label>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
					if(options.thumbnails_position) {
						jQuery("input[name='thumbnails_position'][value='"+options.thumbnails_position+"']").attr("checked", "checked");
					}
					if(jQuery("input[name='thumbnails_position']:checked").length == 0) {
						jQuery("input[name='thumbnails_position'][value='bottom']").attr("checked","checked");
					}
				});
			</script>
		</div>
		<div class="form-group thumbnails_row">
			<label for="width" class="col-md-2 control-label"><?php _e('썸네일 폭', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<input type="hidden" class="form-control" name="thumbnails_width" value="" />
				<div id="thumbnails_width"></div>
				<span class="howto" style="padding-top:5px;">
					<span id="thumbnails_width_badge" class="badge"></span>
					<?php _e('슬라이드 썸네일 폭.', $this -> textDomain); ?>
				</span>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
					if(!options.thumbnails_width) {
						options.thumbnails_width = 100;
					}
					jQuery("input[name='thumbnails_width']").val(options.thumbnails_width);
					jQuery("#thumbnails_width_badge").text(options.thumbnails_width);
					jQuery( "#thumbnails_width" ).slider({
				        range: "min",
				        min: 50,
				        max: 200,
				        step: 10,
				        value: options.thumbnails_width,
				        slide: function( event, ui ) {
				        	jQuery( "input[name='thumbnails_width']" ).val( ui.value );
				        	jQuery( "#thumbnails_width_badge" ).text( ui.value );
				        }
				      });
				});
			</script>
		</div>
		<div class="form-group thumbnails_row">
			<label for="height" class="col-md-2 control-label"><?php _e('썸네일 높이', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<input type="hidden" class="form-control" name="thumbnails_height" value="" />
				<div id="thumbnails_height"></div>
				<span class="howto" style="padding-top:5px;">
					<span id="thumbnails_height_badge" class="badge"></span>
					<?php _e('슬라이드 썸네일 높이.', $this -> textDomain); ?>
				</span>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
					if(!options.thumbnails_height) {
						options.thumbnails_height = 75;
					}
					jQuery("input[name='thumbnails_height']").val(options.thumbnails_height);
					jQuery("#thumbnails_height_badge").text(options.thumbnails_height);
					jQuery( "#thumbnails_height" ).slider({
				        range: "min",
				        min: 50,
				        max: 200,
				        step: 10,
				        value: options.thumbnails_height,
				        slide: function( event, ui ) {
				        	jQuery( "input[name='thumbnails_height']" ).val( ui.value );
				        	jQuery( "#thumbnails_height_badge" ).text( ui.value );
				        }
				      });
				});
			</script>
		</div>
		<div class="form-group thumbnails_row">
			<label for="opacity" class="col-md-2 control-label"><?php _e('썸네일 투명도', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<input type="hidden" name="thumbnails_opacity" value=""/>
				<div id="thumbnails_opacity_silide"></div>
				<span class="howto" style="padding-top: 5px;">
					<span id="thumbnails_opacity_silide_badge" class="badge"></span>
					<?php _e('보여지는 갤러리 슬라이드 이미지의 투명도.', $this -> textDomain); ?>
				</span>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
					if(options.thumbnails_opacity) {
						jQuery("input[name='thumbnails_opacity']").val(options.thumbnails_opacity);
						jQuery("#thumbnails_opacity_silide_badge").text(options.thumbnails_opacity);
					}  else {
						options.thumbnails_opacity = 70;
					}
					
					jQuery( "#thumbnails_opacity_silide" ).slider({
				        range: "min",
				        min: 1,
				        max: 100,
				        value: options.thumbnails_opacity,
				        slide: function( event, ui ) {
				        	jQuery( "input[name='thumbnails_opacity']" ).val( ui.value );
				        	jQuery("#thumbnails_opacity_silide_badge").text(ui.value);
				        }
				      });
				});
			</script>
		</div>
		<div class="form-group thumbnails_row">
			<label for="order" class="col-md-2 control-label"><?php _e('썸네일 컬러', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<div class="wp-picker-container">
					<a tabindex="0" id="thumbnails_color_button" class="wp-color-result" title="<?php _e('선택한 컬러', $this -> textDomain); ?>"></a>
					<span class="wp-picker-input-wrap">
						<input type="text" name="thumbnails_color" id="thumbnails_color" value="" class="wp-color-picker" style="display: none;" />
					</span>
				</div>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
					if(typeof options.thumbnails_color == "undefined") {

						options.thumbnails_color = "#000000";
					}
					
					jQuery("input[name='thumbnails_color']").val(options.thumbnails_color);
					jQuery("#thumbnails_color_button").css({
						"background-color": options.thumbnails_color
					});
					jQuery('#thumbnails_color').iris({
						hide: true,
						change: function(event, ui) {
							jQuery('#thumbnails_color_button').css('background-color', ui.color.toString());
						}
					});
					jQuery('#thumbnails_color').click(function(event) {
						event.stopPropagation();
					});
					jQuery('#thumbnails_color_button').click(function(event) {							
						jQuery(this).attr('title', "<?php _e('현재 컬러', $this -> textDomain); ?>");
						jQuery('#thumbnails_color').iris('toggle').toggle();								
						event.stopPropagation();
					});
					jQuery('html').click(function() {
						jQuery('#thumbnails_color').iris('hide').hide();
						jQuery('#thumbnails_color_button').attr('title', "<?php _e('선택한 컬러', $this -> textDomain); ?>");
					});
				});
			</script>
		</div>
		<div class="form-group thumbnails_row">
			<label for="order" class="col-md-2 control-label"><?php _e('썸네일 활성화 컬러', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<div class="wp-picker-container">
					<a tabindex="0" id="thumbnails_active_color_button" class="wp-color-result" title="<?php _e('선택한 컬러', $this -> textDomain); ?>"></a>
					<span class="wp-picker-input-wrap">
						<input type="text" name="thumbnails_active_color" id="thumbnails_active_color" value="" class="wp-color-picker" style="display: none;" />
					</span>
				</div>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
					if(typeof options.thumbnails_active_color == "undefined") {
						options.thumbnails_active_color = "yellow";
					}
					jQuery("input[name='thumbnails_active_color']").val(options.thumbnails_active_color);
					jQuery("#thumbnails_active_color_button").css({
						"background-color": options.thumbnails_active_color
					});
					jQuery('#thumbnails_active_color').iris({
						hide: true,
						change: function(event, ui) {
							jQuery('#thumbnails_active_color_button').css('background-color', ui.color.toString());
						}
					});
					jQuery('#thumbnails_active_color').click(function(event) {
						event.stopPropagation();
					});
					jQuery('#thumbnails_active_color_button').click(function(event) {							
						jQuery(this).attr('title', "<?php _e('현재 컬러', $this -> textDomain); ?>");
						jQuery('#thumbnails_active_color').iris('toggle').toggle();								
						event.stopPropagation();
					});
					jQuery('html').click(function() {
						jQuery('#thumbnails_active_color').iris('hide').hide();
						jQuery('#thumbnails_active_color_button').attr('title', "<?php _e('선택한 컬러', $this -> textDomain); ?>");
					});
				});
			</script>
		</div>
		<div class="form-group thumbnails_row">
			<label for="thumbnails_scroll_speed" class="col-md-2 control-label"><?php _e('썸네일 스크롤 스피드', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<input type="hidden" name="thumbnails_scroll_speed" value=""/>
				<div id="thumbnails_scroll_speed_silide"></div>
				<span class="howto" style="padding-top: 5px;">
					<span id="thumbnails_scroll_speed_badge" class="badge"></span>
					<?php _e('썸테일 좌우측 버튼을 틀릭시 썸네일 포커스 이동 속도', $this -> textDomain); ?>
				</span>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
					if(!options.thumbnails_scroll_speed) {
						options.thumbnails_scroll_speed = 5;
					}
					jQuery("input[name='thumbnails_scroll_speed']").val(options.thumbnails_scroll_speed);
					jQuery("#thumbnails_scroll_speed_badge").text(options.thumbnails_scroll_speed);
					jQuery( "#thumbnails_scroll_speed_silide" ).slider({
				        range: "min",
				        min: 1,
				        max: 20,
				        value: options.thumbnails_scroll_speed,
				        slide: function( event, ui ) {
				        	jQuery( "input[name='thumbnails_scroll_speed']" ).val( ui.value );
				        	jQuery("#thumbnails_scroll_speed_badge").text(ui.value);
				        }
				      });
				});
			</script>
		</div>
		<div class="form-group thumbnails_row">
			<label for="thumbnails_spacing" class="col-md-2 control-label"><?php _e('썸네일 간격', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<input type="hidden" name="thumbnails_spacing" value=""/>
				<div id="thumbnails_spacing"></div>
				<span class="howto" style="padding-top: 5px;">
					<span id="thumbnails_spacing_badge" class="badge"></span>
					<?php _e('슬라이드 썸네일 간의 간격', $this -> textDomain); ?>
				</span>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					var options = options || jQuery.parseJSON(jQuery("textarea[name='options']").val().replace(/\\"/g, '"')) || {};
					if(!options.thumbnails_spacing) {
						options.thumbnails_spacing = 5;
					}
					jQuery("input[name='thumbnails_spacing']").val(options.thumbnails_spacing);
					jQuery("#thumbnails_spacing_badge").text(options.thumbnails_spacing);
					
					jQuery( "#thumbnails_spacing" ).slider({
				        range: "min",
				        min: 0,
				        max: 20,
				        value: options.thumbnails_spacing,
				        slide: function( event, ui ) {
				        	jQuery( "input[name='thumbnails_spacing']" ).val( ui.value );
				        	jQuery("#thumbnails_spacing_badge").text(ui.value);
				        }
				      });
				});
			</script>
		</div>
		<div class="form-group">
			<label for="title" class="col-md-2 control-label"><?php _e('OPTIONS', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<textarea class="form-control" name="options"><?php echo $data->options; ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-offset-2 col-md-10">
				<button type="submit" class="btn btn-primary"><?php echo $page_title; ?></button>
				&nbsp; 
			</div>
		</div>
	</form>
	<script type="text/javascript">
		function checkSaveJedoGallery() {

			try {
				if(jQuery("input[name='title']").val() == "") { 
					alert("<?php _e('갤러리 제목을 입력하세요.', $this -> textDomain); ?>");
					return false;
				}
				if(jQuery("input[name='layout_width']:checked").val() == "fix") { 
					if(jQuery("input[name='container_width']").val() == "") { 
						alert("<?php _e('갤러리 폭을 입력하세요.', $this -> textDomain); ?>");
						return false;
					}
					var width = parseInt(jQuery("input[name='container_width']").val());
					if(isNaN(width)) {
						alert("<?php _e('갤러리 폭은 숫자값을 입력하세요.', $this -> textDomain); ?>");
						return false;
					}
					if(jQuery("input[name='container_height']").val() == "") { 
						alert("<?php _e('갤러리 높이를 입력하세요.', $this -> textDomain); ?>");
						return false;
					}
					var height = parseInt(jQuery("input[name='container_height']").val());
					if(isNaN(height)) {
						alert("<?php _e('갤러리 높이는 숫자값을 입력하세요.', $this -> textDomain); ?>");
						return false;
					}
				}
				if(jQuery("input[name='order']").val() == "") { 
					alert("<?php _e('갤러리 순서를 입력하세요.', $this -> textDomain); ?>");
					return false;
				}
				var order = parseInt(jQuery("input[name='order']").val());
				if(isNaN(order)) {
					alert("<?php _e('갤러리 순서는 숫자값을 입력하세요.', $this -> textDomain); ?>");
					return false;
				}
				if(jQuery("input[name='slide_effect']:checked").val() != "scale") {
					if(jQuery("div.slide_direction:visible input[name='slide_direction']:checked").length == 0) {
						alert("<?php _e('슬라이드 방향을 선택 하세요.', $this -> textDomain); ?>");
						return false;
					}
				}
				return true;
			} catch(e) {
				console.log(e.message);
				return false;
			}
		}
		jQuery("#btnDispaly").on("click", function(){

			jQuery(".form-horizontal").toggle();
		});
		jQuery("#btnGoIndex").on("click", function(){

			window.location.href = "<?php echo $this->url ?>";
		});
	</script>
	<div class="row">
		<div id="testgallery" class="col-md-offset-2 col-md-6" style="display:flex;flex-direction:row;justify-content:center;height:500px;">
			<?php 
				if(!empty($data->id)) {
					echo do_shortcode( '[slideshowjedogallery gallery_id=' . $data->id . ' design_mode=true]' );
				} 
			?>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				
				var oJQuerySlideJedoGallery = jQuery('#testgallery .slideshowjedogallery');
				if(typeof oJQuerySlideJedoGallery != "undefined") {
					var oSlideshowJedoGallery = oJQuerySlideJedoGallery.data("oSlideshowJedoGallery");
					console.log("s --- oSlideshowJedoGallery.initSlideshowJedoGallery");
					jQuery.when(oSlideshowJedoGallery.initSlideshowJedoGallery()).done(function(){
						console.log("done --- oSlideshowJedoGallery.initSlideshowJedoGallery");
						if(datas.design_mode) {
							oSlideshowJedoGallery.outterContainer.css({
								"z-index": 2
							});
						}
						console.log("datas.gallery.options.auto_slide:"+datas.gallery.options.auto_slide);
						if(datas.gallery.options.auto_slide == "Y") {
							oSlideshowJedoGallery.startAutoSliding();
						}
						console.log("datas.design_mode:"+datas.design_mode);
						if(datas.design_mode) oSlideshowJedoGallery.draggable();
					});
					console.log("e --- oSlideshowJedoGallery.initSlideshowJedoGallery");
				}
			});
		</script>
	</div>
</div>

