@extends('master')
@section('style')
<link rel="stylesheet" type="text/css" href="/css/home.css">
@endsection
@section('script')
<script type="text/javascript" src="js/communicate.js"></script>
@endsection
@section('content')
<main>
	<div class="container">	
		<div style="text-align: center;">
			<img width="430" height="252" src="images/gg.PNG"/>
		</div>
		<div id="list-summonners">
			<table class="table">
				<thead>
					<tr>
						<th></th>
						<th>Tên</th>
						<th>Xếp hạng</th>
						<th>Vị trí</th>
						<th>Yêu cầu đồng đội</th>
						<th>Trạng thái</th>
						<th>Hành động</th>
					</tr>
				</thead>
				<tbody>

					@foreach($summoners as $k => $v)
					<tr>
						<td><img class="rank-avatar" src="images/diamond_1.png"></td>
						<td><a href="#" class="summon-name">{{$v->name}}</a></td>
						<td>{{$v->rank}}</td>
						<td>Duong giua</td>
						<td>Chua cap nhat</td>
						<td>1 h truoc</td>						
						<td>							
							@if(!isset($v->friend_ship))
							<a href="#" class="btn btn-primary user-action">Mời chơi</a>
							@else
							<?php
								switch ($v->friend_ship) {							

									case 0:
									?>
									@if($v->user_send_action === Sentry::getUser()->id)
									<button class="btn btn-primary user-action">Da gui de nghi</button> 
									@elseif($v->user_send_action === $v->id)
									<button data-action="1" data-uid="{{$v->id}}" class="btn btn-primary user-action">Chap nhan de nghi</button>
									@else
									<a href="" class="btn btn-primary user-action">Moi choi</a>
									@endif
									<?php	
										break;

									case 1:
									?>
									<a href="/messages/detail/{{$v->alias}}" class="btn btn-primary user-action">Nhan tin</a>
									<?php	
										break;
									
									default:
									?>
										<a href="#" class="btn btn-primary user-action">Mời chơi</a>
									<?php	
										break;
								}
							?>							
							@endif
							<a href="/summoner/{{$v->alias}}" class="btn btn-success">Chi tiết</a>
							<a target="_blank" href="http://lienminhsamsoi.vn/profile?name=15November%C3%9D&section=history" class="btn btn-info">Lịch sử</a>
						</td>						
					</tr>	
					@endforeach			
				</tbody>
			</table>
		</div>
	</div>
</main>
@endsection