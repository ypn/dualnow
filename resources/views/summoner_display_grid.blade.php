<?php use Carbon\Carbon; ?> 
<section class="masonry-grid">
@foreach($summoners as $k=>$v)	
	<div class="pin-item-grid">				 
		  <div class="card-block">
		  	<div class="card-title">

		  		@if(Carbon::parse($v->last_action)->diffInMinutes() < 2)
		    	<span class="summon-status">online</span>
		    	@else
		    	<span class="summon-status-offline">{{Carbon::parse($v->last_action)->diffForHumans()}}</span>	   
		    	@endif
		    </div>		
		    <div class="summon-rank" style="background: url('images/lol-rank.png') 0 {{
		    	config('app.rank')[$v->rank]}}px;background-size:cover;">    	
		    </div>				  
		    <div class="summon-info">
		    	<h4>{{$v->name}}</h4>
		    	<h5>{{config('constants.ranks')[$v->rank]}}</h5>
		    </div>
		    <div class="list-role">				    	
			    <ul>	
			    	@if(!empty(unserialize($v->lanes)))
			    	@foreach(unserialize($v->lanes) as $key => $value)			    	
			    	<li>
			    		<span style="background:url('images/lol-role.png') no-repeat 0 -{{config('constants.lanes')[$key]->offset * 31}}px;background-size: cover;" data-toggle="tooltip" title="{{config('constants.lanes')[$key]->des}}"></span>
			    	</li>
			    	@endforeach	

			    	@else
			    	<li>
			    		<span style="font-size: 28px;color: orange;" title="chưa cập nhật" data-toggle="tooltip"><i class="fa fa-question" aria-hidden="true"></i></span>
			    	</li>	
			    	@endif			    
			    	
			    </ul>
		    </div>
		    		   
		    <div class="action">	
		    	@if(!Sentry::check() || Sentry::check() && Sentry::getUser()->id != $v->id)		
		    	<button class="btn btn-action user-action" data-action="1" data-alias="{{$v->alias}}" data-toggle="tooltip" title="Nhắn tin"><i class="fa fa-envelope" aria-hidden="true"></i> Nhắn tin</button>
		    	@endif
			    
		    	<a href="/summoner/{{$v->alias}}" class="btn btn-action" data-toggle="tooltip" title="Xem thông tin"><i class="fa fa-eye" aria-hidden="true"></i></a> 	
		    </div>
		  </div>					  	
			
	</div>		

@endforeach
</section>
