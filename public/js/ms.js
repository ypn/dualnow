var MS = {
	checkAll:function(){
		jQuery('#check-all').click(function(){				
			jQuery('.check').prop('checked',jQuery(this).prop('checked'));
		});
	},

	delete_message:function(){			
		jQuery('.check').click(function(){
			count = jQuery('input:checked').not('#check-all');
			jQuery('input.check:not(:checked)').not('#check-all').parents('tr.danger ').removeClass('danger');

			if(count.length > 0){					
				count.each(function(){
					jQuery(this).parents('tr').addClass('danger');
				});			

				jQuery('#btn-delete').text('Xoa ' + count.length + ' tin da chon!');	
				jQuery('.delete-item').show();
			}else{
				jQuery('#check-all').prop('checked',false);
				jQuery('.delete-item').hide();
			}
		});

		jQuery('#btn-delete').click(function(e){					
			e.preventDefault();			
			jQuery('#form-item-message').submit();
		});
	}
}

jQuery(document).ready(function(){	
	MS.checkAll();
	MS.delete_message();
});