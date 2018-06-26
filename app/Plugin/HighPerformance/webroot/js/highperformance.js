(function() {
	function xload(is_after_ajax) {
		if ($.cookie('_gz') != null) {
			$('.js-head-navbar').addClass('navbar-fixed-top');
			$('.js-hp-header').addClass('fixed-nav-container');
			$('.js-hp-affix-header').removeClass('project-affix-nonregister').addClass('project-affix-user');
		}
		var so = (is_after_ajax) ? ':not(.xltriggered)': '';
		$('.alcd' + so).each(function() {
			var url = '';
			if((typeof($('.alcd').metadata().cid) != 'undefined' && $('.alcd').metadata().cid !='') && (typeof($('.alcd').metadata().cuid) != 'undefined' && $('.alcd').metadata().cuid !='')) {
				var cid = $('.alcd').metadata().cid;
				var cuid = $('.alcd').metadata().cuid;
				var entry = $('.alcd').metadata().entry;
				var page = $('.alcd').metadata().page;
				var url = 'high_performances/show_contest_comments/id:'+cid+'/contest_user_id:'+cuid+'/entry:'+entry+"/page:"+page;
			} else if(typeof($('.alcd').metadata().cid) != 'undefined' && $('.alcd').metadata().cid !='') {
				var cid = $('.alcd').metadata().cid;
				var url = 'high_performances/show_contest_comments/id:'+cid;
			}
			if(url !='') {
				$.get(__cfg('path_relative') + url, function(data) {
					$('.alcd').html(data).removeClass('hide');
				});
			}	
		}).addClass('xltriggered');
	}
	$dc = jQuery(document);
	$dc.ready(function($) {
		xload(false);
	}).ajaxStop(function() {
        xload(true);
    });
})();