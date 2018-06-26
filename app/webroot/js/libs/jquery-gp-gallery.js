(function($) {
  $.fn.gpGallery = function(selector, options) {
    var $settings = {
        is_first_big: true,
        row_min_height: 180,
        row_max_height: 250,
        row_max_width: null,
        gutter: 15
    };
    if (options) {
        $.extend($settings, options);
    }
    function getWidthForBucket(bucket, extra) {
        var width = 180;
        return width;
    }
    return this.each(function() {
        var $container = $(this);
        var max_bucket_width = $settings.row_max_width || $container.width();
        var buckets = [],
            last_bucket = {
                items: [],
                width: 0,
                height: 0
            };
		var tempWidth = 0;
        $container.find(selector).each(function() {
            var $this = $(this);
            var $pic = $this;
            if ($pic[0].nodeName.toUpperCase() != 'IMG') {
                $pic = $pic.find('img');
            } else {
                $this = $pic.parents('.gp-gallery-hover');
            }
            if (!$pic.length) return;
            $this.css({width: 'auto', position: 'relative'});
            var item = {
                pic: $pic,
                container: $this,
                original_height: 287,
                original_width: 352
            };
            item.aspect = item.original_width / item.original_height;
            item.scale = $settings.row_min_height / item.original_height;
			item.width = 195;
			item.height = 144;
            var new_bucket_width = getWidthForBucket(last_bucket.items, item);
            if (new_bucket_width > max_bucket_width) {
                buckets.push(last_bucket);
                last_bucket = {
                    items: [],
                    width: 0,
                    height: 0
                };
            }
            last_bucket.items.push(item);
        });
        buckets.push(last_bucket);
        last_bucket.last = true;

        $.each(buckets, function(idx, bucket) {
            if (!bucket.last) {
                bucket.scale = (max_bucket_width - (bucket.items.length - 1) * $settings.gutter) / getWidthForBucket(bucket.items);
            }
            var $last_item;

            $.each(bucket.items, function(idx2, item) {
                if (bucket.scale) {
                    item.width = Math.round(item.width * bucket.scale);
                    item.height = Math.round(item.height * bucket.scale);
                }
                var pic = item.pic,
                    container = item.container;
                $last_item = item;

                pic.css({
                    height: item.height+"px",
                    width: item.width+"px",
					marginBottom: (parseInt($settings.gutter) + 16) + 'px'
                });
				pic.parents('.picture-img').css({
                    height: item.height+"px",
                    width: item.width+"px"
                });
				var margin_top = $settings.gutter;
				item.container.css({
                    height: item.height+"px",
                    width: item.width+"px",
                    marginTop:  margin_top+ 'px',
					marginBottom: '30px'
                });
                if (idx2 > 0) {
					var marginLeft = '47px';
					if (idx2%$settings.column == 0) {
						var marginLeft = '0px'
					}
                    item.container.css({
                        marginLeft: marginLeft
                    });
                } else {
                    item.container.css({
                        clear: 'left'
                    });
                }
                container.is_hover = null;
                container.hover(function() {
                    pic.parents('.picture-img').stop().addClass('gp-gallery-picture-hover');
                    container.addClass('gp-gallery-hover');
                    if (item.original_height > item.height && item.original_width > item.width) {
                        container.is_hover = setTimeout(function() {
                            pic.parents('.picture-img').removeClass('gp-gallery-picture-hover');
                            pic.parents('.picture-img').addClass('gp-gallery-picture-zoom');
                            if (container.is_hover) {
// rajesh_059at09 // 2013-01-04 // Minor "horizontal" adjustment for images so that images don't go off the screen...
                                var t_marginLeft;
// rajesh_059a509 // 2013-04-22 // Fixed pic.get(0).offsetParent.offsetLeft with container[0].offsetLeft as it was always returning -6 lately. Strange, inspecting reveals correct value.
                                if (container[0].offsetLeft + item.width + (item.original_width - item.width) / 2 > document.body.offsetWidth) { // off right?
                                    t_marginLeft = container[0].offsetLeft + item.width + (item.original_width - item.width) / 2 - document.body.offsetWidth + (item.original_width - item.width) / 2;
                               } else if ((item.original_width - item.width) / 2 > container[0].offsetLeft) { // off left?
                                    t_marginLeft = container[0].offsetLeft;
                                } else {
                                    t_marginLeft = (item.original_width - item.width) / 2;
                                }
// <--
								pic.parents('.picture-img').animate({
                                    marginTop: '-' + (item.original_height - item.height)/2 + 'px',
									marginLeft: '-' + t_marginLeft + 'px',
                                    width: item.original_width + 'px',
                                    height: (item.original_height ) + 'px'
                                }, 100);
								pic.parents('.picture-img').css("z-index","999999");
                                pic.parents('.entry-img-block').css("z-index","999999");
                                pic.css("z-index","999999");
								
// hariharan_194ac11 // 2014-03-27 //	// change audio resource iframe width and height
								var iframe_link = pic.parents('.picture-img').find('a.js-iframe-link');
								if(typeof(iframe_link) != 'undefined'){
									iframe_link.css({
										height: item.original_height+"px",
										width: item.original_width+"px"
									});
								}
								
								var iframe = pic.parents('.picture-img').find('iframe');
								if(typeof(iframe) != 'undefined'){
									iframe.css({
										height: item.original_height+"px",
										width: item.original_width+"px"
									});
								}
								
								
                                pic.attr('src', pic.metadata().zoom_image_url);
								pic.stop().animate({
									marginLeft: '-' + t_marginLeft + 'px',
                                    width: item.original_width + 'px',
                                    height: item.original_height + 'px'
                                }, 100, function() {
									var captionHeight = item.original_height + container.find('.caption').height();
									container.find('.caption').slideDown();
									pic.parents('.picture-img').animate({
										height: captionHeight + 'px'
									}, 200);
								});
                            }
                        }, 350);
                    }
                }, function() {
					container.find('.caption').hide();
                    if (container.is_hover) {
                        clearTimeout(container.is_hover);
                        container.is_hover = null;
                    }
                    if (item.original_height > item.height && item.original_width > item.width && pic.parents('.picture-img').hasClass('gp-gallery-picture-zoom')) {
						pic.stop().animate({
                            width: item.width + 'px',
                            height: item.height + 'px'
                        },100);
                        pic.parents('.picture-img').stop().animate({
                            marginTop: '-6px',
                            marginLeft: '-6px',
                            width: item.width + 'px',
                            height: item.height + 'px'
                        }, 100, function() {
                            container.removeClass('gp-gallery-hover');
							pic.parents('.picture-img').css("z-index","999");
                            pic.parents('.entry-img-block').css("z-index","999");
// hariharan_194ac11 // 2014-03-27 //	// change audio resource iframe width and height
							var iframe_link = pic.parents('.picture-img').find('a.js-iframe-link');
							if(typeof(iframe_link) != 'undefined'){
								iframe_link.css({
									height: item.height+"px",
									width: item.width+"px"
								});
							}
							var iframe = pic.parents('.picture-img').find('iframe');
							if(typeof(iframe) != 'undefined'){
								iframe.css({
									height: item.height+"px",
									width: item.width+"px"
								});
							}
							pic.css("z-index","999");
                            pic.parents('.picture-img').removeClass('gp-gallery-picture-hover').removeClass('gp-gallery-picture-zoom').css({
                                margin: ''
                            });
                        });
                    } else {
                        container.removeClass('gp-gallery-hover');
                        pic.parents('.picture-img').removeClass('gp-gallery-picture-hover').removeClass('gp-gallery-picture-zoom');
                    }
                });
            });
			$('.caption').css('min-height', '70px');
            if (!bucket.last && $last_item) {
                $last_item.width = $last_item.width + max_bucket_width - getWidthForBucket(bucket.items);
                $last_item.pic.parents('.picture-img').css({
                    width: $last_item.width + 'px'
                });
				$last_item.pic.css({
                    width: $last_item.width + 'px'
                });

            }
        });
    });
  };
})(jQuery);