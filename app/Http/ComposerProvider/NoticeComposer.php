<?php 
	namespace App\Http\ComposerProvider;	
	use Illuminate\Contracts\View\View;
	use App\Entities\NoticesUsers;
	use App\Entities\FriendsShip;
	use App\Entities\UserMessageMapple;

	use Sentry;

	class NoticeComposer {

	    /**
	     * Bind data to the view.
	     *
	     * @param  View  $view
	     * @return void
	     */
	    public function compose(View $view)
	    {

	    	//Login facebook
	    	if (!session_id()) {
	            session_start();
	        }
	    	$fb = new \Facebook\Facebook([
	          'app_id' => '1288241967885581',
	          'app_secret' => 'b2d98c55d198bc3ddc68f3ef2113ad75',
	          'default_graph_version' => 'v2.8',
	          //'default_access_token' => '{access-token}', // optional
	        ]);

	        $helper = $fb->getRedirectLoginHelper();	    

	        $permissions = ['email']; // Optional permissions
	        $loginUrl = $helper->getLoginUrl('http://douq.vn/fb-callback', $permissions); 

	        $view->with(['loginUrl'=>$loginUrl]);

	        if(Sentry::check()){
	        	
	        	//Notification have been received
	        	$notices = NoticesUsers::where(['receiver_id'=>Sentry::getUser()->id,'status'=>0])->count();	        	

	        	//messages have been received;
	        	$unread = UserMessageMapple::where(['receiver_id'=>Sentry::getUser()->id,'is_read'=>0])->count();
	        	$view->with([
	        		'notifications'=>$notices,
	        		'unread'=>$unread,	        		   		
	        		]);
	        }
	        
	    }
	}

 ?>