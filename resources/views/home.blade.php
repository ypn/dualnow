<?php 
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
?>
@extends('master')
@section('meta')
<title>Dual rank lien minh | Tìm đồng đội uy tín leo xếp hạng liên minh</title>	
<meta name="keywords" content="dual rank lien minh,dual rank lol, leo xep hang lol, thoat hell elo lien minh huyen thoai,tre trau lol">
<meta name="description" content="Hỗ trợ tìm đồng đội phù hợp với bạn một cách nhanh nhất để thoát khỏi hell elo, leo lên thứ hạng mong muốn dễ dàng dựa vào năng lực của chính bản thân">
<meta name="geo.region" content="VN" />
<meta name="geo.position" content="14.058324;108.277199" />
<meta name="ICBM" content="14.058324, 108.277199" />
<meta name="dc.language" content="vi-VN">
@endsection
@section('style')
<link rel="stylesheet" type="text/css" href="/css/home.css">
@endsection
@section('script')
<script type="text/javascript" src="/js/communicate.js"></script>
<script type="text/javascript">
	jQuery(window).on('scroll',function(){
		var fromTop = jQuery(this).scrollTop();
		jQuery('header').toggleClass('fixed',(fromTop > 100));
	});
</script>
@endsection
@section('content')
<main>
	<div class="container">		
		<div style="margin-bottom: 10px;display: inline-block;">
			<div class="fb-like" data-href="https://www.facebook.com/Li%C3%AAn-minh-l%C3%A0nh-m%E1%BA%A1nh-352482295137384/" data-layout="standard" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
		</div>	
		<div id="wrapper">
			<div id="_filter" style="background:#000;color: #fff;">
				<h3 style="background: #8a1b0f;padding: 5px;">Tìm người chơi</h3>			
				<form action="filter" method="GET">		

				<div style="padding: 10px;">
					<div class="form-group">
					<label for="rnak" style="font-weight: normal;">Xếp hạng</label>		
						<select id="rnak" name="rank" class="form-control">
							<option value="0" selected disabled>Chọn</option>						
							@foreach(config('constants.group_ranks') as $key=>$value)			
								<optgroup label="{{$key}}">
									@foreach($value as $v)
									<option {{Input::get('rank') == $v ? 'selected' :''}} value="{{$v}}">{{config('constants.ranks')[$v]}}</option>
									@endforeach
								</optgroup>
							@endforeach	
						</select>
					</div>

					<div class="form-group">
					<label for="rnak" style="font-weight: normal;">Tuổi</label>		
						<select class="form-control" name="age">		
							<option value="0" selected disabled>Chọn</option>				
							@for($i=10;$i<40;$i ++))			
								<option value="{{$i}}" {{Input::get('age') == $i ? 'selected' : ''}}>{{$i}}</option>		
							@endfor	
						</select>
					</div>				

					<div class="form-group">
					<label for="rnak" style="font-weight: normal;">Phong cách chơi</label>		
						<div class="checkbox">
							@foreach(config('constants.styles_of_player') as $k=>$v)	
							<div class="form-control" style="background:#141414;border-radius: 3px;padding: 5px;border:none;color: #fff;margin-bottom: 5px;">		
								<label ><input {{Input::has('style') && in_array($k,Input::get('style')) ?'checked' : ''}} type="checkbox" name="style[]" value="{{$k}}">{{$v}}</label>
							</div>
							@endforeach
						</div>

					</div>


					<div class="form-group">
						<h6>Vi tri</h6>
						@foreach(config('constants.lanes') as $k=>$v)		
							<div class="checkbox" style="width:49%;background:#141414;border-radius: 3px;padding: 5px;display: inline-block;">
								<label><input {{Input::has('roles') && in_array($k,Input::get('roles')) ? 'checked' :''}} type="checkbox" name="roles[]" value="{{$k}}">{{$k}}</label>
								<span class="pull-right" style="background:url('images/lol-role.png') no-repeat 0 -{{25 * $v->offset}}px;display: inline-block;width: 25px;height: 25px;background-size: cover;"></span>
							</div>	
						
						@endforeach	
					</div>
					<div style="text-align: right;">
						<button class="btn btn-action"><i class="fa fa-search" aria-hidden="true"></i> Tìm kiếm</button>
					</div>
					</div>				
				</form>
			</div>
			<div id="list-items">
				<div style="margin-bottom: 10px;">	
					<button class="btn btn-action" id="_btnsearch" data-toggle="tooltip" trigger="hover" title="Tìm kiếm"><i class="fa fa-search" aria-hidden="true"></i></button>			
					<form action="/" method="POST" style="display: inline-block;">					
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						@if(Input::has('rank'))
						<input type="hidden" name="rank" value="{{Input::get('rank')}}">
						@endif
						@if(Input::has('age'))
						<input type="hidden" name= "age" value="{{Input::get('age')}}">
						@endif
						@if(Input::has('style'))
						@foreach(Input::get('style') as $st)
						<input type="hidden" name="style[]" value="{{$st}}">
						@endforeach
						@endif
						@if(Input::has('roles'))
						@foreach(Input::get('roles') as $vl)
						<input type="hidden" name="roles[]" value="{{$vl}}">
						@endforeach
						@endif
						<button name="show" value="0" class="btn btn-action {{Session::get('show')?'' :'atv'}}" data-toggle="tooltip" title="Chi tiết"><i class="fa fa-th" aria-hidden="true"></i></button>
						<button name="show" value="1" class="btn btn-action {{Session::get('show')?'atv' :''}}" data-toggle="tooltip" title="Thu gọn"><i class="fa fa-list" aria-hidden="true"></i></button>
					</form>	
				</div>	
				@if(Session::get('show'))
				@include('summoner_display_grid')
				@else
				@include('summoner_display_list')
				@endif
			</div>
		</div>

		<div class="pull-right">{{ $summoners->links() }}</div>
	</div>
</main>
@endsection
