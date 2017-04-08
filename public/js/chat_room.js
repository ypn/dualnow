
var CHAT = {
	listen:function(){
		console.log('listenning...')
		var pusher = new Pusher('276195c331a0283e6d52', {
	      encrypted: true
	    });

	    var channel = pusher.subscribe('public-chat');
	    channel.bind('new-message', function(data) {
	    	data = jQuery.parseJSON(data.data);	   

	    	li = jQuery('<li>').addClass('chat-item').append(
	    			jQuery('<a>',{
	    				href:'#'
		    			}).append(		    				
		    				jQuery('<span>').text(data.name)
		    			),
		    		jQuery('<div>').addClass('chat-content emo').append(		    				
		    				jQuery('<p>').text(data.message)
		    			).emoticonize()

	    		);    	

	    	if(jQuery('#_chatroom').children('ul').length >0 ){	    	
	    		jQuery('#_chatroom ul').append(li);
	    	}else{	    		
	    		jQuery('#_chatroom').html(jQuery('<ul>').append(li));
	    	}
	    	
	    	jQuery('#_chatroom').scrollTop(jQuery('#_chatroom')[0].scrollHeight);
	    	jQuery('#_chat').find("input[name='entry']").val('');
	    	jQuery('#_send').button('reset');
	    	   	
	    });
	},

	chatall:function(){		
		if(user_id!=0 && jQuery('#_entry').val()!=0){
			var form = jQuery('#_chat');
			_token = form.find("input[name='_token']");
			entry = form.find("input[name='entry']");	

			jQuery.ajax({
				url: base_url +'/post-chat',
				type:'POST',
				data:{
					_token:_token.val(),
					entry:entry.val()
				},
				beforeSend:function(){				
					jQuery('#_send').button('loading');
				}
			});	
		}		
	}
};


jQuery(document).ready(function(){
	CHAT.listen();
	jQuery('#_chatroom').scrollTop(jQuery('#_chatroom')[0].scrollHeight);
	jQuery('#_entry').focus(function(){
		if(user_id==0){
			jQuery('#modal-login').modal();
		}
	});

	jQuery('#_entry').keypress(function(e){
		if(e.which == 13) {
			e.preventDefault();
	        CHAT.chatall();	
	    }
	});

	jQuery('.css-emoticon').click(function(){
		jQuery('#_entry').val(jQuery(this).text());
	});

	jQuery('#_send').click(function(){
		CHAT.chatall();		
	});	
});