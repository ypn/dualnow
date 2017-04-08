@extends('master')
@section('style')
<link rel="stylesheet" type="text/css" href="/css/summoner.css">
@section('script')
<script type="text/javascript" src="/js/communicate.js"></script>
@endsection
@endsection
@section('content')
<main>
	<div class="container" style="padding-top: 10px;">
		<div class="row">
			<div class="col-md-1 rank-frame">
				<div class= "frame" style="background-image:url(/images/borders/border{{$summoner->border_offset}}.png);"></div>				
				<img src="{{$summoner->avatar!=0 ? '/images/avatars/profile_icon/profileIcon14' . $summoner->avatar .'.jpg' : '/images/profileIcon778.jpg'}}" alt="avatar">
			</div>
			<div class="col-md-5 summon-info">
				<span class="summoner-name">{{$summoner->name}}</span>
				<h5>{{config('constants.ranks')[$summoner->rank]}}</h5>
				<div class="summon-contact">
					@if(!Sentry::check() || Sentry::check() && Sentry::getUser()->id != $summoner->id)	    	
			    	<button class="btn btn-warning user-action" data-action="1" data-alias="{{$summoner->alias}}" data-toggle="tooltip" title="Nhắn tin"><i class="fa fa-envelope" aria-hidden="true"></i> Nhắn tin</button>
			    	@endif	 

				    <a href="http://lienminhsamsoi.vn/profile?name={{$summoner->name}}" class="btn btn-primary" target="_blank" rel="nofollow"><i class="fa fa-line-chart" aria-hidden="true"></i> Lịch sử đấu</a> 			
				</div>
				<div class="more-info">
					<div class="more-info-item">
						<h5>Tuổi: <span style="font-weight: normal;">{{$summoner->age !=0 ? $summoner->age :'chưa cập nhật'}}</span></h5>						
					</div>		
					<div class="more-info-item">
						<h5><b>Phong cách chơi</b></h5>
						@if(!empty(json_decode($summoner->styles)))
						<ul>
							@foreach($summoner->styles as $s)
								<li><i class="fa fa-check" style="color: green;" aria-hidden="true"></i> {{config('constants.styles_of_player')[$s->style_id]}}</li>
							@endforeach
						</ul>
						@else
						Chưa cập nhật
						@endif
					</div>
					<div class="more-info-item">	
						<h5><strong>Lời nhắn</strong></h5>

						<div class="qoute-client">
							@if($summoner->message==null)
			    			<p>
			    				"Greate things in business cannot done by a person, that done by group of team."			    			
			    			</p>
			    			<span style="text-align: right;">-- Steve Job --</span>
			    			@else
			    			<p>
			    				{{$summoner->message}}	    			
			    			</p>
			    			@endif			    			
		    			</div>	    				
					</div>	
				</div>				
			</div>	
			<div class="col-md-5 pull-right">	
				<div class="y-col y-tree">
					<h4 class="tree-name">Vị trí chơi tốt nhất<h4>
					@if(!empty(unserialize($summoner->lanes)))
					<ul>
						@foreach(unserialize($summoner->lanes) as $k=>$v)					
						<li>{{config('constants.lanes')[$k]->des}}
							<ul>
								@foreach($v as $value)
								<li><div data-toggle="tooltip" data-placement="right" title="{{$list_champs->where('id',$value)->first()->name}}" style="display:inline-block;width:40px;height:40px;background: url('/images/champs/champion40.png') no-repeat 0 {{-40*$list_champs->where('id',$value)->first()->index}}px;">		
						</div></li>
								@endforeach
							</ul>
						</li>

						@endforeach
					</ul>
					@else
					<span>Chưa cập nhật</span>
					@endif
				</div>
			</div>				
		</div>
	</div>
</main>
@endsection
