<?php

namespace App\Http\Controllers;

require "simple_html_dom.php";
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\View;
use App\Entities\Users;
use App\Entities\FriendsShip;
use App\Helpers\Utilities;
use App\Entities\NoticesUsers;
use App\Entities\UsersStyles;
use App\Entities\Champions;
use Sentry;
use DB;
use Cache;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
   

    public function __construct()
    {
        Carbon::setLocale(config('app.locale'));        
        $this->middleware('guest', ['except' => 'logout']);
    }
  
   
    public function home(){ 

    	$summoners = Users::select('id','name','rank','lanes','alias','priority','age','last_action','avatar','message','teammate')->orderBy('last_action','desc')->orderBy('priority','desc');   	

    	$input = Request::all();  

    	if(isset($input['show'])){
    		Session::put('show',$input['show']);      		
    	}    	  

    	if(isset($input['rank']) && in_array(intval($input['rank']) , range(1, 28) ,true)){

    		$summoners = $summoners->where('rank',$input['rank']);    		
    	}

    	if(isset($input['age']) && in_array(intval($input['age']), range(10, 39) , true)){
    		
    		$summoners = $summoners->where('age',$input['age']);
    	}

    	if(isset($input['style']) && !array_diff($input['style'], range(0, 9))){
    		$sum_id = UsersStyles::select('uid')->whereIn('style_id',$input['style'])->groupBy('uid')->get();

    		$a_filter = array();
    		foreach ($sum_id as $key => $value) {    			
    			array_push($a_filter, $value->uid);
    		}    		
    		
    		$summoners = $summoners->whereIn('id',$a_filter);
    	}

    	if(isset($input['roles'])){    		
    		foreach ($input['roles'] as $key => $value) {   
    			if($key==0){
    				$summoners = $summoners->where('lanes','like','%' .$value. '%');
    			}else{
    				$summoners = $summoners->orWhere('lanes','like','%' .$value. '%');
    			}		
    			
    		}
    	}

    	$summoners = $summoners->paginate(100);

    	foreach($summoners as $s){
    		switch ($s->rank) {
				case 0:
					$s->border_offset = -1;
					break;
				case 27:
					$s->border_offset = 6;
					break;	
				case 28:
					$s->border_offset = -1;
					break;		
				
				default:
					$s->border_offset = intval(($s->rank -1) / 5);
					break;
			}

			$s->styles = UsersStyles::where('uid',$s->id)->get();

    	}

    	if(Sentry::check()){
    		$uid = Sentry::getUser()->id;    		
    		foreach ($summoners as $key => $value) {    			
    			$fs = FriendsShip::where(['mid'=>$uid,'uid'=>$value->id])
    			->orWhere(['uid'=>$uid,'mid'=>$value->id])
    			->first();

    			if(!empty($fs)){
    				$value->friend_ship = $fs->status;
    				$value->user_send_action = $fs->actions_user;
    			}    			
    			
    		}
    		
    	}    
    	return view('home',array('summoners'=>$summoners));
    }   

    public function curl(){
    	$ch = curl_init();

    	curl_setopt($ch, CURLOPT_URL, 'http://localhost:8087/v3/servers/_defaultServer_/users');    

    	curl_exec($ch);

    	curl_close($ch);
    }

    public function curl_tt(){   

    	$header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
		$header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
		$header[] = "Cache-Control: max-age=0";
		$header[] = "Connection: keep-alive";
		$header[] = "Keep-Alive: 300";
		$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
		$header[] = "Accept-Language: en-us,en;q=0.5";
		$header[] = "Pragma: ";

    	$ch = curl_init();

    	curl_setopt($ch, CURLOPT_URL, "http://www.op.gg/champion/statistics");
    	curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:50.0) Gecko/20100101 Firefox/50.0');    	

		//curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);		

		$dom = new simple_html_dom();
		// Load HTML from a string
		$dom->load(curl_exec($ch));

		curl_close($ch);


    	return $dom;


	}

	/*public function htmlDOM(){	

		return view('parsejs');

		$result = array();	
		$champs = array();
		$champs_index = array();
		$html = file_get_html('http://www.op.gg/champion/statistics');
		$html1 = file_get_html('http://lienminhsamsoi.vn/profile?name=Cowstep');

		//print_r($html1->find('span.profile-name'));die;


		$a = $html->find('div.__spc82');print_r($a);die;

		foreach($a as $e){
			$result[substr($e->class, 31)] = $e->plaintext;				
		}

		die;

		file_put_contents('/var/www/html/leaguage/public/js/champs.json', json_encode($result));	
	}
*/
	/*public function listChamps(){
		$champs = json_decode(file_get_contents('/var/www/html/leaguage/public/js/champs.json'));

		print_r((array)$champs);die;

	}
*/

	public function edit(){	
		
		$lanes = unserialize(Sentry::getUser()->lanes);

		$user_style = UsersStyles::where('uid',Sentry::getUser()->id)->get();

		$u = array();

		foreach ($user_style as $key => $value) {
			array_push($u, $value->style_id);
		}

	
		$list_champs = Champions::select('id','index','name')->get();	
		$sender['list_champs'] = $list_champs;		
		$sender['lanes'] = array(
			'top'=>isset($lanes['top'])?$lanes['top'] : [],
			'jung'=>isset($lanes['jung'])?$lanes['jung'] : [],
			'mid'=>isset($lanes['mid'])?$lanes['mid'] : [],
			'ad'=>isset($lanes['ad'])?$lanes['ad'] : [],
			'sp'=>isset($lanes['sp'])?$lanes['sp'] : [],
			'all'=>isset($lanes['all'])?$lanes['all']:[]
			);
		$sender['styles'] = $u;

		return view('general_settings',$sender);
	}

	public function updateFriend(){

		if(Sentry::check()){
			$input = Request::all();
			if(isset($input['_action']) 						
				&& in_array(intval($input['_action']),[0,1],true)
				&& isset($input['_uid'])
				&& !empty(Sentry::findUserById($input['_uid']))
				&& $input['_uid']!= Sentry::getUser()->id
			){
				$crid = Sentry::getUser()->id;
				switch ($input['_action']) {
					case 1: //Gui loi moi choi
						try{
							$fs = new FriendsShip();	
							$fs->mid = $crid < $input['_uid'] ? $crid : $input['_uid'];
							$fs->uid = $crid < $input['_uid'] ? $input['_uid'] : $crid;
							$fs->actions_user = $crid;
							$fs->save();
							if(!empty($fs)){
								//gui thong bao cho users
								$u_notice = new NoticesUsers();
								$u_notice->trigger_id = Sentry::getUser()->id;
								$u_notice->receiver_id = $input['_uid'];
								$u_notice->notice_id = 1;
								$u_notice->save();							

								return(json_encode(['code'=>'101','status'=>'success']));
							}						
						}catch(QueryException $ex){
							return(json_encode(['code'=>'101','status'=>'false','reason'=>'existed_relation']));
						}				

					break;				
					
				}

			}else{
				return(json_encode(['code'=>'101','status'=>'false']));
			}

		}else{
			return(json_encode(['code'=>'101','status'=>'false','reason'=>'null_login']));
		}		
		
	}

	public function profile($alias){
		$user = Users::select('id','name','rank','lanes','alias','avatar','age','message')->where('alias',$alias)->first();
		if(!empty($user)){
			switch ($user->rank) {
				case 0:
					$user->border_offset = -1;
					break;
				case 27:
					$user->border_offset = 6;
					break;	
				case 28:
					$user->border_offset = -1;
					break;		
				
				default:
					$user->border_offset = intval(($user->rank -1) / 5);
					break;
			}

			$user->styles = UsersStyles::where('uid',$user->id)->get();

			

			if(Sentry::check()){
				$fs = FriendsShip::where(['mid'=>Sentry::getUser()->id,'uid'=>$user->id])
    			->orWhere(['uid'=>Sentry::getUser()->id,'mid'=>$user->id])
    			->first();

				if(!empty($fs)){
					$user->friend_ship = $fs->status;
					$user->user_send_action = $fs->actions_user;
				}    	
			}

			$list_champs = Champions::select('id','index','name')->get();	
		
				

			return view('summoner_detail',array('summoner'=>$user,'list_champs'=>$list_champs));
		}		
	}

	public function downloadmodskin(){
		return view ('download');
	}

	public function license(){
		return view('license');
	}


	public function downloadnow(){
		//$file = public_path('images/MODSKINPRO_7.1.2.rar');
		$file = 'https://youtu.be/e771hCecIyw';
		return Response::download($file);
	}

	public function funnyapp(){
		return view ('funnyapp');
	}

	public function admin(){
		return view('admin.admin');
	}

	public function posts(){
		return view ('posts');
	}

	public function infinity(){
		return 'Tao La Pham Nhu Y';
	}

}
