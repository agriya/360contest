jQuery(document).ready(function($) {
	$('body').delegate('.js-show-details', 'click', function() {
		$this=$(this);
		classes = $this.attr('class');
        classes = classes.split(' ');
		if ($.inArray('down-arrow', classes) != -1) {
			$this.removeClass('down-arrow');
			$this.addClass('up-arrow');
		}
		else{
			$this.removeClass('up-arrow');
			$this.addClass('down-arrow');
		}
		$('.' + $this.attr('id')).toggle();
	});
	$('body').delegate('.js-ajax-link', 'click', function() {
        $this = $(this);
        $parent = $this.parent();
        $parent.block();
        $.get($this.attr('href'), function(data) {
            $('.js-response').append(data);
            $this.hide();
            $parent.unblock();
        });
        return false;
    });
	$('body').delegate('.js-generate', 'click', function(event) {
            return window.confirm(__l('Are you sure you want to generate actions?'));
    });
});