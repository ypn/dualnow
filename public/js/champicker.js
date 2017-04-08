var buff = [];//selected champs in lane;
var	obj;//selected lane;
var pop = jQuery('#champs-picker');
var picker = {
	champs : jQuery('#champs-picker .__champ'),	

	//Mo modal khi user click vao checkbox.
	initialize:function(){
		var op = jQuery("#op input[type='checkbox']");					
		op.click(function(){
			obj = jQuery(this);	
			if(obj.is(':checked')){		
				pop.modal({backdrop: 'static', keyboard: false});			
				picker.open_modal(obj);	
						
			}
			else{
				obj.prop("checked",true);
				jQuery('#dialog-confirm').dialog({
					resizable:false,
					height:'auto',
					width:400,
					modal: true,
				    buttons: {
				        "Cap nhat": function() {
				          	jQuery( this ).dialog( "close" );
				          	pop.modal({backdrop: 'static', keyboard: false});
				          	picker.open_modal(obj);
				        },
				        "Huy bo":function(){
				        	obj.prop("checked",false);
				        	obj.val(JSON.stringify([]));
				        	jQuery(this).dialog("close");	
				        	jQuery(obj).parents('li').find('.selected').remove();			        	
				        },
				        "Dong": function() {
				          	jQuery( this ).dialog( "close" );				          	
				        }
				    }

				});
			}
		});
	},

	//Hightlight selected champions.
	open_modal:function(ob){		
		if(ob.val()!="[]"){
			buff = JSON.parse(ob.val());			
			for(i = 0 ;i < buff.length ; i++){				
				$a = jQuery('#champs-picker').find(".__champ[data-index='" + buff[i]+"']")
					.data('selected',true)
					.css('border','3px solid red');

			}	



		}
	},

	/*When user click to champion icon
	 *Hightlight border of icon
	 *Add champs selected to list of respectively lane 
	 */
	selected:function(){
		champs = picker.champs;	
		champs.on('click',function(){	
			t = jQuery(this);	
			if(!t.data('selected')){
				t.data('selected',true);				
				buff.push(t.data('index'))		
				t.css('border','3px solid red');
			}else{
				t.data('selected',false);				
				buff = jQuery.grep(buff,function(value){					
					return value != t.data('index');
				});

				jQuery(this).css('border','');
			}	
		});
	},

	//Xac nhan danh sach tuong duoc chon truoc khi dong modal.
	verify:function(){
		var btn_verify =jQuery('#champs-picker #btn-verify');	
		var btn_cancel = jQuery("#champs-picker #btn-cancel");
		btn_cancel.click(function(){pop.modal('hide')});	
		btn_verify.click(function(){			
			_li = jQuery(obj).closest('li');
			_li.find('.selected').remove();
			_list_name = jQuery('<ul>')
			for(i = 0; i< buff.length ; i++){
				_obj = jQuery.grep(list_champs,function(e){
					return e.id == buff[i];
				});			

				_c_name = jQuery('<li>').html(
					jQuery('<span>').addClass('label label-default').html(_obj[0].name)
				);

				_list_name.append(_c_name);
			}	

			jQuery(obj).val(JSON.stringify(buff));

			_li.append(jQuery('<div>').addClass('right-info selected').html(_list_name));			

			pop.modal('hide');

			
		});

	},

	//Them bo loc khi search tuong theo ten.
	filter:function(){
		var input,filter,champs;
		input = jQuery('#search-champ');	
		champs = picker.champs;			
		input.keyup(function(){
			filter = input.val().toUpperCase();		
			for(i=0;i< champs.length ; i++){				
				if(jQuery(champs[i]).data('original-title').toUpperCase().indexOf(filter) > -1){
					champs[i].style.display ="inline-block";
				}else{					
					champs[i].style.display = "none";
				}
			}
		});		
	}
}

jQuery(document).ready(function(){	
	picker.initialize();
	picker.filter();
	picker.selected();
	picker.verify();	
	pop.on('hidden.bs.modal',function(){		
		if(jQuery(obj).val() =="[]"){	
			jQuery(obj).parents('li').find('.selected').remove();		
			jQuery(obj).prop('checked', false);				
		}
		
	});

	pop.on('show.bs.modal',function(){

		/*Reset modal when open*/
		buff = [];
		picker.champs.each(function(){
			jQuery(this).data('selected',false);
			jQuery(this).css('border','');
		});		

	});
});