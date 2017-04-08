var COM ={
	user_action:function(){		
		jQuery('.user-action').on('click',function(e){				
			var ac = jQuery(this).attr('data-alias');
			if(user_id==0){
				jQuery('#modal-login').modal('show');
			}	else{				
				window.location.href = base_url + '/messages/detail/' + ac;
			}




			/*if(btn.data('sent')){
				console.log('sent');
				return;
			}

			switch (ac){
				case 1:{
					var uid = btn.data('uid');
					jQuery.ajax({
						type:"GET",
						url:base_url + '/friend-ship',
						data:{_action:ac,_uid:uid},
						success:function(data){
							response = JSON.parse(data);
							if(response.code == 101 && response.status == 'success'){
								btn.attr('data-original-title','Đã gửi đề nghị');
								btn.html('<i class="fa fa-check-circle" aria-hidden="true"></i> Đã mời...').addClass('pendding');
								btn.data('sent',true);
							}	

							if(response.code ==101 && response.status == 'false' && response.reason == 'null_login'){
								jQuery('#modal-login').modal('show');
							}												
						}
					});	
					break;
				}				
			}		*/	
		});
	},

	accept_offer:function(){
		jQuery('.accept-offerd').on('click',function(){
			_this = jQuery(this);
			jQuery.ajax({
				url:base_url + '/notifications/handler/accept',
				type:'GET',
				data:{_trigger_id:jQuery(this).data('triggerid')},
				success:function(result){
					_this.closest('div')
						.html(jQuery('<a>',{
							href:"/messages/detail/" + _this.data('alias'),
							class:'btn btn-action',
							html:'<i class="fa fa-envelope" aria-hidden="true"></i> Nhắn tin'
					}));
				}
			});
		});
	},

	show_hide_filter:function(){			
		jQuery('#_btnsearch').click(function(){			
			jQuery('#wrapper').toggleClass('toggle');		
			if(jQuery(this).find('i').hasClass('fa-search')){				
				jQuery(this).html('<i class="fa fa-times" aria-hidden="true"></i>').css('color','#fff').attr('data-original-title','Đóng');
			}else{				
				jQuery(this).html('<i class="fa fa-search" aria-hidden="true"></i>').css('color','').attr('data-original-title','Tìm kiếm');
			}
			
		});
	}

}

jQuery(document).ready(function(){
	COM.user_action();	
	COM.accept_offer();	
	COM.show_hide_filter();
});
