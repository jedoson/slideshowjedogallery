<?php
	if(!empty($_REQUEST['gallery_id'])) {
		$gallery_id = $_REQUEST['gallery_id'];
	}
	
	if(!empty($_REQUEST['orderby'])) {
		$orderby = $_REQUEST['orderby'];
	} else {
		$orderby = "order";
	}
	if(!empty($_REQUEST['order'])) {
		$order = $_REQUEST['order'];
	} else {
		$order = "asc";
	}
	if(isset($gallery_id)) {
		
		$galleris = $this->oGalleryDBHelper->select(array('id'=>$gallery_id));
		if(0 == count($galleris)) {
			wp_die("Jedo Gallery Not Found id[". $gallery_id . "]");
		}
		$gallery = $galleris[0];
		$datas = $this->oSlideDBHelper->selectGallerySlide($gallery_id,array($orderby=>$order));
		
		if(count($datas) <= 0) {
			
			
			echo "gallery_id:".$gallery_id;
			wp_die();
		}
		
	} else {
		
		$datas = $this->oSlideDBHelper->select(array(),array($orderby=>$order));
	}
?>
<div class="container-fluid">
	<div class="page-header">
		<h2><?php _e('슬라이드쇼 제도 슬라이드', $this -> textDomain); ?></h2>
	</div>
	<div class="row">
		<div class="col-md-12">
			<form class="form-horizontal" id="slide_index" action="<?php echo $this->url; ?>" method="post" onSubmit="return checkSaveAllJedoSlide();">
				<input type="hidden" name="method" value="<?php echo $_REQUEST['method']; ?>">
				<input type="hidden" name="slide_id" value="">
				<input type="hidden" name="orderby" value="<?php echo $orderby; ?>">
				<input type="hidden" name="order" value="<?php echo $order; ?>">
				<div class="tablenav">
					<div class="alignleft actions">
						<a class="button" href="<?php echo $this->url; ?>&amp;method=save-slide-form" target="_self">
							<?php _e('제도 슬라이드 추가', $this -> textDomain); ?>
						</a>
					</div>
					<div class="alignleft actions">
						<select name="action" class="action">
							<option value=""><?php _e('- 적용액션 -', $this -> textDomain); ?></option>
							<option value="delete"><?php _e('Delete', $this -> textDomain); ?></option>
						</select>
						<input type="submit" class="button" value="<?php _e('일괄적용', $this -> textDomain); ?>" name="execute" />
					</div>
					<div class="alignleft actions">
						<select name="gallery_id" class="action">
							<option value=""><?php _e('- 갤러리 슬라이드 보기 -', $this -> textDomain); ?></option>
							<?php $arGallery = $this->oGalleryDBHelper->select(); foreach ($arGallery as $gallery) { 
								$selected = ($gallery_id == $gallery->id) ? "selected" : ""; ?>
							<option value="<?php echo $gallery->id; ?>" <?php echo $selected; ?> > - <?php echo $gallery->title; ?> <?php _e(' 슬라이드 보기', $this -> textDomain); ?> - </option>
							<?php } ?>
						</select>
					</div>
				</div>
				<table class="table table-hover widefat">
					<thead>
						<tr>
							<th class="check-column"><input type="checkbox" name="checkboxall" id="checkboxall" value="checkboxall" /></th>
							<th class="column-id <?php echo ($orderby == "id") ? 'sorted ' . $order : 'sortable desc'; ?>" data-column="id">
								<a href="#">
									<span><?php _e('ID', $this -> textDomain); ?></span><span class="sorting-indicator"></span>
								</a>
							</th>
							<th class="column-image">
								<span><?php _e('Image', $this -> textDomain); ?></span>
							</th>
							<th class="column-title <?php echo ($orderby == "title") ? 'sorted ' . $order : 'sortable desc'; ?>" data-column="title">
								<a href="#">
									<span><?php _e('Title', $this -> textDomain); ?></span><span class="sorting-indicator"></span>
								</a>
							</th>
							<th><?php _e('Galleries', $this -> textDomain); ?></th>
							<th class="column-order <?php echo ($orderby == "order") ? 'sorted ' . $order : 'sortable desc'; ?>" data-column="order">
								<a href="#">
									<span><?php _e('Order', $this -> textDomain); ?></span><span class="sorting-indicator"></span>
								</a>
							</th>
							<th class="column-modified <?php echo ($orderby == "modified") ? 'sorted ' . $order : 'sortable desc'; ?>" data-column="modified">
								<a href="#">
									<span><?php _e('Date', $this -> textDomain); ?></span><span class="sorting-indicator"></span>
								</a>
							</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th class="check-column"><input type="checkbox" name="checkboxall" id="checkboxall" value="checkboxall" /></th>
							<th class="column-id <?php echo ($orderby == "id") ? 'sorted ' . $order : 'sortable desc'; ?>" data-column="id">
								<a href="#">
									<span><?php _e('ID', $this -> textDomain); ?></span><span class="sorting-indicator"></span>
								</a>
							</th>
							<th class="column-image">
								<span><?php _e('Image', $this -> textDomain); ?></span>
							</th>
							<th class="column-title <?php echo ($orderby == "title") ? 'sorted ' . $order : 'sortable desc'; ?>" data-column="title">
								<a href="#">
									<span><?php _e('Title', $this -> textDomain); ?></span><span class="sorting-indicator"></span>
								</a>
							</th>
							<th><?php _e('Galleries', $this -> textDomain); ?></th>
							<th class="column-order <?php echo ($orderby == "order") ? 'sorted ' . $order : 'sortable desc'; ?>" data-column="order">
								<a href="#">
									<span><?php _e('Order', $this -> textDomain); ?></span><span class="sorting-indicator"></span>
								</a>
							</th>
							<th class="column-modified <?php echo ($orderby == "modified") ? 'sorted ' . $order : 'sortable desc'; ?>" data-column="modified">
								<a href="#">
									<span><?php _e('Date', $this -> textDomain); ?></span><span class="sorting-indicator"></span>
								</a>
							</th>
						</tr>
					</tfoot>
					<tbody>
						<?php if(empty($datas) || count($datas) == 0) {?>
						<tr>
							<th colspan="8"><?php _e('데이터가 없습니다.', $this -> textDomain); ?></th>
						</tr>
						<?php } foreach ($datas as $data) { 
						
							$options = json_decode($data->options);
							
							$thumbnails_url = "";
							if($options->type == "media") {
								
								$thumbnails_url = wp_get_attachment_thumb_url($options->attachment_id);
							} else if($options->type == "file") {
								
								$thumbnails_url = SlideshowJedoGallery::thumbnails_slideshowjedogallery_url() . $options->image_name;
							} else {
								
								$thumbnails_url = $options->image_url;
							}
						?>
						<tr>
							<th class="check-column">
								<input type="checkbox" name="ckSlide[]" id="ck<?php echo $data->id; ?>" value="<?php echo $data->id; ?>" />
							</th>
							<td>
								<span><?php echo $data->id; ?></span>
							</td>
							<td>
								<img alt="" style="width:150px;height:150px;" src="<?php echo $thumbnails_url; ?>" onClick="clickViewImage(this);" />
							</td>
							<td>
								<a href="#" onclick="return viewSlide('<?php echo $data->id; ?>');" data-row="row-actions">
									<span><?php echo $data->title; ?></span>
								</a>
								<div class="row-actions">
									<span class="view">
                                		<a href="#" onclick="return viewSlide('<?php echo $data->id; ?>');">
                                			<?php _e('보기', $this -> textDomain); ?>
                                		</a>
                                	</span>
                                	<span class="view">
                                		<a href="#" onclick="return viewSlide('<?php echo $data->id; ?>');">
                                			<?php _e('수정', $this -> textDomain); ?>
                                		</a>
                                	</span>
                                	<span class="delete">
                                		<a href="#" onclick="return checkDeleteSlide('<?php echo $data->id; ?>');">
                                			<?php _e('삭제', $this -> textDomain); ?>
                                		</a>
                                	</span>
                                </div>
							</td>
							<td>
								<?php 
									$galleris = $this->oGallerySlideDBHelper->select(array("slide_id"=>$data->id));
									foreach ($galleris as $gallery) {
								?>
								<span><?php echo $gallery->gallery_title; ?></span><br/>
								<?php } ?>
							</td>
							<td>
								<span><?php echo $data->order; ?></span>
							</td>
							<td>
								<span><?php echo date("Y-m-d", strtotime($data->modified)); ?></span>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</form>
			<script type="text/javascript">
				function checkSaveAllJedoSlide() {
					console.log("checkSaveAllJedoSlide >>> ");
					if(jQuery("input[name='method']").val() == "save-slide-all") {
						if(jQuery("select[name='action']").val() == "") return false;
	
	
						if(jQuery("input[name='ckSlide[]']:checked").length < 1) {
							alert("<?php _e('선택한 제도 슬라이드가 없습니다.', $this -> textDomain); ?>");
							return false;
						}
						if( confirm("<?php _e('선택한 제도 슬라이드를 삭제합니다 ?', $this -> textDomain); ?>")) {

							return true;
						}
					} else {
						return true;
					}
					return false;
				}
				function viewSlide(slide_id) {
					jQuery("input[name='method']").val("save-slide-form");
					jQuery("input[name='slide_id']").val(slide_id);
					jQuery("#slide_index").submit();
					return false;
				}
				function checkDeleteSlide(slide_id) {
					if( confirm("<?php _e('선택한 제도 슬라이드를 삭제합니다 ?', $this -> textDomain); ?>")) {

						jQuery("input[name='method']").val("delete");
						jQuery("input[name='slide_id']").val(slide_id);
						jQuery("#slide_index").submit();
					} 
					return false;
				}
				function clickViewImage(img) {

					
					console.log("clickViewImage:"+img.src);
				}
				jQuery(document).ready(function() {

					console.log("gallery_id:"+jQuery("select[name='gallery_id']").val());

					var orderby = jQuery("input[name='orderby']").val();
					var order = jQuery("input[name='order']").val();
					jQuery("th[class*='column-'][data-column]>a").on("click",function(){
						var oParent = jQuery(this).parent();
						var column = oParent.attr("data-column");
						jQuery("input[name='orderby']").val(column);
						if(0 <= oParent.attr("class").indexOf("desc")) {
							jQuery("input[name='order']").val("asc");
						} else {
							jQuery("input[name='order']").val("desc");
						}
						jQuery("#slide_index").submit();
					});

					jQuery("select[name='gallery_id']").on('change', function(){

						console.log("gallery_id:"+jQuery(this).val());
						if(jQuery(this).val() == "") {

							jQuery("input[name='method']").val("save-slide-all");
						} else {
							jQuery("input[name='method']").val("select-gallery-slide");

							jQuery("#slide_index").submit();
						}
					});

					jQuery("a[data-row='row-actions']:parent").on("mouseover",function(){

						jQuery(this).children("div.row-actions").show();
					}).on("mouseout",function(){

						jQuery(this).children("div.row-actions").hide();
					});
				});
			</script>
		</div>
	</div>
</div>



