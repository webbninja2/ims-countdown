jQuery(document).ready(function(){
    jQuery('#event_date').datetimepicker({
        minDate:'0',
        step:5,
    });

    jQuery("#title_color").spectrum({
    	showInput: true,
	    preferredFormat: "hex",
    });
    jQuery("#timer_color").spectrum({
    	showInput: true,
    	preferredFormat: "hex",
    });
    jQuery("#timer_background").spectrum({
    	showInput: true,
    	preferredFormat: "hex",
    });
    jQuery("#timer_border").spectrum({
    	showInput: true,
    	preferredFormat: "hex",
    });

    function toggleChevron(e) {
	   jQuery(e.target)
	        .prev('.panel-heading')
	        .find("i.indicator")
	        .toggleClass('glyphicon-chevron-down glyphicon-chevron-up');
	}
	jQuery('#accordion').on('hidden.bs.collapse', toggleChevron);
	jQuery('#accordion').on('shown.bs.collapse', toggleChevron);

    jQuery('.dropdown .label').click(function(){
        jQuery(this).siblings('.time-options').slideDown();
        jQuery(this).parent().siblings('.dropdown').children('.time-options').slideUp();
    });

    jQuery('.dropdown .labelvalue').click(function(){
        jQuery(this).siblings('.time-options').slideDown();
        jQuery(this).parent().siblings('.dropdown').children('.time-options').slideUp();
    });

    jQuery('.dropdown input[checked="checked"].labelvalue').siblings('.time-options').slideDown();
}); 