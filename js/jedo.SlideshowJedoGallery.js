
if(!self.hasOwnProperty("jedo")) {
	jedo = {};
}
if(!jedo.hasOwnProperty("SlideshowJedoGallery")) {
	jedo.SlideshowJedoGallery = function(slideshowContainer) {
		
		Object.defineProperty(this, "outterContainer", {
			enumerable: false,
			configurable: false,
			writable: false,
			value: jQuery("#outter_"+slideshowContainer.attr("id"))
		});
		
		Object.defineProperty(this, "slideshowContainer", {
			enumerable: false,
			configurable: false,
			writable: false,
			value: slideshowContainer
		});

		
		Object.defineProperty(this, "vidx", {
			enumerable: false,
			configurable: false,
			writable: true,
			value: 0
		});
		

		Object.defineProperty(this, "stopTransition", {
			enumerable: false,
			configurable: false,
			writable: true,
			value: false
		});
	
		Object.defineProperty(this, "nowTransition", {
			enumerable: false,
			configurable: false,
			writable: true,
			value: false
		});
		
		Object.defineProperty(this, "timeoutID", {
			enumerable: false,
			configurable: false,
			writable: true,
			value: null
		});
		
		var deferredThisJedoGallery = jQuery.Deferred();
		Object.defineProperty(this, "deferredThisJedoGallery", {
			enumerable: false,
			configurable: false,
			writable: false,
			value: deferredThisJedoGallery
		});
		
		Object.defineProperty(this, "promiseThisJedoGallery", {
			enumerable: false,
			configurable: false,
			writable: false,
			value: deferredThisJedoGallery.promise()
		});
		
		var deferredSlideshowJedoGallery = jQuery.Deferred();
		Object.defineProperty(this, "deferredSlideshowJedoGallery", {
			enumerable: false,
			configurable: false,
			writable: false,
			value: deferredSlideshowJedoGallery
		});
		
		Object.defineProperty(this, "promiseSlideshowJedoGallery", {
			enumerable: false,
			configurable: false,
			writable: false,
			value: deferredSlideshowJedoGallery.promise()
		});
		
		
		Object.defineProperty(this, "isInitSlideshowJedoGallery", {
			enumerable: false,
			configurable: false,
			writable: false,
			value: false
		});
	}
	
	Object.defineProperty(jedo.SlideshowJedoGallery, "ajaxGallerySlides", {
		get: function() {
			console.log("SlideshowJedoGalleryAjax.AJAX_URL:"+SlideshowJedoGalleryAjax.AJAX_URL);
			return function(gallery_id) {
				return jQuery.ajax({
					method: "POST",
					url: SlideshowJedoGalleryAjax.AJAX_URL,
					data: {
						action: "get_gallery_slides",
						m: "slides",
						gallery_id: gallery_id
			    	}});
			}
		},
		enumerable: false,
		configurable: false
	});
	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "initThisJedoGallery", {
		get: function() {
			var _oJedoSlideshow = this;
			
			return function(datas) {

				try {
					
					Object.defineProperty(_oJedoSlideshow, "datas", {
						enumerable: false,
						configurable: false,
						writable: false,
						value: datas
					});
					
					Object.defineProperty(_oJedoSlideshow, "vndx", {
						enumerable: false,
						configurable: false,
						writable: true,
						value: 1 < datas.slides.length ? 1 : 0
					});
					Object.defineProperty(_oJedoSlideshow, "vedx", {
						enumerable: false,
						configurable: false,
						writable: false,
						value: datas.slides.length - 1
					});
					Object.defineProperty(_oJedoSlideshow, "vpdx", {
						enumerable: false,
						configurable: false,
						writable: true,
						value: datas.slides.length - 1
					});
					
					jQuery.when(_oJedoSlideshow.initLoadSlideImage()).done(function(){
						_oJedoSlideshow.deferredThisJedoGallery.resolve();
					});
				} finally {
					return _oJedoSlideshow.promiseThisJedoGallery;
				}
			}
		},
		enumerable: false,
		configurable: false
	});
	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "draggable", {
		get: function() {
			var _oJedoSlideshow = this;
			var _datas = _oJedoSlideshow.datas;
			var _oOutterContainer = _oJedoSlideshow.outterContainer;
			var _oSlideshowContainer = _oJedoSlideshow.slideshowContainer;
			var _sThisId = _oSlideshowContainer.attr("id");
			var _outterID = "outter_"+_sThisId;
			return function() {
				//alert("_options.design_mode:"+_options.design_mode);
				if(_datas.design_mode) {
					/*
					_oOutterContainer.css({
						"padding-top": "50px",
				    	"padding-bottom": "20px",
				    	"padding-right": "20px",
				    	"padding-left": "20px"
					});
					_oOutterContainer.draggable();
					_oOutterContainer.resizable();
					*/
					_oOutterContainer.draggable();
				}
			}
		},
		enumerable: false,
		configurable: false
	});

	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "initSlideshowJedoGallery", {
		get: function() {
			var _oJedoSlideshow = this;

			var _oOutterContainer = _oJedoSlideshow.outterContainer;
			var _oSlideshowContainer = _oJedoSlideshow.slideshowContainer;
			
			return function () {
				
				try {
					jQuery.when(_oJedoSlideshow.promiseThisJedoGallery).done(function(){
						
						_oOutterContainer.css("background-color", _oJedoSlideshow.datas.gallery.options.gallery_bgcolor );
						
						jQuery.when(_oJedoSlideshow.initLayoutWidth()).done(function(){
							
							jQuery.when(
								_oJedoSlideshow.initShowNavButton(),
								_oJedoSlideshow.initShowInfo(),
								_oJedoSlideshow.initThumbnail()).done(function(){
							
								_oJedoSlideshow.initSlideImage();
								
								_oJedoSlideshow.deferredSlideshowJedoGallery.resolve();
								_oJedoSlideshow.isInitSlideshowJedoGallery = true;
								
								if(_oJedoSlideshow.datas.design_mode) {
									_oSlideshowContainer.css({
										overflow: "visible"
									});
								}
							});
						});
					});
				} finally {
					return _oJedoSlideshow.promiseSlideshowJedoGallery;
				}
			}
		},
		enumerable: false,
		configurable: false
	});
	
	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "initLoadSlideImage", {
		get: function() {
			var _oJedoSlideshow = this;
			var _datas = _oJedoSlideshow.datas;
			
			return function () {
				console.log("s --- initLoadSlideImage");
				var deferred = jQuery.Deferred();
				try {
					var _arrPromise = [];
					//console.log("_datas.slides.length:"+_datas.slides.length);
					for(var i = 0; i < _datas.slides.length; i++) {
						_datas.slides[i].slide_id = _datas.div_gallery_id+"_"+_datas.slides[i].id;
						//console.log("slide_id["+i+"]:"+_datas.slides[i].slide_id);
						
						var slideImage = new Image();
						slideImage.deferred = jQuery.Deferred();
						slideImage.idx = i;
						_arrPromise[i] = slideImage.deferred.promise();
						slideImage.onload = function() {
							//console.log("idx:"+this.idx);
							try {
								this.deferred.resolve();
							} catch(e) {
								console.log("initLoadSlideImage >> slideImage load error["+e.name+"]:"+e.message);
							}
					    };
					    slideImage.src = _datas.slides[i].options.image_url;
					    _datas.slides[i].image = slideImage;
					}
					jQuery.when.apply(_arrPromise).done(function(){
						deferred.resolve();
					});
					
				} finally {
					return deferred.promise();
				}
			}
		},
		enumerable: false,
		configurable: false
	});	
	
	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "initLayoutWidth", {
		get: function() {
			var _oJedoSlideshow = this;
			var _datas = _oJedoSlideshow.datas;
			
			var _oOutterContainer = _oJedoSlideshow.outterContainer;
			var _oSlideshowContainer = _oJedoSlideshow.slideshowContainer;
			
			return function () {
	
				var deferred = jQuery.Deferred();
				try {
					if(_datas.gallery.layout_width == "fix") {
						_oSlideshowContainer.css({
							"width": _datas.gallery.options.container_width, 
							"height": _datas.gallery.options.container_height
						});
					} else {
						
						var right_width = 100;
						var right_height = 100;
						if(typeof _datas.view_handle_id == "undefined" || 
							_datas.view_handle_id == null || 
							_datas.view_handle_id.trim().length == 0 ||
							jQuery("#"+_datas.view_handle_id).length == 0) {
							
							var oParent = _oOutterContainer.parent();
							var parent_width = parseInt(oParent.width(),10);
							var parent_height = parseInt(oParent.height(),10);
							
							right_width = parent_width;
							right_height = parent_height;
							if((parent_width / 5) * 3 < parent_height) {
								right_height = (parent_width / 5) * 3;
							}
						} else {
							
							var oViewHandle = jQuery("#"+_datas.view_handle_id);
							
							right_width = parseInt(oViewHandle.width(),10);
							right_height = parseInt((right_width / 5) * 3,10);
						}
						
						
						_oOutterContainer.outerWidth(right_width);
						_oOutterContainer.outerHeight(right_height);
						
						_oSlideshowContainer.width(right_width);
						_oSlideshowContainer.height(right_height);
						
						if(_datas.design_mode) {
							
							_oOutterContainer.draggable();
						}
					}
					
					deferred.resolve();
				} finally {
					return deferred.promise();
				}
			}
		},
		enumerable: false,
		configurable: false
	});	
	
	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "initShowNavButton", {
		get: function() {
			var _oJedoSlideshow = this;
			var _datas = _oJedoSlideshow.datas;
			
			var _oSlideshowContainer = _oJedoSlideshow.slideshowContainer;
			var _width = _oSlideshowContainer.outerWidth();
			var _height = _oSlideshowContainer.outerHeight();
			
			var _sThisId = _oSlideshowContainer.attr("id");
			var _lbtnID = _sThisId + "_leftButton";
			var _rbtnID = _sThisId + "_rightButton";

			var _show_nav_button = _datas.gallery.options.show_nav_button;
			
			return function () {
	
				var deferred = jQuery.Deferred();
				try {
					if("Y" != _show_nav_button) {
						deferred.resolve();
						return;
					}
					
					_oSlideshowContainer.append('<i id="'+_lbtnID+'" class="fa fa-chevron-circle-left fa-3x" style="position:absolute;z-index:1;"></i>');
					_oSlideshowContainer.append('<i id="'+_rbtnID+'" class="fa fa-chevron-circle-right fa-3x" style="position:absolute;z-index:1;"></i>');
					
					var leftButton = jQuery("#"+_lbtnID);
					console.log("leftButton.width:"+leftButton.outerWidth()+" ");
					leftButton.css({
						left: "5px",
						top: parseInt((_height - leftButton.outerHeight())/2,10)+"px",
						opacity: "0.9"
					}).on('mouseover',function(){

						leftButton.css({
							opacity: "1"
						});
					}).on('mouseout',function(){

						leftButton.css({
							opacity: "0.9"
						});
					}).on('click',function(){
						_oJedoSlideshow.startTransitionPrev();
					});
					var rightButton = jQuery("#"+_rbtnID);
					rightButton.css({
						top: parseInt((_height - rightButton.outerHeight())/2,10)+"px",
						right: "5px",
						opacity: "0.9"
					}).on('mouseover',function(){

						rightButton.css({
							opacity: "1"
						});
					}).on('mouseout',function(){

						rightButton.css({
							opacity: "0.9"
						});
					}).on('click',function(){
						_oJedoSlideshow.startTransitionNext();
					});

					deferred.resolve();
				} finally {
					return deferred.promise();
				}
			}
		},
		enumerable: false,
		configurable: false
	});
	
	
	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "initShowInfo", {
		get: function() {
			var _oJedoSlideshow = this;
			var _datas = _oJedoSlideshow.datas;

			var _show_info = _datas.gallery.options.show_info;

			var _oSlideshowContainer = _oJedoSlideshow.slideshowContainer;
			var _containerWidth = _oSlideshowContainer.outerWidth();
			var _containerHeight = _oSlideshowContainer.outerHeight();
			
			var _sThisId = _oSlideshowContainer.attr("id");
			var _tShowInfoID = _sThisId + "_titleShowInfo";
			var _dShowInfoID = _sThisId + "_descShowInfo";

			return function () {
	
				var deferred = jQuery.Deferred();
				try {
					if("Y" != _show_info) {
						deferred.resolve();
						return;
					}
					if(_datas.slides.length <= 0) {
						deferred.resolve();
						return;
					}
					var _oSlide = _datas.slides[0];
					var _title = _oSlide.title;
					var _description = _oSlide.description;
					var _viewinfo = _oSlide.options.viewinfo;
					var _opacity_title = (parseInt(_oSlide.options.opacity_title,10)/100).toFixed(1);
					var _opacity_description = (parseInt(_oSlide.options.opacity_description,10)/100).toFixed(1);
					
					
					_oSlideshowContainer.append('<div id="'+_tShowInfoID+'" style="height:50px;width:100px;position:absolute;z-index:1;"></div>');
					_oSlideshowContainer.append('<div id="'+_dShowInfoID+'" style="height:50px;width:100px;position:absolute;z-index:1;"></div>');

					jQuery("#"+_tShowInfoID).css({
						  left: "0px",
						  top: "0px",
						  width: "100%",
						  height: "50px",
						  "background-color": "rgba(0,0,0,"+_opacity_title+")",
						  "font-size": "23px",
						  "font-weight": "bold",
						  "text-align": "center",
						  "color": "rgba(256,256,256,"+(1- _opacity_title)+")"
						}).text(_title).hide();
					
					jQuery("#"+_dShowInfoID).css({
						  left: "0px",
						  top: (_containerHeight-51)+"px",
						  width: "100%",
						  height: "50px",
						  "background-color": "rgba(0,0,0,"+_opacity_description+")",
						  "font-weight": "bold",
						  "color": "rgba(256,256,256,"+(1-_opacity_description)+")"
						}).text(_description).hide();

					Object.defineProperty(_oJedoSlideshow, "titleShowInfoID", {
						enumerable: false,
						configurable: false,
						writable: false,
						value: _tShowInfoID
					});

					Object.defineProperty(_oJedoSlideshow, "descShowInfoID", {
						enumerable: false,
						configurable: false,
						writable: false,
						value: _dShowInfoID
					});

					if("title" == _viewinfo) {

						jQuery("#"+_oJedoSlideshow.titleShowInfoID).show();
						
					} else if("description" == _viewinfo) {

						jQuery("#"+_oJedoSlideshow.descShowInfoID).show();
					} else if("both" == _viewinfo) {

						jQuery("#"+_oJedoSlideshow.titleShowInfoID).show();
						jQuery("#"+_oJedoSlideshow.descShowInfoID).show();
					}
					
					deferred.resolve();
				} finally {
					return deferred.promise();
				}
			}
		},
		enumerable: false,
		configurable: false
	});
	
	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "initSlideImage", {
		get: function() {
			var _oJedoSlideshow = this;
			var _datas = _oJedoSlideshow.datas;
			var _oSlideshowContainer = _oJedoSlideshow.slideshowContainer;
			var _height = _oSlideshowContainer.outerHeight();
			var _width = _oSlideshowContainer.outerWidth();
			
			return function () {
				
				var deferred = jQuery.Deferred();
				try {
					var _arrPromise = [];
					
					for(var i = 0; i < _datas.slides.length; i++) {
						_arrPromise.push(_oJedoSlideshow.loadSlideImage(i));
					}
	
					/*
					 * 순서상 처음 의 이미지는 바로 보여 준다.
					 */
					jQuery.when(jQuery, _arrPromise[0]).done(function(){
						
						var oImage = jQuery("#"+_datas.slides[0].slide_id);
						
						oImage.show();
					});
	
					jQuery.when.apply(jQuery, _arrPromise).done(function(){

						for(var i = 0; i < _datas.slides.length; i++) {
							
							_oJedoSlideshow.addThumbnailImage(i);
						}
						deferred.resolve();
					});
					
				} finally {
					return deferred.promise();
				}
			}
		},
		enumerable: false,
		configurable: false
	});
	
	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "loadSlideImage", {
		get: function() {
			var _oJedoSlideshow = this;
			var _datas = _oJedoSlideshow.datas;
			var _oSlideshowContainer = _oJedoSlideshow.slideshowContainer;
			var _sThisId = _oSlideshowContainer.attr("id");
			
			return function (idx) {
				
				var deferred = jQuery.Deferred();
				try {
					var containerWidth = _oSlideshowContainer.width();
					var containerHeight = _oSlideshowContainer.height();
					
					var oSlide = _datas.slides[idx];
					var opacity = (parseInt(oSlide.options.opacity,10) / 100).toFixed(1);

					try {
						_oSlideshowContainer.append("<div id='"+oSlide.slide_id+"' data-idx='"+idx+"' class='slide'></div>");
						jQuery("#"+oSlide.slide_id).css({
							width: containerWidth,
							height: containerHeight,
							opacity: opacity,
							"background": "url("+oSlide.options.image_url+")",
							"background-size": "cover",
							"background-position": "50% 50%",
							"background-repeat": "no-repeat"
						});

					}finally {
						deferred.resolve();
					}
				    
				} finally {
					return deferred.promise();
				}
			}
		},
		enumerable: false,
		configurable: false
	});
	
	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "initThumbnail", {
		get: function() {
			var _oJedoSlideshow = this;
			var _datas = _oJedoSlideshow.datas;
			
			var _oOutterContainer = _oJedoSlideshow.outterContainer;
			var _oSlideshowContainer = _oJedoSlideshow.slideshowContainer;

			var _sThisId = _oSlideshowContainer.attr("id");
			var _ThumbnailsID = _sThisId + "_thumbnails";
			var _ThumbnailsMainID = _ThumbnailsID + "_main";
			var _leftButtonID = _ThumbnailsID + "_leftButton";
			var _rightButtonID = _ThumbnailsID + "_rightButton";

			var _show_thumbnails = _datas.gallery.options.show_thumbnails;
			var _thumbnails_color = _datas.gallery.options.thumbnails_color;
			var _thumbnails_position = _datas.gallery.options.thumbnails_position;
			var _thumbnails_width = parseInt(_datas.gallery.options.thumbnails_width,10);
			var _thumbnails_height = parseInt(_datas.gallery.options.thumbnails_height,10);
			
			
			return function () {
				
				var deferred = jQuery.Deferred();
				try {
					if("Y" != _show_thumbnails) {
						deferred.resolve();
						return;
					}
					Object.defineProperty(_oJedoSlideshow, "thumbnailsID", {
						enumerable: false,
						configurable: false,
						writable: false,
						value: _ThumbnailsID
					});

					var _container_width = parseInt(_oSlideshowContainer.outerWidth(),10);
					var _container_height = parseInt(_oSlideshowContainer.outerHeight(),10);

					_oOutterContainer.height(_container_height+_thumbnails_height);
					
					_oOutterContainer.append('<div id="'+_ThumbnailsID+'" class="jedothumbnails"></div>');
					var oThumbnails = jQuery("#"+_ThumbnailsID);
					oThumbnails.css({
						height: _thumbnails_height+"px",
						width: _container_width,
						"background-color": _thumbnails_color
					});
					
					if(_thumbnails_position == "top") {
						oThumbnails.css({
							"top": 0
						});
						_oSlideshowContainer.css({
							"top": _thumbnails_height
						});
					} else {
						oThumbnails.css({
							"top": _container_height
						});
					}
					oThumbnails.append('<div id="'+_leftButtonID+'" class="thumbnails_button btn btn-default"><i class="fa fa-angle-left fa-3x" style="display:flex;align-items:center;"></i></div>');
					var oThumbnailsLeftButton = jQuery("#"+_leftButtonID);
					oThumbnailsLeftButton.css({
						"background-color": _thumbnails_color
					}).on("click",function(){
						_oJedoSlideshow.startTransitionPrev();
					});
					
					oThumbnails.append('<div id="'+_ThumbnailsMainID+'" class="thumbnails_main"></div>');
					var oThumbnailsMain = jQuery("#"+_ThumbnailsMainID);
					oThumbnailsMain.css({
						"width": (_container_width-(oThumbnailsLeftButton.outerWidth()*2))+"px",
						"left": oThumbnailsLeftButton.outerWidth()+"px",
						"background-color": _thumbnails_color
					});
					
					oThumbnails.append('<div id="'+_rightButtonID+'" class="thumbnails_button btn btn-default"><i class="fa fa-angle-right fa-3x" style="display:flex;align-items:center;"></i></div>');
					var oThumbnailsRightButton = jQuery("#"+_rightButtonID);
					oThumbnailsRightButton.css({
						"background-color": _thumbnails_color,
						"right": "0px"
					}).on("click", function(){
						_oJedoSlideshow.startTransitionNext();
					});
					
					Object.defineProperty(_oJedoSlideshow, "thumbnailsLeftButtonID", {
						enumerable: false,
						configurable: false,
						writable: false,
						value: _leftButtonID
					});
					Object.defineProperty(_oJedoSlideshow, "thumbnailsRightButtonID", {
						enumerable: false,
						configurable: false,
						writable: false,
						value: _rightButtonID
					});

					
					deferred.resolve();
				} finally {

					
					return deferred.promise();
				}
			}
		},
		enumerable: false,
		configurable: false
	});

	
	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "addThumbnailImage", {
		get: function() {
			var _oJedoSlideshow = this;
			var _datas = _oJedoSlideshow.datas;
			
			var _oOutterContainer = _oJedoSlideshow.outterContainer;
			var _oSlideshowContainer = _oJedoSlideshow.slideshowContainer;
			
			var _sThisId = _oSlideshowContainer.attr("id");
			var _ThumbnailsID = _sThisId + "_thumbnails";
			var _ThumbnailsMainID = _ThumbnailsID + "_main";
			var _leftButtonID = _ThumbnailsID + "_leftButton";
			var _rightButtonID = _ThumbnailsID + "_leftButton";

			var _show_thumbnails = _datas.gallery.options.show_thumbnails;
			var _thumbnails_color = _datas.gallery.options.thumbnails_color;
			var _thumbnails_active_color = _datas.gallery.options.thumbnails_active_color;
			var _thumbnails_width = parseInt(_datas.gallery.options.thumbnails_width,10);
			var _thumbnails_height = parseInt(_datas.gallery.options.thumbnails_height,10);
			var _thumbnails_spacing = parseInt(_datas.gallery.options.thumbnails_spacing,10);
			var _container_width = parseInt(_oSlideshowContainer.outerWidth(),10);
			var _container_height = parseInt(_oSlideshowContainer.outerHeight(),10);

			var oThumbnailsMain = jQuery("#"+_ThumbnailsMainID);
			
			return function (idx) {
				var deferred = jQuery.Deferred();
				try {
					if("Y" != _show_thumbnails) {
						deferred.resolve();
						return;
					}

					var oSlide = _datas.slides[idx];
					
					var slideImage = new Image();
					//slideImage.setAttribute("id", );
					slideImage.setAttribute("idx", idx);
					slideImage.setAttribute("class", "thumbnails_image");
					slideImage.onload = function() {
						try {
							var oImg = jQuery(this);
							if(_thumbnails_width < oImg.outerWidth()) {
								var n = _thumbnails_width / oImg.outerWidth();
								var w = oImg.outerWidth() * n;
								var h = oImg.outerHeight() * n;
								oImg.width(_thumbnails_width);
								oImg.height(h);
							}
						}finally {
							deferred.resolve();
						}
				    };
				    slideImage.src = oSlide.options.image_url;
				    oThumbnailsMain.append(slideImage);
				    jQuery(slideImage).css({

				    	"border-style": "solid",
			    		"border-width": "1px",
			    		"border-color": _thumbnails_color
			    		
					}).on("mouseover", function(){

					    jQuery(this).css({
					    	"border-width": "2px",
				    		"border-color": _thumbnails_active_color
						});
						
					}).on("mouseout", function(){

					    jQuery(this).css({
					    	"border-width": "1px",
					    	"border-color": _thumbnails_color
						});
						
					}).on("click", function(){

						var idx = jQuery(this).attr("idx");
						_oJedoSlideshow.vndx = idx;
						console.log("idx:"+idx);
						_oJedoSlideshow.startTransitionNext();
					});

				    jQuery(".thumbnails_image").css({
					    "margin-left": _thumbnails_spacing+"px"
					});
					
				} finally {
					return deferred.promise();
				}
			}
		},
		enumerable: false,
		configurable: false
	});

	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "startAutoSliding", {
		get: function() {
			var _oJedoSlideshow = this;
			var _datas = _oJedoSlideshow.datas;
			
			return function () {
				if(_oJedoSlideshow.timeoutID !== null) clearTimeout(_oJedoSlideshow.timeoutID);
				_oJedoSlideshow.timeoutID = setTimeout(function(){
					_oJedoSlideshow.startTransitionNext();
				}, _datas.gallery.options.auto_slide_speed);
				console.log("timeoutID:"+_oJedoSlideshow.timeoutID);
			}
		},
		enumerable: false,
		configurable: false
	});
	
	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "stopAutoSliding", {
		get: function() {
			var _oJedoSlideshow = this;
			return function () {
				if(_oJedoSlideshow.timeoutID !== null) clearTimeout(_oJedoSlideshow.timeoutID);
				console.log("cleared timeoutID:"+_oJedoSlideshow.timeoutID);
				_oJedoSlideshow.timeoutID = null;
			}
		},
		enumerable: false,
		configurable: false
	});

	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "startTransitionPrev", {
		get: function() {
			var _oJedoSlideshow = this;
			var _datas = _oJedoSlideshow.datas;
			
			return function () {

				var deferred = jQuery.Deferred();
				try {
					if(_oJedoSlideshow.nowTransition) {
						deferred.resolve();
						return;
					}
					_oJedoSlideshow.nowTransition = true;
					
					jQuery.when(_oJedoSlideshow.hideShowInfo()).done(function(){
						jQuery.when(_oJedoSlideshow.transitionPrev()).done(function(){
							jQuery.when(_oJedoSlideshow.showShowInfo()).done(function(){
							
								jQuery.when(_oJedoSlideshow.transitionPrevEnd()).done(function(){
	
									_oJedoSlideshow.nowTransition = false;

									deferred.resolve();
								});
							});
						});
					});
					
				} finally {
					return deferred.promise();
				}
			}
		},
		enumerable: false,
		configurable: false
	});
	
	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "startTransitionNext", {
		get: function() {
			var _oJedoSlideshow = this;
			var _datas = _oJedoSlideshow.datas;
			
			return function () {

				var deferred = jQuery.Deferred();
				try {
					if(_oJedoSlideshow.nowTransition) {
						deferred.resolve();
						return;
					}

					if(!_oJedoSlideshow.stopTransition) {
						
						_oJedoSlideshow.nowTransition = true;
						
						jQuery.when(_oJedoSlideshow.hideShowInfo()).done(function(){
							jQuery.when(_oJedoSlideshow.transitionNext()).done(function(){
								jQuery.when(_oJedoSlideshow.showShowInfo()).done(function(){
									jQuery.when(_oJedoSlideshow.transitionNextEnd()).done(function(){
		
										_oJedoSlideshow.nowTransition = false;
										deferred.resolve();
	
										if(0 < _datas.slides.length && _datas.gallery.options.auto_slide == "Y") {
											
											if(_oJedoSlideshow.timeoutID !== null) clearTimeout(_oJedoSlideshow.timeoutID);
											_oJedoSlideshow.timeoutID = setTimeout(function(){
												_oJedoSlideshow.startTransitionNext();
											}, _datas.gallery.options.auto_slide_speed);
										}
										
									});
								});
							});
						});
					} else {

						if(0 < _datas.slides.length && _datas.gallery.options.auto_slide == "Y") {
							if(_oJedoSlideshow.timeoutID !== null) clearTimeout(_oJedoSlideshow.timeoutID);
							_oJedoSlideshow.timeoutID = setTimeout(function(){
								_oJedoSlideshow.startTransitionNext();
							}, _datas.gallery.options.auto_slide_speed);
						}
					}
				} finally {
					return deferred.promise();
				}
			}
		},
		enumerable: false,
		configurable: false
	});

	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "hideShowInfo", {
		get: function() {
			var _oJedoSlideshow = this;
			var _datas = _oJedoSlideshow.datas;

			var _show_info = _datas.gallery.options.show_info;
			var _viewinfo = _datas.slides[_oJedoSlideshow.vidx].options.viewinfo;
			
			var _oSlideshowContainer = _oJedoSlideshow.slideshowContainer;
			var _container_height = _oSlideshowContainer.outerHeight();
			
			return function () {
				console.log("_datas.gallery.options.show_info:"+_datas.gallery.options.show_info);
				var deferred = jQuery.Deferred();
				try {
					if("Y" != _show_info) {
						deferred.resolve();
						return;
					}
					console.log("_slide.options.viewinfo:"+_viewinfo);
					if("title" == _viewinfo) {

						var oTitleSI = jQuery("#"+_oJedoSlideshow.titleShowInfoID);
						oTitleSI.animate({
							"top": -(oTitleSI.outerHeight())
						}, 400, function(){

							oTitleSI.hide();
							deferred.resolve();
						});
					} else if("description" == _viewinfo) {

						var oDescSI = jQuery("#"+_oJedoSlideshow.descShowInfoID);
						oDescSI.animate({
							"top": _oSlideshowContainer.outerHeight()
						}, 400, function(){

							oDescSI.hide();
							deferred.resolve();
						});
					} else if("both" == _viewinfo) {
						
						var oTitleSI = jQuery("#"+_oJedoSlideshow.titleShowInfoID);
						var oDescSI = jQuery("#"+_oJedoSlideshow.descShowInfoID);

						var title_height = oTitleSI.outerHeight();
						var desc_height = oDescSI.outerHeight();
						
						oTitleSI.animate({
							"top": -(title_height)
						}, {
							"duration": 400, 
							"step": function(now, fx){

								if(fx.prop == "top") {
									var n = Math.abs(now) * ( 100 / title_height);
									//console.log("Math.abs(now)["+Math.abs(now)+"] title_height["+title_height+"]  n:"+n);
									oDescSI.css({
										"top": _container_height - desc_height + ((desc_height/100) * n)
									});
								}
							},
							"complete": function(){

								oDescSI.css({
									"top": _container_height
								});

								oTitleSI.hide();
								oDescSI.hide();
								
								deferred.resolve();
							}
						});
					} else {
						throw new Error("_viewinfo is bad");
					}
				} finally {
					return deferred.promise();
				}
			}
		},
		enumerable: false,
		configurable: false
	});

	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "showShowInfo", {
		get: function() {
			var _oJedoSlideshow = this;
			var _datas = _oJedoSlideshow.datas;

			var _oSlideshowContainer = _oJedoSlideshow.slideshowContainer;
			var _container_height = _oSlideshowContainer.outerHeight();

			var _show_info = _datas.gallery.options.show_info;

			var _oSlide = _datas.slides[_oJedoSlideshow.vndx];
			
			var _title = _oSlide.title;
			var _description = _oSlide.description;

			var _viewinfo = _oSlide.options.viewinfo;
			var _opacity_title = (parseInt(_oSlide.options.opacity_title,10)/100).toFixed(1);
			var _opacity_description = (parseInt(_oSlide.options.opacity_description,10)/100).toFixed(1);
			
			return function () {
				console.log(" s -- showShowInfo ");
				console.log("_show_info["+_show_info+"] _viewinfo["+_viewinfo+"] _opacity_title["+_opacity_title+"] _opacity_description["+_opacity_description+"]");

				var deferred = jQuery.Deferred();
				try {
					if("Y" != _show_info) {
						deferred.resolve();
						return;
					}
					var oTitleSI = jQuery("#"+_oJedoSlideshow.titleShowInfoID);
					var oDescSI = jQuery("#"+_oJedoSlideshow.descShowInfoID);

					var title_height = oTitleSI.outerHeight();
					var desc_height = oDescSI.outerHeight();

					if("title" == _viewinfo) {

						oTitleSI.css({
							"top": -(title_height),
							"background-color": "rgba(0,0,0,"+_opacity_title+")"
						}).text(_title).show().animate({
							"top": 0
						}, 600, function(){
							deferred.resolve();
						});
					} else if("description" == _viewinfo) {

						oDescSI.css({
							"top": _container_height,
							"background-color": "rgba(0,0,0,"+_opacity_description+")"
						}).text(_description).show().animate({
							"top": _container_height + desc_height
						}, 600, function(){
							deferred.resolve();
						});
					} else if("both" == _viewinfo) {

						oDescSI.css({
							"top": _container_height,
							"background-color": "rgba(0,0,0,"+_opacity_description+")"
						}).text(_description).show();
						oTitleSI.css({
							"top": -(title_height),
							"background-color": "rgba(0,0,0,"+_opacity_title+")"
						}).text(_title).show().animate({
							"top": 0
						}, {
							"duration": 600, 
							"step": function(now, fx){
								if(fx.prop == "top") {
									var n = Math.abs(now) * ( 100 / title_height);
									//console.log("Math.abs(now)["+Math.abs(now)+"] title_height["+title_height+"]  n:"+n);
									oDescSI.css({
										"top": _container_height - (desc_height - ((desc_height/100) * n))
									});
								}
							},
							"complete": function(){
								oDescSI.css({
									"top": _container_height - desc_height
								});
								deferred.resolve();
							}
						});
					} else {
						throw new Error("_viewinfo is bad");
					}
				} finally {
					return deferred.promise();
				}
			}
		},
		enumerable: false,
		configurable: false
	});
	

	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "transitionPrev", {
		get: function() {
			var _oJedoSlideshow = this;
			var _datas = _oJedoSlideshow.datas;
			
			return function () {
				var deferred = jQuery.Deferred();
				try {
					var promise = null;
					if(_datas.gallery.options.slide_effect == "slide") {
						promise = _oJedoSlideshow.slidePrev();
					} else if(_datas.gallery.options.slide_effect == "size") {
						promise = _oJedoSlideshow.sizePrev();
					} else if(_datas.gallery.options.slide_effect == "scale") {
						promise = _oJedoSlideshow.scalePrev();
					} else if(_datas.gallery.options.slide_effect == "blind") {
						promise = _oJedoSlideshow.blindPrev();
					} else if(_datas.gallery.options.slide_effect == "fold") {
						promise = _oJedoSlideshow.foldPrev();
					} else {
						throw new Error("slide_effect is bad");
					}
					jQuery.when(promise).done(function(){

						deferred.resolve();
					});
				} finally {
					return deferred.promise();
				}
			}
		},
		enumerable: false,
		configurable: false
	});
	
	
	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "transitionNext", {
		get: function() {
			var _oJedoSlideshow = this;
			var _datas = _oJedoSlideshow.datas;
			
			return function () {

				var deferred = jQuery.Deferred();
				try {
					var promise = null;
					if(_datas.gallery.options.slide_effect == "slide") {
						promise = _oJedoSlideshow.slideNext();
					} else if(_datas.gallery.options.slide_effect == "size") {
						promise = _oJedoSlideshow.sizeNext();
					} else if(_datas.gallery.options.slide_effect == "scale") {
						promise = _oJedoSlideshow.scaleNext();
					} else if(_datas.gallery.options.slide_effect == "blind") {
						promise = _oJedoSlideshow.blindNext();
					} else if(_datas.gallery.options.slide_effect == "fold") {
						promise = _oJedoSlideshow.foldNext();
					} else {
						throw new Error("slide_effect is bad");
					}
					jQuery.when(promise).done(function(){

						deferred.resolve();
					});
				} finally {
					return deferred.promise();
				}
			}
		},
		enumerable: false,
		configurable: false
	});

	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "foldNext", {
		get: function() {
			var _oJedoSlideshow = this;
			var _datas = _oJedoSlideshow.datas;
			var _slide_effect = _datas.gallery.options.slide_effect;
			var _slide_direction = _datas.gallery.options.slide_direction;
			var _slide_speed = parseInt(_datas.gallery.options.slide_speed,10);
			var _easing = _datas.gallery.options.easing;
			
			var _oSlideshowContainer = _oJedoSlideshow.slideshowContainer;
			
			var _height = _oSlideshowContainer.outerHeight();
			var _width = _oSlideshowContainer.outerWidth();

			var _imageIDVidx = _datas.slides[_oJedoSlideshow.vidx].slide_id;
			var _imageIDVndx = _datas.slides[_oJedoSlideshow.vndx].slide_id;
			var _opacity = parseFloat((parseInt(_datas.slides[_oJedoSlideshow.vndx].opacity,10) / 100).toFixed(1));

			return function () {

				var deferred = jQuery.Deferred();
				try {
	
					console.log("_slide_direction:"+_slide_direction+" _opacity:"+_opacity);
	
					var oVidx = jQuery("#"+_imageIDVidx);
					var oVndx = jQuery("#"+_imageIDVndx);
	
					var h = oVndx.outerHeight();
					var w = oVndx.outerWidth();
					var l = parseInt((_width - w)/2,10);
					var t = parseInt((_height - h)/2,10);
	
					var f = 100;
	
					var fnFoldFromHeight = function() {
						if(_slide_direction == "ULRD" || _slide_direction == "URLD" || _slide_direction == "DLRU" || _slide_direction == "DRLU") {
							return f;
							
						} else if(_slide_direction == "LUDR" || _slide_direction == "LDUR" || _slide_direction == "RUDL" || _slide_direction == "RDUL") {
	
							return 0;
						}
					};
					var fnFoldFromWidth = function() {
						if(_slide_direction == "ULRD" || _slide_direction == "URLD" || _slide_direction == "DLRU" || _slide_direction == "DRLU") {
							return 0;
							
						} else if(_slide_direction == "LUDR" || _slide_direction == "LDUR" || _slide_direction == "RUDL" || _slide_direction == "RDUL") {
	
							return f;
						}
					};
					var fnFoldFromLeft = function() {
						if(_slide_direction == "ULRD" || _slide_direction == "URLD" || _slide_direction == "DLRU" || _slide_direction == "DRLU") {
							return 0;
							
						} else if(_slide_direction == "LUDR" || _slide_direction == "LDUR") {
	
							return 0;
							
						} else if(_slide_direction == "RUDL" || _slide_direction == "RDUL") {
	
							return _width - f;
						}
					};
					var fnFoldFromTop = function() {
						if(_slide_direction == "ULRD" || _slide_direction == "URLD") {
	
							return 0;
							
						} else if( _slide_direction == "DLRU" || _slide_direction == "DRLU") {
							
							return parseInt((_height - h)/2,10) + h - f ;
							
						} else if(_slide_direction == "LUDR" || _slide_direction == "LDUR") {
							
							return 0;
							
						} else if(_slide_direction == "RUDL" || _slide_direction == "RDUL") {
							
							return 0;
						}
					};
	
					oVndx.css({
						height: fnFoldFromHeight(),
						width: fnFoldFromWidth(),
						left: fnFoldFromLeft(),
						top: fnFoldFromTop()
					}).show();
	
					var sd_first_move = _slide_direction.substring(1, 3);
					var sd_second_move = _slide_direction.substring(3, 4);
					console.log("sd_first_move:"+sd_first_move+" top:"+oVndx.css("top")+" opacity:"+oVndx.css("opacity"));
	
					oVndx.animate(
						(sd_first_move == "LR" || sd_first_move == "RL") ? { width: w} : { height: h}, 
						{
						duration: parseInt(_slide_speed/2,10),
						easing: _easing,
						step: function(now, fx){
							if(sd_first_move == "RL") {
								
								var x = parseInt((l + w) - now,10);
								//console.log(-(x)+" 0px");
								oVndx.css({
									left: x
								});
							} else if(sd_first_move == "DU") {
	
								var y = parseInt((t + h) - now,10);
								//console.log("h:"+h+" now:"+now+" t:"+t+" y:"+y);
								oVndx.css({
									top: y
								});
							}
						},
						complete: function() {
							oVndx.animate(
								(sd_second_move == "D" || sd_second_move == "U") ? { height: h} : { width: w}, 
								{
									duration: parseInt(_slide_speed/2,10),
									easing: _easing,
									step: function(now, fx){
										if(sd_second_move == "L") {
	
											var x = parseInt((l + w) - now,10);
											//console.log("w:"+w+" now:"+now+" l:"+l+" x:"+x);
											oVndx.css({
												left: x
											});
										} else if(sd_second_move == "U") {
											
											var y = parseInt((t + h) - now,10);
											//console.log("w:"+w+" now:"+now+" l:"+l+" x:"+x);
											oVndx.css({
												top: y
											});
										}
									},
									complete: function() {
		
										oVidx.hide();
										
										deferred.resolve();
									}
								}
							);
						}
					});

				} finally {
					return deferred.promise();
				}
			}
		},
		enumerable: false,
		configurable: false
	});

	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "blindNext", {
		get: function() {
			var _oJedoSlideshow = this;
			var _datas = _oJedoSlideshow.datas;
			var _slide_effect = _datas.gallery.options.slide_effect;
			var _slide_direction = _datas.gallery.options.slide_direction;
			var _slide_speed = parseInt(_datas.gallery.options.slide_speed,10);
			var _easing = _datas.gallery.options.easing;
			
			var _oSlideshowContainer = _oJedoSlideshow.slideshowContainer;
			
			var _height = _oSlideshowContainer.outerHeight();
			var _width = _oSlideshowContainer.outerWidth();

			var _imageIDVidx = _datas.slides[_oJedoSlideshow.vidx].slide_id;
			var _imageIDVndx = _datas.slides[_oJedoSlideshow.vndx].slide_id;

			return function () {

				var deferred = jQuery.Deferred();
				try {
	
					var oVidx = jQuery("#"+_imageIDVidx);
					var oVndx = jQuery("#"+_imageIDVndx);
	
					var h = oVndx.outerHeight();
					var w = oVndx.outerWidth();
					var l = parseInt((_width - w)/2,10);
					var t = parseInt((_height - h)/2,10);
	
					var from = {
							height: 0,
							width: 0,
							left: parseInt((_width - w)/2,10),
							top: parseInt((_height - h)/2,10)
						};
					var to = {};
					if(_slide_direction == "LR") {
						from.height = h;
						to.width = w;
					} else if(_slide_direction == "RL") {
						from.height = h;
						to.width = w;
					} else if(_slide_direction == "UD") {
						from.width = w;
						to.height = h;
					} else if(_slide_direction == "DU") {
						from.width = w;
						to.height = h;
					}
					
					oVndx.css(from).show();
					oVndx.animate(
							to, {
							duration: _slide_speed,
							easing: _easing,
							step: function( now, fx ) {
								if(_slide_direction == "RL") {
									oVndx.css({
										left: (l + w) - now
									});
								} else if(_slide_direction == "DU") {
									oVndx.css({
										top: (t + h) - now
									});
								}
							},
							complete: function() {
								
								oVidx.hide();
		
								deferred.resolve();
							}
						}
					);

				} finally {
					return deferred.promise();
				}
			}
		},
		enumerable: false,
		configurable: false
	});

	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "blindPrev", {
		get: function() {
			var _oJedoSlideshow = this;
			var _datas = _oJedoSlideshow.datas;
			
			var _slide_effect = _datas.gallery.options.slide_effect;
			var _slide_direction = _datas.gallery.options.slide_direction;
			var _slide_speed = parseInt(_datas.gallery.options.slide_speed,10);
			var _easing = _datas.gallery.options.easing;
			
			var _oSlideshowContainer = _oJedoSlideshow.slideshowContainer;
			
			var _height = _oSlideshowContainer.outerHeight();
			var _width = _oSlideshowContainer.outerWidth();

			var _imageIDVidx = _datas.slides[_oJedoSlideshow.vidx].slide_id;
			var _imageIDVpdx = _datas.slides[_oJedoSlideshow.vpdx].slide_id;

			return function () {

				var deferred = jQuery.Deferred();
				try {
	
					var oVidx = jQuery("#"+_imageIDVidx);
					var oVpdx = jQuery("#"+_imageIDVpdx);
	
					// LR - 왼
					oVpdx.css({
						height: _slide_direction == "LR" || _slide_direction == "RL" ? _height : 0,
						width: _slide_direction == "UD" || _slide_direction == "DU" ? _width : 0,
						left: _slide_direction == "LR" ? _width : 0,
						top: _slide_direction == "UD" ? _height : 0
					}).show();
					oVpdx.animate({
	
						height: _height,
						width: _width
						
						}, {
						duration: _slide_speed,
						easing: _easing,
						step: function( now, fx ) {
							if(_slide_direction == "LR") {
								oVpdx.css({
									left: _width - now
								});
							} else if(_slide_direction == "UD") {
								oVpdx.css({
									top: _height - now
								});
							}
						},
						complete: function() {
							
							oVidx.hide();
	
							deferred.resolve();
						}
					});

				} finally {
					return deferred.promise();
				}
			}
		},
		enumerable: false,
		configurable: false
	});
	
	
	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "scaleNext", {
		get: function() {
			var _oJedoSlideshow = this;
			var _datas = _oJedoSlideshow.datas;
			var _slide_effect = _datas.gallery.options.slide_effect;
			var _slide_speed = parseInt(_datas.gallery.options.slide_speed,10);
			var _easing = _datas.gallery.options.easing;
			
			var _oSlideshowContainer = _oJedoSlideshow.slideshowContainer;
			
			var _height = _oSlideshowContainer.outerHeight();
			var _width = _oSlideshowContainer.outerWidth();

			var _imageIDVidx = _datas.slides[_oJedoSlideshow.vidx].slide_id;
			var _imageIDVndx = _datas.slides[_oJedoSlideshow.vndx].slide_id;

			return function () {

				var deferred = jQuery.Deferred();
				try {
	
					var oVidx = jQuery("#"+_imageIDVidx);
					var oVndx = jQuery("#"+_imageIDVndx);
	
	
					var h = oVndx.outerHeight();
					var w = oVndx.outerWidth();
					
					oVndx.css({
						width: 0,
						height: 0,
						left: parseInt(_width/2,10),
						top: parseInt(_height/2,10)
					}).show();
					oVndx.animate(
						{
							height: h,
							width: w
						}, {
							duration: _slide_speed,
							easing: _easing,
							step: function( now, fx ) {
								if(fx.prop == "width") {
	
									oVndx.css({
										left: parseInt((_width - now)/2,10)
									});
									
								} else if(fx.prop == "height") {
									var t = parseInt((_height - now)/2,10);
									oVndx.css({
										top: t
									});
									//console.log(t);
								}
							},
							complete: function() {
								
								oVidx.hide();
		
								deferred.resolve();
							}
						}
					);

				} finally {
					return deferred.promise();
				}
			}
		},
		enumerable: false,
		configurable: false
	});

	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "scalePrev", {
		get: function() {
			var _oJedoSlideshow = this;
			var _datas = _oJedoSlideshow.datas;
			
			var _slide_effect = _datas.gallery.options.slide_effect;
			var _slide_speed = parseInt(_datas.gallery.options.slide_speed,10);
			var _easing = _datas.gallery.options.easing;
			
			var _oSlideshowContainer = _oJedoSlideshow.slideshowContainer;
			var _height = _oSlideshowContainer.outerHeight();
			var _width = _oSlideshowContainer.outerWidth();

			var _imageIDVpdx = _datas.slides[_oJedoSlideshow.vpdx].slide_id;
			var _imageIDVidx = _datas.slides[_oJedoSlideshow.vidx].slide_id;
			

			return function () {

				var deferred = jQuery.Deferred();
				try {
					var oVidx = jQuery("#"+_imageIDVidx);
					var oVpdx = jQuery("#"+_imageIDVpdx);
					
					oVidx.css({
						"z-index": 1
					});
					oVpdx.css({
						width: _width,
						height: _height,
						left: 0,
						top: 0
					}).show();
					
					oVidx.animate(
						{
							height: 0,
							width: 0
						}, {
							duration: _slide_speed,
							easing: _easing,
							step: function( now, fx ) {
								if(fx.prop == "width") {
	
									oVidx.css({
										left: parseInt((_width - now)/2,10)
									});
									
								} else if(fx.prop == "height") {
									var t = parseInt((_height - now)/2,10);
									oVidx.css({
										top: t
									});
									//console.log(t);
								}
							},
							complete: function() {
	
								oVidx.css({
									"z-index": "initial"
								});
								oVidx.hide();
		
								deferred.resolve();
							}
						}
					);

				} finally {
					return deferred.promise();
				}
			}
		},
		enumerable: false,
		configurable: false
	});

	
	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "slideNext", {
		get: function() {
			var _oJedoSlideshow = this;
			var _datas = _oJedoSlideshow.datas;
			var _slide_speed = parseInt(_datas.gallery.options.slide_speed,10);
			var _easing = _datas.gallery.options.easing;
			var _slide_direction = _datas.gallery.options.slide_direction;
			
			var _oSlideshowContainer = _oJedoSlideshow.slideshowContainer;
			var _height = _oSlideshowContainer.outerHeight();
			var _width = _oSlideshowContainer.outerWidth();
			var _sThisId = _oSlideshowContainer.attr("id");

			var _opacity_title = _datas.slides[_oJedoSlideshow.vndx].opacity_title;
			var _opacity_description = _datas.slides[_oJedoSlideshow.vndx].opacity_description;

			var _imageIDVidx = _datas.slides[_oJedoSlideshow.vidx].slide_id;
			var _imageIDVndx = _datas.slides[_oJedoSlideshow.vndx].slide_id;
			var _opacity = parseInt(_datas.slides[_oJedoSlideshow.vndx].opacity,10)/100;
	
			return function () {

				var deferred = jQuery.Deferred();
				try {
					
					var oVidx = jQuery("#"+_imageIDVidx);
					var oVndx = jQuery("#"+_imageIDVndx);

					
					// LR - 왼쪽 -> 오른쪽
					// RL - 오른쪽 -> 왼쪽
					// UD - 위 -> 아래
					// DU - 아래 -> 위
					oVndx.css({
						left: _slide_direction == "LR" ? -(_width) : _slide_direction == "RL" ? _width : 0,
						top: _slide_direction == "DU" ? _height : _slide_direction == "UD" ? -(_height) : 0
					}).show();
					oVndx.animate({
						left: 0,
						top: 0
					},{
						duration: _slide_speed,
						easing: _easing,
						step: function (now, fx) {
							if(fx.prop == "left" && (_slide_direction == "LR" || _slide_direction == "RL")) {

								if(_slide_direction == "LR") {
									oVidx.css({
										left: now + _width
									});
								} else if(_slide_direction == "RL") {

									oVidx.css({
										left: now - _width
									});
								}

							} else if(fx.prop == "top" && (_slide_direction == "DU" || _slide_direction == "UD")) {

								if(_slide_direction == "UD") {
									oVidx.css({
										top: now + _height
									});
								} else {
									oVidx.css({
										top: now - _height
									});
								}
							}
						},
						complete: function() {

							oVidx.hide();
							
							deferred.resolve();
						}
					});
					

				} finally {
					return deferred.promise();
				}
			}
		},
		enumerable: false,
		configurable: false
	});

	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "slidePrev", {
		get: function() {
			var _oJedoSlideshow = this;
			var _datas = _oJedoSlideshow.datas;
			var _slide_speed = parseInt(_datas.gallery.options.slide_speed,10);
			var _easing = _datas.gallery.options.easing;
			var _slide_direction = _datas.gallery.options.slide_direction;
			
			var _oSlideshowContainer = _oJedoSlideshow.slideshowContainer;
			var _height = _oSlideshowContainer.outerHeight();
			var _width = _oSlideshowContainer.outerWidth();

			var _imageIDVpdx = _datas.slides[_oJedoSlideshow.vpdx].slide_id;
			var _imageIDVidx = _datas.slides[_oJedoSlideshow.vidx].slide_id;
	
			return function () {
				
				var deferred = jQuery.Deferred();
				try {
					

					var oVpdx = jQuery("#"+_imageIDVpdx);
					var oVidx = jQuery("#"+_imageIDVidx);

					
					// LR - 왼쪽 -> 오른쪽
					// RL - 오른쪽 -> 왼쪽
					// UD - 위 -> 아래
					// DU - 아래 -> 위
					oVpdx.css({
						left: _slide_direction == "LR" ? _width : _slide_direction == "RL" ? -(_width) : 0,
						top: _slide_direction == "UD" ? _height : _slide_direction == "DU" ? -(_height) : 0
					}).show();
					oVpdx.animate({
						left: 0,
						top: 0
					},{
						duration: _slide_speed,
						easing: _easing,
						step: function (now, fx) {
							if(fx.prop == "left" && (_slide_direction == "LR" || _slide_direction == "RL")) {

								if(_slide_direction == "LR") {
									oVidx.css({
										left: now - _width
									});
								} else if(_slide_direction == "RL") {

									oVidx.css({
										left: now + _width
									});
								}

							} else if(fx.prop == "top" && (_slide_direction == "DU" || _slide_direction == "UD")) {

								if(_slide_direction == "UD") {
									oVidx.css({
										top: now - _height
									});
								} else {
									oVidx.css({
										top: now + _height
									});
								}
							}
						},
						complete: function() {

							oVidx.hide();

							deferred.resolve();
						}
					});
					
				} finally {
					return deferred.promise();
				}
			}
		},
		enumerable: false,
		configurable: false
	});


	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "sizeNext", {
		get: function() {
			var _oJedoSlideshow = this;
			var _datas = _oJedoSlideshow.datas;
			var _slide_speed = parseInt(_datas.gallery.options.slide_speed,10);
			var _easing = _datas.gallery.options.easing;
			var _slideDirection = _datas.gallery.options.slide_direction;
			
			var _oSlideshowContainer = _oJedoSlideshow.slideshowContainer;
			var _height = _oSlideshowContainer.outerHeight();
			var _width = _oSlideshowContainer.outerWidth();
			var _sThisId = _oSlideshowContainer.attr("id");

			var _opacity_title = _datas.slides[_oJedoSlideshow.vndx].opacity_title;
			var _opacity_description = _datas.slides[_oJedoSlideshow.vndx].opacity_description;

			var _imageIDVidx = _datas.slides[_oJedoSlideshow.vidx].slide_id;
			var _imageIDVndx = _datas.slides[_oJedoSlideshow.vndx].slide_id;
			var _opacity = parseInt(_datas.slides[_oJedoSlideshow.vndx].opacity,10)/100;
	
			return function () {
				
				var deferred = jQuery.Deferred();
				try {
					
					var oVidx = jQuery("#"+_imageIDVidx);
					var oVndx = jQuery("#"+_imageIDVndx);
					var wVidx = oVidx.outerWidth();
					var wVndx = oVndx.outerWidth();

					// ULRD - 위.왼쪽 -> 아래.오른쪽
					// URLD - 위.오른쪽 -> 아래.왼쪽
					// DLRU - 아래.왼쪽 -> 위.오른쪽
					// DRLU - 아래.오른쪽 -> 위.왼쪽
					
					oVndx.css({
						left: (_slideDirection == "ULRD" || _slideDirection == "DLRU") ? 0 : _width,
						top: (_slideDirection == "ULRD" || _slideDirection == "URLD") ? 0 : _height,
						width: 0,
						height: 0
					}).show();
					oVndx.animate({
						width: _width,
						height: _height
					},{
						easing: _easing,
						step: function(now, fx) {
							if(fx.prop == "width") {

								if(_slideDirection == "URLD" || _slideDirection == "DRLU") {

									oVndx.css({
										left: _width - now
									});
								}
								
							} else if(fx.prop == "height") {

								if(_slideDirection == "DLRU" || _slideDirection == "DRLU") {

									oVndx.css({
										top: _height - now
									});
								}
								
							}
						},
						complete: function() {

							oVidx.hide();

							deferred.resolve();
						}
					});
					
				} finally {
					return deferred.promise();
				}
			}
		},
		enumerable: false,
		configurable: false
	});

	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "sizePrev", {
		get: function() {
			var _oJedoSlideshow = this;
			var _datas = _oJedoSlideshow.datas;
			var _slide_speed = parseInt(_datas.gallery.options.slide_speed,10);
			var _easing = _datas.gallery.options.easing;
			var _slideDirection = _datas.gallery.options.slide_direction;
			
			var _oSlideshowContainer = _oJedoSlideshow.slideshowContainer;
			var _height = _oSlideshowContainer.outerHeight();
			var _width = _oSlideshowContainer.outerWidth();

			var _imageIDVpdx = _datas.slides[_oJedoSlideshow.vpdx].slide_id;
			var _imageIDVidx = _datas.slides[_oJedoSlideshow.vidx].slide_id;
	
			return function () {
				
				var deferred = jQuery.Deferred();
				try {

					
					var oVpdx = jQuery("#"+_imageIDVpdx);
					var oVidx = jQuery("#"+_imageIDVidx);

					// ULRD - 위.왼쪽 -> 아래.오른쪽
					// URLD - 위.오른쪽 -> 아래.왼쪽
					// DLRU - 아래.왼쪽 -> 위.오른쪽
					// DRLU - 아래.오른쪽 -> 위.왼쪽
					
					oVpdx.css({
						left: (_slideDirection == "ULRD" || _slideDirection == "DLRU") ? _width : 0,
						top: (_slideDirection == "ULRD" || _slideDirection == "URLD") ? _height : 0,
						width: 0,
						height: 0
					}).show().animate({
						width: _width,
						height: _height
					},{
						easing: _easing,
						step: function(now, fx) {
							if(fx.prop == "width") {

								if(_slideDirection == "ULRD" || _slideDirection == "DLRU") {

									oVpdx.css({
										left: _width - now
									});
								}
								
							} else if(fx.prop == "height") {

								if(_slideDirection == "URLD" || _slideDirection == "ULRD") {

									oVpdx.css({
										top: _height - now
									});
								}
								
							}
						},
						complete: function() {

							oVidx.hide();

							deferred.resolve();
						}
					});
					
				} finally {
					return deferred.promise();
				}
			}
		},
		enumerable: false,
		configurable: false
	});

	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "transitionPrevEnd", {
		get: function() {
			var _oJedoSlideshow = this;
			var _datas = _oJedoSlideshow.datas;

			return function () {

				var deferred = jQuery.Deferred();
				try {
					_oJedoSlideshow.vndx = _oJedoSlideshow.vidx;
					_oJedoSlideshow.vidx = _oJedoSlideshow.vpdx;
					if(_oJedoSlideshow.vpdx - 1 < 0) {
						_oJedoSlideshow.vpdx = _oJedoSlideshow.vedx;
					} else {
						_oJedoSlideshow.vpdx--;
					}
					
					deferred.resolve();
					
				} finally {
					return deferred.promise();
				}
			}
		},
		enumerable: false,
		configurable: false
	});

	Object.defineProperty(jedo.SlideshowJedoGallery.prototype, "transitionNextEnd", {
		get: function() {
			var _oJedoSlideshow = this;
			var _datas = _oJedoSlideshow.datas;

			return function () {

				var deferred = jQuery.Deferred();
				try {
					_oJedoSlideshow.vpdx = _oJedoSlideshow.vidx;
					_oJedoSlideshow.vidx = _oJedoSlideshow.vndx;
					if(_oJedoSlideshow.vndx < _oJedoSlideshow.vedx) {
						_oJedoSlideshow.vndx++;
					} else {
						_oJedoSlideshow.vndx = 0;
					}
					
					deferred.resolve();
					
				} finally {
					return deferred.promise();
				}
			}
		},
		enumerable: false,
		configurable: false
	});
}




