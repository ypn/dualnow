<?php use Carbon\Carbon; ?>
@extends('master')
@section('style')
<link rel="stylesheet" type="text/css" href="/css/jquery.cssemoticons.css">
@endsection
@section('script')
<script type="text/javascript" src="/js/pusher.min.js"></script>
<script type="text/javascript" src="/js/jquery.cssemoticons.min.js"></script>
<script type="text/javascript" src="/js/chat_room.js"></script>
<script type="text/javascript">
	jQuery('.emo').emoticonize();	
</script>
@endsection
@section('content')
<main>
	<div class="container">	
		<div class="row">				
			<div class="col-md-offset-1 col-md-10 col-md-offset-1 room-chat">	
				<div style="background: #5779a5;padding: 5px 15px;color: #fff;border-bottom: 1px solid #404ca2;">
					<h5>Giao lưu - kết bạn với người chơi khác.</h5>
				</div>			
				<div class="chat-form" id="_chatroom">
					@if(!empty($public_messages))				
					<ul>		
						@foreach($public_messages as $pm)							
						<li class="chat-item">
							<a href="summoner/{{$pm->alias}}">
								@if($pm->avatar!='')
									<img src="images/avatars/profile_icon_32/profileIcon14{{$pm->avatar}}.jpg">
								@endif						
								
								<span>{{$pm->u_name}}</span>
							</a>												
							<div class="chat-content emo">	
								<h6>{{Carbon::parse($pm->created_at)->diffForHumans()}}</h6>	
								<p>					
									{{$pm->content}}
								</p>
							</div>
						</li>	
						@endforeach		
									
					</ul>
					@else
						<h1>Chưa có tin  nhắn nào</h1>
					@endif

				</div>
				<div style="margin-top: 10px;">	 	
					<form id="_chat">				
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<div class="input-group">				
							<input type="text" name="entry" id="_entry"  class="form-control emo" style="border-radius:0;" placeholder="{{Sentry::check()?'Trò chuyện..':'Đăng nhập để trò chuyện...'}}">
							<div class="input-group-btn" id="emotion-table">
						        <button class="btn btn-default" id="btn-emotion" style="border-radius:0;" type="button"><i class="fa fa-smile-o" aria-hidden="true"></i></button>
						        <div class="emotion-list emo">				        	
						      		@include('chat_emotion')	      		
						      	</div>
					      	</div>	 
					      	<div class="input-group-btn">
								<span>
							        <button class="btn btn-primary" id="_send" style="border-radius:0;" type="button" data-loading-text="<i class='fa fa-spinner fa-spin '></i> đang gửi...">Gửi</button>
						      	</span>					      	
					      	</div> 
						</div>	
					</form>				
				</div>			
			</div>	
		</div>	
	</div>
</main>
@endsection
