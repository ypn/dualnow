var modal_body = jQuery('<div>').addClass('modal-body').html(jQuery('<p>').text('main content'));		

var modal_header = jQuery('<div>').addClass('modal-header').append(
		jQuery('<button>').attr({'type':'button','data-dismiss':'modal'}).addClass('close').html('&times;')
	);

var modal_footer = jQuery('<div>').addClass('modal-footer').html(
		jQuery('<button>').attr({'type':'button','data-dismiss':'modal'}).addClass('btn btn-primary').text('close')
	);	

var modal = jQuery('<div>').attr('role','dialog').addClass('modal fade')
		.html(
			jQuery('<div>').addClass('modal-dialog').html(
				jQuery('<div>').addClass('modal-content').append(modal_header,modal_body,modal_footer)
				)
			);	