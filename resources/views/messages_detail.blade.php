@extends('master')
@section('style')
<link rel="stylesheet" type="text/css" href="/css/messages.css">
@endsection

@section('content')
<main>
	<div class="container">
		@include('menu_message')
		<div class="col-md-9">
			@if(!empty($receiver))
			<div class="conversation">
				
				@if(Session::has('messages'))
					<?php 						
						switch (Session::get('messages')) {
							case 'success':
							?>
								<div class="alert alert-success alert-dismisable">
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									<strong>Gửi thành công!</strong> Tin nhắn của bạn được gửi đến cho {{$receiver->name}}
								</div>
							<?php								
								break;
							case 'send_contact_first':
							?>
								<div class="alert alert-danger alert-dismisable">
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									<strong>Không gửi được!</strong> Bạn nên gửi đề nghị chơi tới <strong>{{$receiver->name}}</strong> trước khi gửi tin nhắn cho anh ấy.
									<div>
										Bạn có muốn gửi đề nghị cùng chơi tới <strong>{{$receiver->name}}</strong> ?
										<div>
											<button class="btn btn-primary">Gửi ngay</button>		
											<button class="btn btn-default" data-dismiss="alert">Để sau</button>	
										</div>	
									</div>												
								</div>
							<?php								
								break;
							case 'failure':
							?>
								<div class="alert alert-danger alert-dismisable">
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									<strong>Không gửi được!</strong> Nội dung tin nhắn không hợp lệ.
								</div>
							<?php								
								break;							
						}

					?>
				@endif

				<div class="entry-message">
					<h4><i class="fa fa-envelope" aria-hidden="true"></i> Gửi tin nhắn cho {{$receiver->name}}</h4>
					<form method="POST" action="/send_message">
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<input type="hidden" name="receiver" value="{{$receiver->alias}}">
						<textarea class="form-control" autofocus name="content"></textarea>
						<button class="btn btn-primary"><i class="fa fa-paper-plane-o" aria-hidden="true"></i>  Gửi</button>
					</form>
				</div>
				<div class="list-message">
					@if(!empty(json_decode($messages)))
					<ul>
						@foreach($messages as $k=>$v)
						<li>
							<div class="mss {{$v->author_id == Sentry::getUser()->id ? 'out-mss' : 'in-mss'}}">
								<img style="border-radius: 50%;border:2px solid #ccc;" src="{{$v->avatar!=0 ? '/images/avatars/profile_icon/profileIcon14' . $v->avatar .'.jpg' : '/images/profileIcon778.jpg'}}" alt="avatar">
								<div class="mss-content" style="{{$v->author_id == Sentry::getUser()->id ? '' :'text-align: right' }}">
									<span><i class="fa fa-caret-{{$v->author_id == Sentry::getUser()->id ? 'left' : 'right'}}" aria-hidden="true"></i></span>
									<p style="text-align: left;">
										{{$v->content}}
									</p>
									<a href="/summoner/{{isset($v->sender_alias) ? $v->sender_alias : '#'}}">{{isset($v->sender_name) ? $v->sender_name : 'Không rõ'}}</a>
									<h5 style="font-style: italic;color: #aaa;">{{date('D, d-m-Y H:i a', strtotime($v->created_at))}} {{$v->author_id == Sentry::getUser()->id && $v->is_read ==1 ? '- Đã được xem' : ''}}</h5>
								</div>
							</div>
						</li>
						@endforeach							
					</ul>
					@else
					<h1>Khong co tin nhan nao</h1>
					@endif
				</div>
			</div>
			@else
			Không tìm thấy thành viên !
			@endif
		</div>
	</div>
</main>
@endsection
