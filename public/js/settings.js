var settings = {
	edit_trigger:function(){
		var edit = jQuery('#setting-table .edit');
		var cancel = jQuery('#setting-table .final-action .cancel');
		var frontend = jQuery('#setting-table .frontend');
		var backend = jQuery('#setting-table .backend');
		var td = jQuery('#setting-table .edit').parent();
		var tr = jQuery('#setting-table tr');

		edit.click(function(e){
			e.preventDefault();
			jQuery(this).parents('td').hide();			
			var f = jQuery(this).parents('tr').find('.frontend');
			var b = jQuery(this).parents('tr').find('.backend');
			var t_tr = jQuery(this).parents('tr');		

			backend.not(b).hide();
			frontend.not(f).show();			

			f.hide();
			b.show();			
			td.not(jQuery(this).parent()).show();
			jQuery('#setting-table td').removeAttr('colspan');
			tr.each(function(){
				jQuery(this).css('background','');
			});

			jQuery(this).parents('tr').find('td:nth(1)').attr('colspan','2');
			t_tr.css('background','rgba(204, 204, 204, 0.57)');

		});

		cancel.click(function(e){		

			e.preventDefault();

			var f = jQuery(this).parents('tr').find('.frontend');
			var b = jQuery(this).parents('tr').find('.backend');
			f.show();
			b.hide();
			jQuery(this).parents('tr').find('.edit').parent().show();		
			jQuery(this).parents('td').removeAttr('colspan');
			jQuery(this).parents('tr').css('background','');
		});

	}
}

jQuery(document).ready(function(){
	settings.edit_trigger();

});