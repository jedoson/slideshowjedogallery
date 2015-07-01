<?php
	
	
	$datas = $this->oGalleryDBHelper->select();
	
	//echo $wpdb->num_queries;
	//echo $wpdb->num_rows;
	//echo $wpdb->last_result;
	//echo $wpdb->last_query;
	//echo $wpdb->col_info;
	//echo $this -> url;
?>
<div class="wrap">

	<div class="container-fluid">
		<div class="page-header">
			<h1><?php _e('슬라이드쇼 제도 갤러리', $this -> textDomain); ?></h1>
		</div>
		<div class="row">
			<div class="col-md-12">
				<form action="<?php echo $this->url; ?>&amp;method=save-gallery-all" method="post" onSubmit="return checkSaveAllJedoGallery();">
					<div class="tablenav">
						<div class="alignleft actions">
							<a class="button" href="<?php echo $this->url; ?>&amp;method=save-gallery-form" target="_self">
								<?php _e('제도 갤러리 추가', $this -> textDomain); ?>
							</a>
						</div>
						<div class="alignleft actions">
							<select name="action" class="action">
								<option value=""><?php _e('- Bulk Actions -', $this -> textDomain); ?></option>
								<option value="delete"><?php _e('삭제', $this -> textDomain); ?></option>
							</select>
							<input type="submit" class="button" value="<?php _e('일괄적용', $this -> textDomain); ?>" name="execute" />
						</div>
					</div>
					<table class="table table-striped table-hover widefat">
						<thead>
							<tr>
								<th class="check-column"><input type="checkbox" name="checkboxall" id="checkboxall" value="checkboxall" /></th>
								<th class="column-id">
									<span><?php _e('아이디', $this -> textDomain); ?></span>
									<span class="sorting-indicator"></span>
								</th>
								<th class="column-title">
									<span><?php _e('제목', $this -> textDomain); ?></span>
										<span class="sorting-indicator"></span>
								</th>
								<th class="column-title">
									<span><?php _e('슬라이드', $this -> textDomain); ?></span>
										<span class="sorting-indicator"></span>
								</th>
								<th class="column-title">
									<span><?php _e('숏코드', $this -> textDomain); ?></span>
										<span class="sorting-indicator"></span>
								</th>
								<th class="column-order">
									<span><?php _e('순서', $this -> textDomain); ?></span>
										<span class="sorting-indicator"></span>
								</th>
								<th class="column-modified">
									<span><?php _e('수정일', $this -> textDomain); ?></span>
										<span class="sorting-indicator"></span>
								</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th class="check-column"><input type="checkbox" name="checkboxall" id="checkboxall" value="checkboxall" /></th>
								<th class="column-id">
									<span><?php _e('아이디', $this -> textDomain); ?></span>
										<span class="sorting-indicator"></span>
								</th>
								<th class="column-title">
									<a href="#">
										<span><?php _e('제목', $this -> textDomain); ?></span>
										<span class="sorting-indicator"></span>
									</a>
								</th>
								<th class="column-title">
									<span><?php _e('슬라이드', $this -> textDomain); ?></span>
										<span class="sorting-indicator"></span>
								</th>
								<th class="column-title">
									<span><?php _e('숏코드', $this -> textDomain); ?></span>
										<span class="sorting-indicator"></span>
								</th>
								<th class="column-order">
									<a href="#">
										<span><?php _e('순서', $this -> textDomain); ?></span>
										<span class="sorting-indicator"></span>
									</a>
								</th>
								<th class="column-modified">
									<a href="#">
										<span><?php _e('수정일', $this -> textDomain); ?></span>
										<span class="sorting-indicator"></span>
									</a>
								</th>
							</tr>
						</tfoot>
						<tbody>
							<?php if(empty($datas) || count($datas) == 0) {?>
							<tr>
								<th colspan="5"><?php _e('데이터가 없습니다.', $this -> textDomain); ?></th>
							</tr>
							<?php } foreach ($datas as $data) { ?>
							<tr>
								<th class="check-column">
									<input type="checkbox" name="ckGallery[]" id="ck<?php echo $data->id; ?>" value="<?php echo $data->id; ?>" />
								</th>
								<td>
									<span><?php echo $data->id; ?></span>
								</td>
								<td>
									<a href="#">
										<span><?php echo $data->title; ?></span>
									</a>
									<div class="row-actions">
										<span class="view">
	                                		<a href="<?php echo $this->url ?>&amp;method=save-gallery-form&amp;id=<?php echo $data->id; ?>">
	                                			<?php _e('편집', $this -> textDomain); ?>
	                                		</a>
	                                	</span> | 
	                                	<span class="view">
	                                		<a href="<?php echo $this->url ?>&amp;method=select-gallery-slide&amp;gallery_id=<?php echo $data->id; ?>">
	                                			<?php _e('슬라이드 보기', $this -> textDomain); ?>
	                                		</a>
	                                	</span> | 
	                                	<span class="delete">
	                                		<a href="<?php echo $this->url ?>&amp;method=delete&amp;id=<?php echo $data->id; ?>" onclick="return checkDeleteGallery();">
	                                			<?php _e('삭제', $this -> textDomain); ?>
	                                		</a>
	                                	</span>
	                                </div>
								</td>
								<td>
									<span><?php echo $data->slide_count; ?></span>
								</td>
								<td>
									<span>[slideshowjedogallery id=<?php echo $data->id; ?>]</span>
								</td>
								<td>
									<a href="#">
										<span><?php echo $data->order; ?></span>
									</a>
								</td>
								<td>
									<a href="#">
										<span><?php echo date("Y-m-d", strtotime($data->modified)); ?></span>
									</a>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</form>
				<script type="text/javascript">
					function checkSaveAllJedoGallery() {
						
						if(jQuery("select[name='action']").val() == "") return false;


						if(jQuery("input[name='ckGallery[]']:checked").length < 1) {
							alert("<?php _e('선택한 제도 캘러리가 없습니다.', $this -> textDomain); ?>");
							return false;
						}
						return confirm("<?php _e('선택한 제도 캘러리를 삭제합니다 ?', $this -> textDomain); ?>");
					}

					function checkDeleteGallery() {


						return confirm("<?php _e('선택한 제도 캘러리를 삭제합니다 ?', $this -> textDomain); ?>");
					}
				</script>
			</div>
		</div>
		
		
	</div>
</div>