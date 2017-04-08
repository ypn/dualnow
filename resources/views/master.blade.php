<?php    
  $flag_unred = isset($unread) && $unread > 0; 
  ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
@yield('meta')		
<link rel="stylesheet" type="text/css" href="/css/app.css">  	
<link rel="stylesheet" type="text/css" href="/css/font-awesome-4.7.0/css/font-awesome.min.css">	
@yield('style')	
</head>
<body>
<!-- Modal -->
<div id="modal-login" class="modal fade" role="dialog">
  <div class="modal-dialog __ydialog __ymodal">
    <!-- Modal content-->
    <div class="modal-content">    
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>       
      </div>

      <div class="modal-body">
          <ul class="nav nav-tabs __ytabs">
            <li class="active"><a data-toggle="tab" href="#menu1">Đăng nhập</a></li>   
            <li><a data-toggle="tab" href="#menu2">Đăng kí</a></li>       
          </ul>   

          <div class="tab-content">  
            <div id="menu1" class="tab-pane fade in active">
              <div style="text-align: center;">
                <a href="{{$loginUrl}}">
                  <div class="ybtn fblogin">
                      <i class="fa fa-facebook" aria-hidden="true"></i> 
                      <span class="__line"></span>
                      <span>Đăng nhập bằng facebook</span>
                  </div>
                </a>
              </div>

              <div class="hr">              
                <h4>
                  Hoặc
                </h4>
              </div>
              <form id="form-login">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                  <div class="form-group">                   
                    <input placeholder="Địa chỉ email" name="email" type="email" class="form-control">
                  </div>
                  <div class="form-group">                    
                      <input placeholder="Mật khẩu" name="password" type="password" class="form-control">
                  </div>   

                  <div class="alert alert-danger" style="display: none;">
                      <span>                 
                        <strong>Lỗi đăng nhập! </strong>Hãy kiểm tra lại thông tin. </span>
                  </div>

                  <div style="text-align: center;">       
                      <button type="submit" class="btn btn-success" data-loading-text="<i class='fa fa-spinner fa-spin '></i> processing....">Đăng nhập</button>
                  </div>
              </form>

            </div>

            <div id="menu2" class="tab-pane fade">
             <form id="form-register">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">
                  <div class="form-group">
                    <input name="email" type="email" class="form-control" placeholder="Địa chỉ email"> 
                  </div>
                  <div class="form-group">                    
                      <input name="in_game" type="text" class="form-control" placeholder="Tên sử dụng trong game">
                  </div>  
                  <div class="form-group">                    
                      <input name="password" type="password" id="repassword" class="form-control" placeholder="Mật khẩu">
                  </div>  

                  <div class="form-group">                    
                      <input name="retype_password" type="password" class="form-control" placeholder="Xác nhận mật khẩu">
                  </div>  

                  <div class="alert alert-danger" style="display: none;">
                  <span>                 
                    <strong>Lỗi đăng kí!</strong>Indicates a successful or positive action.</span>
                  </div>

                  <button  data-loading-text="<i class='fa fa-spinner fa-spin '></i> processing...." style="background: #EA1E30;color: #fff" type="submit" class="btn">Đăng ki</button>
              </form>
            </div>
          </div><!--End tab content -->       
      </div>
    </div>
  </div>
</div><!--End modal -->
<header>
  <div class="container">  
    <nav>
      <div class="navbar-header">
        <button type="button" class="btn btn-primary navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <i class="fa fa-bars" aria-hidden="true"></i>
        </button>
        <div style="padding-top: 7px;"><img src="/images/icon-game-lol.png"></div>
      </div>

      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">        
          <li><a href="/">Trang chủ</a></li>   
          <li><a href="/download-mod-skin-lol">Mod skin</a></li> 
          <li><a href="/room-chat">Phòng chat</a></li> 
          <li><a href=/posts>Dang bai</a></li>
          <li><a href=/funny>Vui</a></li>
        </ul> 
                
        <ul class="nav navbar-nav navbar-right custom-nav">  
            @if(!Sentry::check())     
              <li>
                <a href="#" data-toggle="modal" data-target="#modal-login">Đăng nhập</a>
              </li>
            @else  
              <li class="dropdown" id="ynotifications" >                
                    <a href="javascript:void(0)" data-toggle="dropdown" class="ynotice"><i class="fa fa-bell" aria-hidden="true"></i>
                      @if($notifications!=0)
                      <span class="count">{{$notifications}}</span>
                      @endif    
                    </a><!--icon and count notice-->

                    <div class="dropdown-menu dropdown-menu-right notice-content" style="background: #fff;padding-top: 5px;">
                      <span class="up-carret"><i class="fa fa-sort-asc" aria-hidden="true"></i></span>
                        <!--List content -->
                        <h5 class="title">Thông báo</h5>
                        <div class="dd-content">                
                    </div><!--End list content -->               
              </li>

              <li>                       
                  <a href="/messages/inbox" id="ymessages" class="ynotice"><i class="fa fa-envelope" aria-hidden="true"></i>
                    @if($flag_unred)
                    <span class="count">{{$unread}}</span>
                    @endif
                  </a>                   
              </li>  

              <li>                  
                <a href="/summoner/{{Sentry::getUser()->alias}}">{{Sentry::getUser()->name}}</a> 
              </li>
              <li class="dropdown">                 
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-down" aria-hidden="true"></i></a>
                  <ul class="dropdown-menu dropdown-menu-right">             
                    <li><a href="/settings"><i class="fa fa-cog" aria-hidden="true"></i> Cập nhật</a></li>
                    <li><a href="/logout"><i class="fa fa-sign-out" aria-hidden="true"></i> Đăng xuất</a></li>
                  </ul>                
              </li>  
             @endif          
        </ul>
        
      </div>  
    </nav>     
  </div>
</header>
@yield('content')
<footer>
  <div class="container link-footer">
    <div class="row">
      <div class="col-md-6">
        <a href="dieu-khoan-su-dung">NỘI QUY</a>
      </div>
    </div>
  </div>
  <div style="background: #2b3b4b;">
    <div class="container">
      2016 Powered By Dualnow, Theme was designed by ypn.
    </div>
  </div>  
</footer>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-90324616-1', 'auto');
  ga('send', 'pageview');

</script>
<script>
  var user_id =  {{Sentry::check()?Sentry::getUser()->id:0}};  
</script>
<script type="text/javascript" src="/js/app.js" ></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="/js/base.js"></script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
@yield('script')
</body>
</html>
