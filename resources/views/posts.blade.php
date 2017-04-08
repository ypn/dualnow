@extends('master')
@section('style')
<link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
@endsection
@section('script')
	<script type="text/javascript">		

		jQuery(document).ready(function(){	
			

			jQuery('#infinity').click(function(){
				jQuery.ajax({
					url:base_url + '/infinity',
					type:'GET',					
					success:function(data){							
						jQuery.getScript('/js/learning/test.js',function(response){
							modal_body.children('.modal-body p').html(data);
							modal.modal();
						});
						
					}
				});
			})	;				
		})
	</script>
	<script src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script>	

	
@endsection
@section('content')
<main>
	<div class="container">
		<button class="btn btn-primary" id="infinity">infility</button>
	</div>	
	<div id="contentt"></div>
	<div class="container">
		<div class="col-md-offset-3 col-md-6">			
			<div class="post-card">
				<div class="form-group">		
					<div style="display:flex;">				
						<a class="_uavatar" href="#"  
						><img width="40" height="40" src="images/avatars/profile_icon/profileIcon1427.jpg">
						</a>

						<div style="flex-grow: 1;margin-left: 10px;">
							<textarea type="text" id="#_uentry" name="" style="width:100%;resize: none;padding: 5px;" placeholder="Ban co gi muon chia se"></textarea>								
							
							<div class="pull-right">
								<input class="btn btn-primary btn-xs" type="file">Dang</input>
							</div>


							<div class="dz-preview dz-file-preview">
  <div class="dz-details">
    <div class="dz-filename"><span data-dz-name></span></div>
    <div class="dz-size" data-dz-size></div>
    <img data-dz-thumbnail />
  </div>
  <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
  <div class="dz-success-mark"><span>✔</span></div>
  <div class="dz-error-mark"><span>✘</span></div>
  <div class="dz-error-message"><span data-dz-errormessage></span></div>
</div>
							
							
							
						</div>					
					</div>
				</div>
			</div>

			@for($i=0;$i<10;$i++)
			<div class="post-card">
				<div class="post-container">
					<div class="_pheader">
						<a class="_uavatar" href="#"><img width="40" height="40" src="images/avatars/profile_icon/profileIcon1427.jpg">
						</a>
						<div class="_uinfo">
							<a class="_uname" href="#">ˆCoreJJˆ</a>
							<div class="time">5h truoec</div>
						</div>						
					</div>					
					<div class="clearfix _pcontent">
						<div>
						Đánh liên minh chỉ vì thấy hay :v t mới chơi được khoảng 1 tháng, 10 trận đánh thì 9 trận bị chửi sp óc chó, ad ngu vl :3
						chính vì thế mà t rất muốn tập đánh để tốt hơn mà khổ nỗi nhà không có pc và phải ra net để tập đánh TvT 
						</div>
						<div class="count-interactive">
							<ul>
								<li><span>200 luot thich</span></li>
								<li><span>20 binh luan</span></li>
							</ul>						
						</div>
					</div>
					<div class="_pfooter">
						<ul class="_interactive">
							<li><a href="javascript:void(0);"><i class="fa fa-heart-o" aria-hidden="true"> Thich</i></a></li>
							<li><a href="javascript:void(0);"><i class="fa fa-comment-o" aria-hidden="true"> Binh luan</i></i></a></li>
						</ul>
					</div>
				</div>
			</div>
			@endfor
		</div>
	</div>
</main>
@endsection