@extends('master')
@section('style')
<link rel="stylesheet" href="/css/jquery-ui.min.css">
<link rel="stylesheet" type="text/css" href="/css/summoner.css">
<style type="text/css">
	#setting-table ul{
		padding: 0;
		list-style: none;
	}
	
</style>
@endsection
@section('script')
<script src="js/jquery-ui.min.js"></script>

<script type="text/javascript">	
	var list_champs = <?php echo $list_champs->toJson(); ?>;
</script>

<script type="text/javascript" src="js/settings.js"></script>
<script type="text/javascript" src="js/champicker.js"></script>
@endsection
@section('content')
<main>
	<?php
		$position = array(			
			'Đồng đoàn'=>array(1,2,3,4,5),
			'Bạc đoàn'=>array(6,7,8,9,10),
			'Vàng đoàn'=>array(11,12,13,14,15),
			'Bạch kim đoàn'=>array(16,17,18,19,20),
			'Kim cương đoàn'=>array(21,22,23,24,25),
			'Cao thủ - Thách đấu'=>array(26,27)
			);

		if(Session::has('update')){
			$ac = Session::get('update');
		}
	?>
	<!--Start modal -->	

	<div id="champs-picker" class="modal fade" role="dialog">
		<div class="modal-dialog __ydialog" style="width: 764px;">
			<div class="modal-content">
				<div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>       
		        </div>
				<div class="modal-body">
					<div class="alert alert-danger">Bạn chỉ nên chọn tối đa 5 tướng cho một đường.</div>			
					<div class="form-group">
						<input id="search-champ" style="background: url(images/searchicon.png) no-repeat;     background-position: 8px 6px;   padding: 12px 20px 12px 36px;" class="form-control" placeholder="Nhap ten tuong" />
					</div>					
					<div class="champs-grid">
						@foreach($list_champs as $champ)
						<div data-toggle="tooltip" data-index ="{{$champ->id}}" title="{{$champ->name}}" data-placement="top" class="__champ" style="display:inline-block;width:40px;height:40px;background: url('images/champs/champion40.png') no-repeat 0 {{-40*$champ->index}}px;">		
						</div>
						@endforeach	
					</div>						
				</div>
				<div class="modal-footer">
					<div>
						<button class="btn btn-default" id="btn-cancel">Hủy bỏ</button>
						<button class="btn btn-primary" id="btn-verify">Xong</button>
					</div>
				</div>
			</div>
		</div>
	</div><!--End modal  -->

	<div style="display: none;" id="dialog-confirm" title="Cập nhật vị trí"><!--Start confirm dialog-->
	  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Cập nhật tướng cho vị trí bạn chọn, hoặc xóa vị trí này.</p>
	</div><!--End confirm dialog-->

	<div class="container">		
		<div class="col-md-8  col-md-offset-2">
			<h4><i class="fa fa-cog" aria-hidden="true"></i> Cài đặt chung</h4>
			<p>Thông tin đầy đủ và chính xác nhất sẽ giúp bạn dễ dàng tìm được những người đồng đội phù hợp với mình.</p>
			<div style="min-height: 200px;border-bottom: 1px solid #ccc;">
				<table class="table" id="setting-table" style="width: 100%;">

					<!--Section name-->
					<tr <?php if(isset($ac) && $ac=="name") echo 'class="success"'; ?> >
						<td width="25%">Tên trong game</td>
						<td width="55%">
							<div class="frontend">
								<span>{{Sentry::getUser()->name}}</span>
							</div>
							<div class="backend">	
								<form method="POST" action="update">	
									<input type="hidden" name="_token" value="{{csrf_token()}}">
									<div class="form-group">	
										<label>Tên trong game</label>
										<input pattern=".{1,255}" required title="Ten khong hop le" class="form-control" type="text" name="name" value="{{Sentry::getUser()->name}}">
									</div>	
									<p>Tên trong game của bạn sẽ được dùng để hiển thị trong liên lạc với những người chơi khác. Hãy điền chính xác tên trong game cua bạn để mọi người có thể tìm bạn dễ dàng trong game.</p>
									<div class="final-action">
										<button class="btn btn-primary save">Lưu thay đổi</button>
										<button class="btn btn-default cancel">Quay lại</button>
									</div>
								</form>
							</div>
						</td>
						<td width="20%" class="text-right">
							<a href="#" class="edit">{{isset($ac) && $ac==='name' ? 'Đã cập nhật' : 'Chỉnh sửa'}}</a>
						</td>
					</tr><!--End section name-->

					<tr <?php if(isset($ac) && $ac=="avatar") echo 'class="success"'; ?>>
						
						<td>Biểu tượng đại diện</td>
						<td>
							<div class="frontend">
								@if(Sentry::getUser()->avatar !=0)
									<img width="80" height="80" src="/images/avatars/profile_icon/profileIcon14{{Sentry::getUser()->avatar}}.jpg">
								@else
									Chưa cập nhật
								@endif
							</div>
							<div class="backend">
								<form action="update" method="POST">
									<input type="hidden" name="_token" value="{{csrf_token()}}">
									@for($i=27;$i<40;$i++)
									<label class="profile-icon-item">
										<input type="radio" name="avatar" {{$i == Sentry::getUser()->avatar ? 'checked' : ''}} value="{{$i}}">
										<img src="/images/avatars/profile_icon_32/profileIcon14{{$i}}.jpg">
									</label>
									@endfor

									<div class="final-action">
										<button class="btn btn-primary save">Lưu thay đổi</button>
										<button class="btn btn-default cancel">Quay lại</button>
									</div>
								</form>
							</div>
						</td>

						<td class="text-right"><a href="#" class="edit">{{isset($ac) && $ac==='avatar' ? 'Đã cập nhật' : 'Chỉnh sửa'}}</a></td>
							</td>
					</tr>

					<tr <?php if(isset($ac) && $ac=="age") echo 'class="success"'; ?>>
						<td>Tuổi</td>
						<td>
							<div class="frontend">
								{{Sentry::getUser()->age != 0 ? Sentry::getUser()->age :'Chưa cập nhật'}}
							</div>
							<div class="backend">
								<form action="update" method="POST">
									<input type="hidden" name="_token" value="{{csrf_token()}}">
									<div class="form-group">
									<select name="age" class="form-control">
										<option selected disabled>Chọn</option>
										@for($i=10;$i<40;$i++)
											<option value="{{$i}}" {{$i == Sentry::getUser()->age ?  'selected' :''}}>{{$i}}</option>
										@endfor
									</select>
									</div>
									
									<p>Chắc bạn sẽ mong muốn được chơi với người cùng lứa tuổi với mình chứ. Hãy chọn tuổi của bạn.</p>

									<div class="final-action">
										<button class="btn btn-primary save">Lưu thay đổi</button>
										<button class="btn btn-default cancel">Quay lại</button>
									</div>
								</form>
							</div>							
							<td class="text-right"><a href="#" class="edit">{{isset($ac) && $ac==='age' ? 'Đã cập nhật' : 'Chỉnh sửa'}}</a></td>
							</td>
						</td>
					</tr>

					<!--Section rank -->
					<tr <?php if(isset($ac) && $ac=="rank") echo 'class="success"'; ?>>
						<td>Xếp hạng</td>
						<td>
							<div class="frontend">
								<span>{{Sentry::getUser()->rank ? config('constants.ranks')[Sentry::getUser()->rank] : "Chưa cập nhật"}}</span>
							</div>							
							<div class="backend">
								<form action="update" method="POST">
									<input type="hidden" name="_token" value="{{csrf_token()}}">
									<div class="form-group">
										<label>Hạng hiện tại</label>
										<select name="rank" class="form-control">
											<option value="28">Chưa có hạng</option>
											@foreach($position as $key=>$value)				
												<optgroup label="{{$key}}">
													@foreach($value as $k=>$v)
													<option {{$v===Sentry::getUser()->rank ? 'selected':''}} value="{{$v}}">{{config('constants.ranks')[$v]}}</option>
													@endforeach
												</optgroup>
											@endforeach	
										</select>
									</div>

									<p>Hãy lựa chọn rank hiện tại của bạn. Điều này sẽ giúp bạn dễ dàng tìm được những  đồng đội phù hợp với xếp hạng của mình hơn.</p>
									<div class="final-action">
										<button class="btn btn-primary save">Lưu thay đổi</button>
										<button class="btn btn-default cancel">Quay lại</button>
									</div>
								</form>
							</div>
						</td>
						<td class="text-right"><a href="#" class="edit">{{isset($ac) && $ac==='rank' ? 'Đã cập nhật' : 'Chỉnh sửa'}}</a></td>
					</tr><!--End section rank-->

					<!--section lane-->
					<tr <?php if(isset($ac) && $ac=="lanes") echo 'class="success"'; ?>>
						<td>Vị trí chơi tốt nhất</td>
						<td>
							<div class="setting-best-land frontend">
								<ul>
									@if(empty(unserialize(Sentry::getUser()->lanes)))
									<span>Chưa cập nhật</span>
									@else
									@foreach(unserialize(Sentry::getUser()->lanes) as $key => $value)
									<li style="margin-bottom: 20px;">
										<div class="left-title">
											<span class="label <?php 
													switch ($key) {
														case 'top':
															echo('label-primary');
															break;
														case 'jung':
															echo('label-success');
															break;
														case 'mid':
															echo('label-warning');
															break;
														case 'ad':
															echo('label-danger');
															break;
														case 'sp':
															echo('label-info');
															break;
														
														default:
															echo('label-primary');
															break;
													}
												?>">{{config('constants.lanes')[$key]->des}}</span>
										</div>
										<div class="right-info">
											<ul>
											@foreach($value as $c)
												<li><span class="label label-default"><?php echo $list_champs->where('id',$c)->first()->name; ?></span></li>
											@endforeach
											</ul>
										</div>
									</li>
									@endforeach()	
									@endif								
								</ul>
							</div>

							<div  class="backend">
								<p>Chọn những vị trí chắc tay nhất của bạn và tướng bạn hay sử dụng cho những vị trí đó. Qua đó mọi người có thể biết ban có phù hợp với họ hay không.</p>
								<form action="update" method="POST">
									<input type="hidden" name="_token" value="{{csrf_token()}}">
									<ul id="op" class="yop">
										@foreach($lanes as $k=>$v)
											<li>
												<div class="checkbox left-title">
													<label>
														<input {{$k=='all' ? 'class="all-lane"' : ''}} name="lane[{{$k}}]" {{!empty($v)?"checked":""}} type="checkbox" value="{{json_encode($v)}}">{{config('constants.lanes')[$k]->des}}			
													</label>
												</div>
												@if(!empty($v))
													<div class="right-info selected">
														<ul>
															@foreach($v as $c)
																<li><span class="label label-default item-champ" data-id ="{{$list_champs[$c]->id}}" data-name="{{$list_champs->where('id',$c)->first()->name}}">{{$list_champs->where('id',$c)->first()->name }}</span></li>
															@endforeach
														</ul>
													</div>
												@endif
											</li>
										@endforeach									
									</ul>

									<div class="final-action">
										<button class="btn btn-primary save">Lưu thay đổi</button>
										<button class="btn btn-default cancel">Quay lại</button>
									</div>

								</form>
							</div>
						</td>
						<td class="text-right"><a href="#" class="edit">{{isset($ac) && $ac==='lanes' ? 'Đã cập nhật' : 'Chỉnh sửa'}}</a></td>
					</tr><!--End section lane-->

					<tr <?php if(isset($ac) && $ac=="style") echo 'class="success"'; ?>>
						<td>Phong cách chơi</td>
						<td>
							<div class="frontend">
							@if(!empty($styles))							
							<ul class="user-style">
							@foreach($styles as $s)							
								<li><i class="fa fa-check" style="color: green;" aria-hidden="true"></i> {{config('constants.styles_of_player')[$s]}}</li>		
							@endforeach							
							</ul>
							@else
							Chưa cập nhật
							@endif

							</div>
							<div class="backend">
								<form action="update" method="POST">
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<ul>
									@foreach(config('constants.styles_of_player') as $k=>$v)
									<li>
										<div class="checkbox">
											<label>
												<input name="style[]" {{in_array($k,(array)$styles) ? 'checked' :''}} type="checkbox" value="{{$k}}">{{$v}}
											</label>
										</div>
									</li>	
									@endforeach								
								</ul>

								<div class="final-action">
									<button class="btn btn-primary save">Lưu thay đổi</button>
									<button class="btn btn-default cancel">Quay lại</button>
								</div>
								</form>
							</div>
						</td>
						<td class="text-right"><a href="#" class="edit">{{isset($ac) && $ac==='style' ? 'Đã cập nhật' : 'Chỉnh sửa'}}</a></td>
					</tr>

					<tr <?php if(isset($ac) && $ac=="teammate") echo 'class="success"'; ?>>
						<td>Cần tìm đồng đội</td>
						<td>
							<div class="frontend">
							<?php 
								$teammate = array();
								if(Sentry::getUser()->teammate !=null && !empty(unserialize(Sentry::getUser()->teammate))){
									$teammate = unserialize(Sentry::getUser()->teammate);
								}
							?>
							<ul>
								@if(!empty($teammate))
								@foreach(unserialize(Sentry::getUser()->teammate) as $v)
									<li>{{config('constants.lanes')[$v]->des}} <i class="fa fa-check" style="color: green;" aria-hidden="true"></i></li>
								@endforeach
								@else
								Chưa cập nhật
								@endif
							</ul>
							</div>
							<div class="backend">
								<form action="update" method="POST">
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<ul>
								@foreach(config('constants.lanes') as $k=>$l)
								<li>
									<div class="checkbox">
										<label>
											<input name="_teammate[]" {{in_array($k,$teammate)?'checked':''}} value="{{$k}}" type="checkbox">{{$l->des}}
										</label>
									</div>
								</li>								
								@endforeach
								</ul>
								<div class="final-action">
									<button class="btn btn-primary save">Lưu thay đổi</button>
									<button class="btn btn-default cancel">Quay lại</button>
								</div>
								</form>
							</div>
						</td>
						<td class="text-right"><a href="#" class="edit">{{isset($ac) && $ac==='teammate' ? 'Đã cập nhật' : 'Chỉnh sửa'}}</a></td>
					</tr>
					
					<tr <?php if(isset($ac) && $ac=="message") echo 'class="success"'; ?>>
						<td>Lời nhắn</td>
						<td>
							<div class="frontend">
								@if(Sentry::getUser()->message!=null)
								<p>{{Sentry::getUser()->message}}</p>
								@else
								Chưa cập nhật
								@endif
							</div>
							<div class="backend">	
							<form action="update" method="POST">	
							<input type="hidden" name="_token" value="{{csrf_token()}}">				
								<div class="form-group">
								<textarea class="form-control" style="margin: 0;width: 100%; resize: vertical;height: 150px" name="messages">{{Sentry::getUser()->message}}</textarea>
								</div>										
								<p>
									Hãy nói điều gì đó để chứng tỏ rằng bạn là người đồng đội đáng tin tưởng.
								</p>
								<div class="final-action">
									<button class="btn btn-primary save">Lưu thay đổi</button>
									<button class="btn btn-default cancel">Quay lại</button>
								</div>
							</form>
							</div>
						</td>
						<td class="text-right"><a href="#" class="edit">{{isset($ac) && $ac==='message' ? 'Đã cập nhật' : 'Chỉnh sửa'}}</a></td>
					</tr>
				</table>
			</div>
		</div>		
	</div>	
</main>
@endsection
