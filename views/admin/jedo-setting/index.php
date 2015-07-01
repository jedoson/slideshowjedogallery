<?php


	$options = $this->oGallerySetting->select();

?>

<div class="container-fluid">
	<div class="page-header">
		<h1><?php _e('슬라이드쇼 제도 설정', $this -> textDomain); ?></h1>
	</div>
	<form class="form-horizontal" action="<?php echo $this->url; ?>&amp;method=save-setting" method="post" onSubmit="return checkSaveAllJedoSetting();">
		<div class="form-group">
			<label for="width" class="col-md-2 control-label"><?php _e('갤러리 폭', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<input type="text" class="form-control" name="gallery_width" value="<?php echo $options['gallery_width']; ?>"/>
			</div>
		</div>
		<div class="form-group">
			<label for="height" class="col-md-2 control-label"><?php _e('갤러리 높이', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<input type="text" class="form-control" name="gallery_height" value="<?php echo $options['gallery_height']; ?>"/>
			</div>
		</div>
		<div class="form-group">
			<label for="height" class="col-md-2 control-label"><?php _e('슬라이드쇼 효과', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<label>
					<input type="radio" name="slideshow_effect" value="fade" id="slideshow_effect_fade" <?php echo ($options['slideshow_effect'] == 'fade') ? 'checked' : ''; ?> /> 
					<?php _e('fade', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="slideshow_effect" value="slide" id="slideshow_effect_slide" <?php echo ($options['slideshow_effect'] == 'slide') ? 'checked' : ''; ?> /> 
					<?php _e('slide', $this -> textDomain); ?>
				</label>
			</div>
		</div>
		<div class="form-group">
			<label for="height" class="col-md-2 control-label"><?php _e('슬라이드 방양', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<label>
					<input type="radio" name="slide_direction" value="LR" id="slide_direction_LR" <?php echo ($options['slide_direction'] == 'LR') ? 'checked' : ''; ?> /> 
					<?php _e('왼쪽 -> 오른쪽', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="slide_direction" value="UD" id="slide_direction_UD" <?php echo ($options['slide_direction'] == 'UD') ? 'checked' : ''; ?> /> 
					<?php _e('위 -> 아래', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="slide_direction" value="RL" id="slide_direction_RL" <?php echo ($options['slide_direction'] == 'RL') ? 'checked' : ''; ?> /> 
					<?php _e('오른쪽 -> 왼쪽', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="slide_direction" value="DU" id="slide_direction_DU" <?php echo ($options['slide_direction'] == 'DU') ? 'checked' : ''; ?> /> 
					<?php _e('아래 -> 위', $this -> textDomain); ?>
				</label>
			</div>
		</div>
		<div class="form-group">
			<label for="height" class="col-md-2 control-label"><?php _e('자동 슬라이드', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<label>
					<input type="radio" name="auto_slide" value="Y" id="auto_slide_Y" <?php echo ($options['auto_slide'] == 'Y') ? 'checked' : ''; ?> /> 
					<?php _e('YES', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="auto_slide" value="N" id="auto_slide_N" <?php echo ($options['auto_slide'] == 'N') ? 'checked' : ''; ?> /> 
					<?php _e('NO', $this -> textDomain); ?>
				</label>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					if(jQuery("input[name='auto_slide']:checked").length == 0) {

						jQuery("input[name='auto_slide'][value='Y']").attr("checked", "checked");
					}
				});
			</script>
		</div>
		<div class="form-group">
			<label for="height" class="col-md-2 control-label"><?php _e('Easing', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<select name="easing"></select>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					var jSelectEasing = jQuery("select[name='easing']");
					jQuery.each( jQuery.easing, function( name, impl ) {
						jQuery("<option>").val(name).text(name).appendTo(jSelectEasing);
					});
					jQuery("select[name='easing'] option[value='<?php echo $options['easing']; ?>']").attr("selected", "selected");
				});
			</script>
		</div>
		<div class="form-group">
			<label for="height" class="col-md-2 control-label"><?php _e('슬라이드 속도', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<input type="hidden" class="form-control" name="slide_speed" value="<?php echo $options['slide_speed']; ?>"/>
				<div id="speed-silide"></div>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery( "#speed-silide" ).slider({
				        range: "min",
				        min: 1000,
				        max: 5000,
				        value: <?php echo empty($options['slide_speed']) ? '2000' : $options['slide_speed']; ?>,
				        slide: function( event, ui ) {
				        	jQuery( "input[name='slide_speed']" ).val( ui.value );
				        }
				      });
				});
			</script>
		</div>
		<div class="form-group">
			<label for="height" class="col-md-2 control-label"><?php _e('슬라이드 전환 버튼보기', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<label>
					<input type="radio" name="show_nav_button" value="Y" <?php echo ($options['show_nav_button'] == 'Y') ? 'checked' : ''; ?> /> 
					<?php _e('YES', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="show_nav_button" value="N" <?php echo ($options['show_nav_button'] == 'N') ? 'checked' : ''; ?> /> 
					<?php _e('NO', $this -> textDomain); ?>
				</label>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					if(jQuery("input[name='show_nav_button']:checked").length == 0) {

						jQuery("input[name='show_nav_button'][value='Y']").attr("checked", "checked");
					}
				});
			</script>
		</div>
		<div class="form-group">
			<label for="height" class="col-md-2 control-label"><?php _e('슬라이드 정보보기', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<label>
					<input type="radio" name="show_info" value="Y" <?php echo ($options['show_info'] == 'Y') ? 'checked' : ''; ?> /> 
					<?php _e('YES', $this -> textDomain); ?>
				</label> &nbsp; &nbsp;
				<label>
					<input type="radio" name="show_info" value="N" <?php echo ($options['show_info'] == 'N') ? 'checked' : ''; ?> /> 
					<?php _e('NO', $this -> textDomain); ?>
				</label>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					if(jQuery("input[name='show_info']:checked").length == 0) {

						jQuery("input[name='show_info'][value='Y']").attr("checked", "checked");
					}
				});
			</script>
		</div>
		<div class="form-group">
			<label for="opacity" class="col-md-2 control-label"><?php _e('투명도', $this -> textDomain); ?></label>
			<div class="col-md-10">
				<input type="text" name="slide_opacity" value="<?php echo empty($options['slide_opacity']) ? '70' : $options['slide_opacity']; ?>"/>
				<div id="opacity-silide"></div>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery( "#opacity-silide" ).slider({
				        range: "min",
				        min: 1,
				        max: 100,
				        value: <?php echo empty($options['slide_opacity']) ? '70' : $options['slide_opacity']; ?>,
				        slide: function( event, ui ) {
				        	jQuery( "input[name='slide_opacity']" ).val( ui.value );
				        }
				      });
				});
			</script>
		</div>
		<div class="form-group">
			<div class="col-md-offset-2 col-md-10">
				<button type="submit" class="btn btn-primary"><?php _e('슬라이드쇼 제도 설정', $this -> textDomain); ?></button>
			</div>
		</div>
	</form>
	<script type="text/javascript">
		function checkSaveAllJedoSetting() {
			
			if(jQuery("input[name='gallery_width']").val() == "") {
				alert("<?php _e('갤러리 폭을 입력하세요!', $this -> textDomain); ?>");
				return false;
			}

			if(jQuery("input[name='gallery_height']").val() == "") {
				alert("<?php _e('갤러리 높이을 입력하세요!', $this -> textDomain); ?>");
				return false;
			}
			
			return confirm("<?php _e('슬라이드쇼 제도 설정을 저장 합니다 ?', $this -> textDomain); ?>");
		}
	</script>
</div>



