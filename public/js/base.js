var base_url = window.location.origin;
var TIMEOUT = 500;
var base ={

	validate_password:function(pwd,confirm_pwd){	
		var result = false;
		if(pwd.value != confirm_pwd.value ){
			confirm_pwd.setCustomValidity("Xác nhận mật khẩu chưa đúng.");			
		}else{					
			confirm_pwd.setCustomValidity('');
			result = !result;
		}		
		return result;

	},
	register:function(){
		var form = jQuery('#form-register');
		/*var pwd = form.find("input[name='password']");*/
		var email = form.find("input[name='email']");
		var name = form.find("input[name='in_game']");
		var token = form.find("input[name='_token']");
		var aler_t = form.find('.alert');
		var submit = form.find("button[type='submit']");
		var message = aler_t.find('span');
		var pwd = form.find("input[name='password']");
		var confirm_pwd = form.find("input[name='retype_password']");

		form.validate({
			errorElement: 'span', 
            errorClass: 'block-error',	
            highlight: function(element) {
		        jQuery(element).parent('div').addClass('has-error');
		    },
		    unhighlight: function(element) {
		        jQuery(element).parent('div').removeClass('has-error');
		    }	,			
			rules:{
				email: {
					required:true,
					email:true,
					maxlength:255
				},
				in_game:{
					required:true,
					maxlength:255
				},
				password:{
					required:true,
					minlength:6,
					maxlength:255
				},
				retype_password:{
					required:true,					
					equalTo:'#repassword'
				} 
			},
			messages:{
				email: "Định dạng email chưa đúng!",
				in_game:{
					required:"Hãy nhập chính xác tên bạn sử dụng trong game. Điều này sẽ giúp bạn nhanh chóng tìm được đồng đội phù hợp.",
					maxlength:"Tên không chính xác."
				},
				password:{
					required:"Chưa nhập mật khẩu!",
					minlength:"Mật khẩu cần có it nhất 6 ký tự!",
					maxlength:"Mật khẩu quá dài!"
				},
				retype_password:{
					required:"Chưa xác nhận mật khẩu!",					
					equalTo:"Xác nhận mật khẩu chưa chính xác!"
				},

			},
			submitHandler:function(form){				
				jQuery.ajax({
					url:base_url + '/register',
					type:'POST',
					data:{
						email:email.val(),
						name:name.val(),
						password:pwd.val(),
						_token:token.val()
					},	
					beforeSend:function(){
						submit.button('loading');
					},			
					error:function(){
						submit.button('reset');
						aler_t.removeClass('alert-success');
						aler_t.addClass('alert-danger');	
						message.html("<strong>Loi roi!</strong> Lỗi chưa xác định.");

					},
					success:function(data){
						data = jQuery.parseJSON(data);
						submit.button('reset');
						aler_t.removeClass('alert-success');
						aler_t.removeClass('alert-danger');
						if(data.code == 100){
							switch(data.status){
								case "success":
								aler_t.addClass('alert-success');							
								message.html("<strong>Đăng kí thành công!</strong>. Bạn có thể đăng nhập ngay để tìm kiếm đồng đội của mình. Good luck!");
								break;

								case "fails":
								aler_t.addClass('alert-danger');	
								message.html("<strong>Lỗi rồi!</strong> Hãy kiểm tra lại các thông tin của bạn và thử lại.");
								break;

								case "pass_required":
								aler_t.addClass('alert-danger');	
								message.html("<strong>Lỗi rồi!</strong> Bạn chưa nhập mật khẩu");
								break;

								case "user_exist":
								aler_t.addClass('alert-danger');	
								message.html("<strong>Lỗi rồi!</strong> Email bạn đăng kí đã tồn tại.")
								break;
							}

							aler_t.show();

						}						
					}
				});
				
				return false;
			}
		});
		
	},

	login:function(){
		form_login = jQuery('#form-login');
		email = form_login.find("input[name='email']");
		password = form_login.find("input[name='password']");
		submit = form_login.find("button[type='submit']");
		token = form_login.find("input[name='_token']");
		aler_t = form_login.find(".alert");
		message = aler_t.find('span');

		form_login.submit(function(e){
			e.preventDefault();		
			jQuery.ajax({
				type:"POST",
				url:base_url + '/login',
				data:{
					email:email.val(),
					password:password.val(),
					_token:token.val()
				},
				beforeSend:function(){
					submit.button('loading');
				},
				error:function(){
					submit.button('reset');
					message.html('<strong>Lỗi rồi!</strong> Lỗi chưa xác định.');
					aler_t.show();
				},
				success:function(data){					
					submit.button('reset');
					data = jQuery.parseJSON(data);
					if(data.code == 100){
						switch(data.status){
							case "success":
							//window.location.href = base_url + '/'
							location.reload();
							break;
							case "fails":
							aler_t.show();							
							break;
							case "wrong_password":
							message.html('<strong>Lỗi rồi!</strong> Sai mật khẩu.');
							aler_t.show();
							break;							
							case "user_not_exist":
							message.html('<strong>Lỗi rồi!</strong> Email này chưa được đăng kí.');
							aler_t.show();
							break;

							case "suspended":
							message.html('<strong>Lỗi rồi!</strong> Bạn tạm thời không thể sử dụng tài khoản này do nhập sai mật khẩu quá nhiều.');
							aler_t.show();
							break;

							case "banded":
							message.html('<strong>Lỗi rồi!</strong> Bạn tạm thời không thể sử dụng tài khoản này do có những hành vi không tốt.');
							aler_t.show();
							break;
						}
					}						
					
				}

			});;
		});
		
	},

	notice_handler:function(li,data){	
		jQuery.ajax({
			url:base_url + '/notifications/handler/accept',
			type:'GET',
			data:{_trigger_id:data.trigger_id,_notice_id:data.notice_id},
			success:function(result){
				result = jQuery.parseJSON(result);
				if(result.code = 102 && result.status =='success'){					
					li.fadeOut(300,function(){jQuery(this).remove()});
				}
			}
		});		
	},

	

	//Hien thi danh sach thong bao.
	show_list_notification:function(){
		jQuery('#ynotifications').on('show.bs.dropdown',function(){	
			dropdown_notice = jQuery(this);				
			dropdown_notice.find('.count').remove();	
			jQuery.ajax({
				url:base_url + '/notifications/read',
				type:'GET',
				beforeSend:function(){
					dropdown_notice.find('.dd-content')
						.html(jQuery('<div>')
							.css('text-align','center')							
							.html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>'));
				},
				success:function(data){							

					data = jQuery.parseJSON(data);
					function delete_notice(notice_id){						
						jQuery.ajax({
							url:base_url + '/notifications/delete',
							type:'GET',
							data:{_notice_id:notice_id},
							complete:function(result){
								console.log(result);
							}				
						});
					}

					if(data.length > 0){

						var ul = jQuery('<ul>');
						for(i=0; i < data.length ;i++){	
							var id = data[i].id;	
							var trigger_id = data[i].trigger_id;	
							var trigger_name = data[i].trigger_name;
							var trigger_alias = data[i].trigger_alias;						
							
							switch(parseInt(data[i].notice_id)){
								case 0: //Thong bao cap nhat ho so								
									img = jQuery('<img>',{
										src:'/images/profileIcon778.jpg'
									});

									a = jQuery('<span>',{
										html:'<strong>Cập nhật hồ sơ ngay</strong> để tìm được những người đồng đội phù hợp.'
									});

									btn_update_profile = jQuery('<button>').addClass('btn btn-primary notice-handler').text('cập nhật ngay').click(function(){
										delete_notice(id);
										window.location.replace('/settings');

									});								
					
									btn_deny_update = jQuery('<button>')
													.addClass('btn btn-default btn-deny')
													.text('để sau')
													.click(function(){	
														delete_notice(id);
														jQuery(this).closest('li')
														.fadeOut(500,function(){jQuery(this).remove()});
													});

									div = jQuery('<div>').addClass('ccc').append(a,jQuery('<div>').append(btn_update_profile,btn_deny_update));

									li = jQuery('<li>').append(img,div);
								break;

								case 1: //Thong bao co nguoi de nghi choi cung	

									img = jQuery('<img>',{
										src:'/images/profileIcon778.jpg'
									});

									a = jQuery('<a>',{
										href:'/summoner/' + trigger_alias,
										text:trigger_name							
									}).add('<span> đã đề nghị chơi cùng bạn.</span>');

									btn_accept_offer = jQuery('<button>').addClass('btn btn-primary').text('chấp nhận').click(function(){
										jQuery.ajax({
											url:base_url + '/notifications/handler/accept',
											type:'GET',
											data:{_trigger_id:trigger_id,_notice_id:id},
											success:function(result){
												console.log(result);
											}
										});
										jQuery(this).closest('li')
										.fadeOut(500,function(){jQuery(this).remove()});
									});
									
									
									btn_deny_offer = jQuery('<button>')
													.addClass('btn btn-default btn-deny')
													.text('từ chối')
													.click(function(){	
														delete_notice(id);												
														jQuery(this).closest('li')
														.fadeOut(500,function(){jQuery(this).remove()});
													});

									div = jQuery('<div>').addClass('ccc').append(a,jQuery('<div>').append(btn_accept_offer,btn_deny_offer));		

									li = jQuery('<li>').append(img,div);

									btn_accept_offer.click(function(){									
										base.notice_handler(
											li,
											{trigger_id:trigger_id,notice_id:id})
									});
								break;

								case 2:									
									img = jQuery('<img>',{
										src:'/images/profileIcon778.jpg'
									});

									a = jQuery('<a>',{
										href:'/summoner/' + trigger_alias,
										text:trigger_name
									}).add('<span> đã chấp nhân đề nghị của bạn.</span>');

									btn_send_now = jQuery('<button>',{									
										class:'btn btn-warning',
										html: '<i class="fa fa-envelope" aria-hidden="true"></i> Nhắn tin ngay.',
									}).click(function(){
										delete_notice(id);
										window.location.replace('/messages/detail/'+ trigger_alias);
									});

									btn_send_after = jQuery('<button>')
													.addClass('btn btn-default btn-deny')
													.text('để sau')
													.click(function(){	
														delete_notice(id);												
														jQuery(this).closest('li')
														.fadeOut(500,function(){jQuery(this).remove()});
													});

									ccc = jQuery('<div>').addClass('ccc').append(a,jQuery('<div>').append(btn_send_now,btn_send_after));
									li = jQuery('<li>').append(img,ccc);
									
								break;

								default:
									li = jQuery('<li>').text('Error service');
									break;
								
							}

							ul.append(li);

						}

						dropdown_notice.find('.dd-content').html(ul);
					}		
					else{
						dropdown_notice.find('.dd-content').html('<h5>Không có thông báo nào.</h5>').css('text-align','center');
					}			
					
				}				
			});
			

		});
	},

	getNotice:function(){
		setInterval(function(){
			jQuery.ajax({
				url:base_url + '/get-notices',
				method:'GET',
				success:function(data){
					data = jQuery.parseJSON(data);
					if(data.notice!=0){
						jQuery('#ynotifications').find('.ynotice').prepend(
						jQuery('<span>').addClass('count').text(data.notice)
						);
					}

					if(data.messages!=0){
						jQuery('#ymessages').prepend(jQuery('<span>').addClass('count').text(data.messages));
					}
					
				}
			});
		},10000);
	},

	//Emotion Chat

	show_list_emotion:function(){
		jQuery('#btn-emotion').click(function(){
			jQuery('#emotion-table').toggleClass('toggle');
		});
	}	
	
}
jQuery(document).ready(function(){	
	jQuery('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
	jQuery(document).on('click', '.dropdown .dropdown-menu', function (e) {
	  e.stopPropagation();
	});
	base.register();
	base.login();
	base.show_list_notification();	
	base.show_list_emotion();
	
	if(user_id){				
		base.getNotice();	  
	}	
});

