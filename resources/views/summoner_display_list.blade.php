<?php use Carbon\Carbon; ?> 
<section class="masonry">
	@foreach($summoners as $summoner)
	<div class="pin-item">	
		@if(Carbon::parse($summoner->last_action)->diffInMinutes() < 2)
		    	<span class="summon-status">online</span>
		    	@else
		    	<span class="summon-status-offline">{{Carbon::parse($summoner->last_action)->diffForHumans()}}</span>	   
		    	@endif	
		<div style="padding: 10px;">
			<div class="sommoner-detail">
				<div class="__header">					
					<div class="rank-frame">
						<div class= "frame" style="background-image:url(/images/borders/border{{$summoner->border_offset}}.png);"></div>		
						<img src="{{$summoner->avatar!=0 ? '/images/avatars/profile_icon/profileIcon14' . $summoner->avatar .'.jpg' : '/images/profileIcon778.jpg'}}" alt="avatar">
					</div>
					
					<div class="main-info" style="padding-left: 10px;">
						<div>
							<h4 class="__name">{{$summoner->name}} {{$summoner->age ? '-' . $summoner->age .' tuổi' :''}}</h4>				
						</div>			

						<div>
							<h5>Rank : {{config('constants.ranks')[$summoner->rank]}}</h5>
						</div>		
						
						<div>	
							@if(!empty(unserialize($summoner->lanes)))
							@foreach(unserialize($summoner->lanes) as $key => $summoneralue)  
							<span style="width: 31px; height: 31px;content: '' ;display:inline-block;background:url('images/lol-role.png') no-repeat 0 -{{config('constants.lanes')[$key]->offset * 31}}px;background-size: cover;" data-toggle="tooltip" title="{{config('constants.lanes')[$key]->des}}"></span>	
							@endforeach
							@else
			    			<span style="font-size: 28px;color: orange;" title="chưa cập nhật" data-toggle="tooltip"><i class="fa fa-question" aria-hidden="true"></i></span>
			    	
							@endif								

						</div>						
					</div>	

				</div>
				<div style="padding-top: 10px;">
					<div class="info-item"><h5>Phong cách chơi</h5>
						<div class="info-content">
							@if(!empty(json_decode($summoner->styles)))
							@foreach($summoner->styles as $s)
							<span class="label label-success">{{config('constants.styles_of_player')[$s->style_id]}}</span>		
							@endforeach
							@else
							chưa cập nhật
							@endif
						</div>
					</div>

					<div class="info-item"><h5>Cần tìm đồng đội</h5>
						<?php 
							$teammate = array();
							if($summoner->teammate!=null && !empty(unserialize($summoner->teammate))){
								$teammate = unserialize($summoner->teammate);
							}

						?>
						@if(!empty($teammate))
						<div class="info-content">
						@foreach($teammate as $k)
							<span class="label label-primary">{{$k}}</span>						
						@endforeach
						</div>
						@else
						chua cap nhat
						@endif
					</div>

					<div class="info-item"><h5>Lời nhắn</h5>
						@if($summoner->message!=null)				
						<p class="info-content qoute">{{$summoner->message}}</p>
						@else
						<p>
						Chưa cập nhật
						</p>
						@endif
					</div>	
				</div>	

				<div class="action" style="border-top: 1px solid rgba(204,204,204,0.46);padding-top: 5px;">
				@if(Carbon::parse($summoner->last_action)->diffInMinutes() < 2)
				<marquee>Tôi đang hoạt động - Liên lạc với tôi ngay nhé!</marquee>
				@endif
		    	    
			    @if(!Sentry::check() || Sentry::check() && Sentry::getUser()->id != $summoner->id)	    	
		    	<button class="btn btn-action user-action" data-action="1" data-alias="{{$summoner->alias}}" data-toggle="tooltip" title="Nhắn tin"><i class="fa fa-envelope" aria-hidden="true"></i> Nhắn tin</button>
		    	@endif
			    
		    	<a href="/summoner/{{$summoner->alias}}" class="btn btn-action" data-toggle="tooltip" title="Xem thông tin"><i class="fa fa-eye" aria-hidden="true"></i></a> 
		    					    	
		    </div>			
			</div>
		</div>
	</div>	
	@endforeach

	
</section>
