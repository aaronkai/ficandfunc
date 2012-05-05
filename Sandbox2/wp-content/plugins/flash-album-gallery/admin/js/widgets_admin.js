jQuery(document).ready(function() {
	jQuery('#widgets-right .grandGalleries :checkbox').live('click',function(e){
		var inp = jQuery(e.target).parent().parent().parent().find('.grand_items_array > input');
		console.log(inp);
		var cur = jQuery(e.target).val();
		if(jQuery(this).is(':checked')){
			arr = inp.val();
			if(arr) { var del = ','; } else { arr = ''; var del = ''; }
			inp.val(arr+del+cur);
		} else {
			arr = inp.val().split(',');
			arr = jQuery.grep(arr, function(a){ return a != cur; }).join(',');
			if(arr) {
				inp.val(arr);
			} else {
				inp.val('');
			}
		}
	});
});
