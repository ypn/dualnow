@extends('master')
@section('style')
<link rel="stylesheet" type="text/css" href="/css/messages.css">
@endsection
@section('script')
<script type="text/javascript" src="/js/ms.js"></script>
@endsection
@section('content')
<main>
	<div class="container">		
		<div class="row">
			@include('menu_message')
			<div class="col-md-9">
				@if(!empty(json_decode($messages)))
				<form id="form-item-message" method="POST" action="/messages/delete-inbox">
				<input type="hidden" name="_token" value="{{csrf_token()}}">	
				@if(Session::has('messages') && Session::get('messages') == 'success')			
				<div class="alert alert-success alert-dismissable">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Xoa tin thanh cong</strong></div>
				@endif
				<div class="delete-item" style="padding-bottom: 10px;display: none;"><img src="/images/bin.png"> <a href="#" id="btn-delete">Xoa tin da chon</a></div>
				<div class="dizz">								
					<table class="table">
						<thead style="font-weight: bold">
							<tr>
								<th width="5%"><input type="checkbox" class="check" id="check-all"></th>
								<th width="20%">Người gửi</th>
								<th width="55%">Tiêu đề</th>
								<th width="20%">Thời gian</th>										
							</tr>
						</thead>
						<tbody>
							@foreach($messages as $k=>$v)
							<tr class="info {{$v->is_read!=1 ? 'read' : ''}}">
								<td><input type="checkbox" name="ms[]" value="{{$v->message_id}}" class="check"></td>
								<td><a href="/summoner/{{$v->sender_alias}}">{{isset($v->sender) ? $v->sender : ''}}</a></td>
								<td>
									<a href="/messages/read/{{$v->sender_alias}}/{{Sentry::getUser()->id}}/{{$v->message_id}}"><i class="fa fa-envelope" aria-hidden="true"></i> Vào hộp thoại</a>
									<p>{{$v->content}}</p>
								</td>
								<td><i class="fa fa-clock-o" aria-hidden="true"></i> {{$v->created_at->diffForHumans()}}</td>							
							</tr>
							@endforeach
						</tbody>
					</table>				
				</div>
				</form>
				@else
				<div>Không có tin nhắn nào</div>
				@endif			
			</div>	
			sdfsdf	
		</div>
	</div>
</main>
@endsection
