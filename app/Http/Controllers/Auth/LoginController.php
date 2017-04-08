<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Collection;
use App\Helpers\Utilities;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use App\Entities\Users;
use App\Entities\Messages;
use App\Entities\UserMessageMapple;
use App\Entities\FriendsShip;
use App\Entities\NoticesUsers;
use App\Entities\UsersStyles;
use App\Entities\PublicChat;
use Pusher;
use Sentry;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /*Some code when response
     *code = 100 for log in logout response
     *code = 102 => chap nhan de nghi choi cung.

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */    

    public function handleLogin(){
        $input = Request::all(); 
        try{
            Sentry::authenticate([
            'email'=>$input['email'],
            'password'=>$input['password']
            ],false); 

            return json_encode(['code'=>'100','status'=>"success"]);      
        }
        catch (\Cartalyst\Sentry\Users\LoginRequiredException $e)
        {
            return json_encode(['code'=>100,'status'=>"fails"]);
        }
        catch (\Cartalyst\Sentry\Users\PasswordRequiredException $e)
        {
            return json_encode(['code'=>100,'status'=>"fails"]);
        }
        catch (\Cartalyst\Sentry\Users\WrongPasswordException $e)
        {
            return json_encode(['code'=>100,'status'=>"wrong_password"]);
        }
        catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            return json_encode(['code'=>100,'status'=>"user_not_exist"]);
        }
        catch (\Cartalyst\Sentry\Users\UserNotActivatedException $e)
        {
            return json_encode(['code'=>100,'status'=>"fails"]);
        }

        // The following is only required if the throttling is enabled
        catch (\Cartalyst\Sentry\Throttling\UserSuspendedException $e)
        {
            return json_encode(['code'=>100,'status'=>"suspended"]);
        }
        catch (\Cartalyst\Sentry\Throttling\UserBannedException $e)
        {
            return json_encode(['code'=>100,'status'=>"banded"]);
        }
    }

    public function handleLogout(){
        Sentry::logout();
        return redirect('./');
    }

    //Update profile
    public function update(){
        $input = Request::all();

        $user = Sentry::findUserById(Sentry::getUser()->id);

        if(isset($input['name'])){
            $user->name=trim(strip_tags($input['name']));
            $user->alias = Utilities::slug(strip_tags($input['name']),'users');
            Session::flash('update','name');
        }

        elseif(isset($input['rank'])){                     
            $rank = trim(strip_tags($input['rank']));                
            if(in_array(intval($rank), range(1, 28) ,true)){                        
                $user->rank = $rank;

                if(!Sentry::getUser()->rank){$user->priority +=3;} //update priority
            }
            Session::flash('update','rank');
        }

        elseif(isset($input['lane'])){
            $lanes = $input['lane'];            
            foreach ($lanes as $key => $value) {
                if(!in_array($key, ['top','jung','mid','ad','sp','all'])){
                    unset($lanes[$key]);
                }else{                       
                    $value= (array)json_decode($value);
                    if(empty($value)){
                        unset($lanes[$key]);
                    }    
                    else{
                        foreach ($value as $k => $v) {
                            if(!in_array(intval($v), range(1, 134),true)){
                                unset($value[$k]);
                            }                        
                        }
                        if(empty(unserialize(Sentry::getUser()->lanes))){$user->priority +=3;} //update priority

                        $lanes[$key] = $value;
                    }            
                   
                }
            }

            $user->lanes = serialize($lanes);           

            Session::flash('update','lanes');
        }

        else if(isset($input['age'])){
            if(in_array(intval($input['age']), range(10, 39) , true)){
                $user->age = $input['age'];

                if(!Sentry::getUser()->age){$user->priority +=1;} //update 

                Session::flash('update','age');
            }
        }

        else if(isset($input['style'])){       
            if(!array_diff($input['style'], range(0, 9))){
                if(empty(UsersStyles::where('uid',Sentry::getUser()->id)->first())){$user->priority +=1;}
                UsersStyles::where('uid',Sentry::getUser()->id)->delete();              
                foreach ($input['style'] as $value) {
                    try{

                        UsersStyles::insert(['uid'=>Sentry::getUser()->id,'style_id'=>$value]);      
                       
                    }
                    catch(QueryException $ex){}
                }

                Session::flash('update','style');

                
                
            }

        }

        else if(isset($input['avatar'])){ 
            if(in_array(intval($input['avatar']), range(27, 39) , true)){
                $user->avatar = $input['avatar'];         
                Session::flash('update','avatar');
            }
        }

        else if(isset($input['messages'])){
            $user->message = trim(strip_tags($input['messages']));
            Session::flash('update','message');
        }

        else if(isset($input['_teammate'])){
            if(!array_diff($input['_teammate'], ['top','jung','mid','ad','sp','all'])){
                $user->teammate = serialize($input['_teammate']);
                Session::flash('update','teammate');
            }
        }

        else{
            return Redirect::back();
        }

        try{
            $user->save();           
        }catch(QueryException $e){}            


       
        return Redirect::back();
        

    }

    //messages manager
    public function inbox(){  

        $messages = UserMessageMapple::                  
                    where('receiver_id',Sentry::getUser()->id)->whereIn('placeholder_id',[2,3])->orderBy('message_id','desc')->get();

        foreach ($messages as $key => $value) {
            $m = Messages::where('id',$value->message_id)->first();
            $value->content = isset($m->content) ? $m->content :'';

            $u = Users::where('id',$value->author_id)->first();
            $value->sender = isset($u->name) ? $u->name : '';
            $value->sender_alias = isset($u->alias) ? $u->alias :'#';
        }

        return view('inbox_messages',['messages'=>$messages,'control'=>'inbox']);
    }

    public function send(){    
        $messages = UserMessageMapple::where('author_id',Sentry::getUser()->id)->whereIn('placeholder_id',[1,3])       
        ->orderBy('message_id','desc')->get();

        foreach ($messages as $key => $value) {
            $m = Messages::where('id',$value->message_id)->first();
            $value->content = isset($m->content) ? $m->content :'';

            $u = Users::where('id',$value->receiver_id)->first();
            $value->receiver = isset($u->name) ? $u->name :'';
            $value->receiver_alias = isset($u->alias) ? $u->alias : '';
        }
        return view('send_messages',['messages'=>$messages,'control'=>'send']);
    }

    //compose message
    public function compose(){
        return view ('mail');
    }

    public function readMessage($sender_alias,$rid,$message_id){
        if($rid == Sentry::getUser()->id){
            $sid = Users::select('id')->where('alias',$sender_alias)->first();
            if(isset($sid->id)){
                $mss = UserMessageMapple::where(['receiver_id'=>$rid,'author_id'=>$sid->id])->update(['is_read'=>1]);
            }
        }

        return redirect('/messages/detail/'. $sender_alias);
       

    }

    //proposal messages for special one.
    public function conversation($alias){    
        $ships =[];    
        $user =     Users::select('name','id','alias','avatar','created_at')->where('alias',$alias)->first();
        if(!empty($user)){
            $messages = UserMessageMapple::
            where(
                [   'receiver_id'=>Sentry::getUser()->id,
                    'author_id'=>$user->id     
                ])->whereIn('placeholder_id',[2,3])->orWhere([
                    'author_id'=>Sentry::getUser()->id,
                    'receiver_id'=>$user->id,                   
                ])->whereIn('placeholder_id',[1,3])->orderBy('message_id','desc')->get();

            foreach ($messages as $key => $value) {
                $m = Messages::where('id',$value->message_id)->first();
                $value->content = isset($m->content) ? $m->content :'';

                $u = Users::select('name','alias','avatar')->where('id',$value->author_id)->first();
                $value->sender_name = isset($u->name) ? $u->name : '';
                $value->sender_alias = isset($u->alias) ? $u->alias :'';
                $value->avatar = isset($u->avatar) ? $u->avatar :0;
            }
            $ships['messages']= $messages;

        }
        
        $ships['receiver'] = $user;
        return view ('messages_detail',$ships);
    }

    private function get_relationship($rid,$sid){        
        return FriendsShip::select('status')->where(['mid'=>$sid,'uid'=>$rid])
        ->orWhere(['uid'=>$sid,'mid'=>$rid])
        ->first();
    }

    public function sendMessage(){
        $input = Request::all(); 
        if(isset($input['content']) && !empty($input['content']) && isset($input['receiver'])){
            $rid = Users::select('name','id')->where('alias',$input['receiver'])->first();
            if(!empty($rid)){
                $sid = Sentry::getUser()->id; 
                $rid = $rid->id;
                $messages = new Messages();                   
                $messages->content = trim(strip_tags($input['content']));                    
                $messages->save();

                $user_message_mapple = new UserMessageMapple();//User send messsage
                $user_message_mapple->message_id = $messages->id;
                $user_message_mapple->receiver_id = $rid;
                $user_message_mapple->author_id = Sentry::getUser()->id;                   
           
                $user_message_mapple->save();

                Session::flash('messages','success');         
                
            }  else{
                    Session::flash('messages','user_not_exist');
            }          
           
        }else{
            Session::flash('messages','failure');
        }
        
        return Redirect::back();
    }

    /*public function sendMessage(){
        $input = Request::all(); 
        if(isset($input['content']) && !empty($input['content']) && isset($input['receiver'])){
            $rid = Users::select('name','id')->where('alias',$input['receiver'])->first();
            if(!empty($rid)){
                $sid = Sentry::getUser()->id; 
                $rid = $rid->id;  

                $rs = $this->get_relationship($sid,$rid);                    
               

                if(!empty($rs) && $rs->status == 1){                   
                    $messages = new Messages();                   
                    $messages->content = trim(strip_tags($input['content']));                    
                    $messages->save();

                    $user_message_mapple = new UserMessageMapple();//User send messsage
                    $user_message_mapple->message_id = $messages->id;
                    $user_message_mapple->receiver_id = $rid;
                    $user_message_mapple->author_id = Sentry::getUser()->id;                   
               
                    $user_message_mapple->save();

                    Session::flash('messages','success');
             

                }  else{
                    Session::flash('messages','send_contact_first');
                }             
                
            }  else{
                    Session::flash('messages','user_not_exist');
            }          
           
        }else{
            Session::flash('messages','failure');
        }
        
        return Redirect::back();
    }*/

    /*Delete message.
    *placeholder_id bieu dien trang thai cua tin nhan doi voi nguoi gui va nguoi nhan theo ma nhi *phan.
    *placeholder_id = 10(2) => nguoi nhan se nhin thay tin nhan con nguoi gui thi khong (Nguoi *gui xoa tin nhan)
    *placeholder_id = 01(1) => nguoi gui se nhin thay tin nhan con nguoi nhan thi khong (Nguoi  *nhan xoa tin nhan)
    *placeholder_id = 11(3) => Ca nguoi gui va nguoi nhan se nhin thay tin nhan (Trang thai mac *dinh)
    */
    public function deletesend(){
        $input = Request::all();
        if(isset($input['ms'])){
            foreach ($input['ms'] as $key => $value) {                
                $ms = UserMessageMapple::where(['message_id'=>$value,'author_id'=>Sentry::getUser()->id])->first();    

                if(!empty($ms)){                    
                    if($ms->placeholder_id !=3){
                        Messages::where('id',$ms->message_id)->delete(); 
                        $ms->delete();
                    }else{                        
                        if($ms->author_id == Sentry::getUser()->id){
                            //Neu user hien tai xoa tin la nguoi gui tin nhan
                            $ms->placeholder_id = 2;                            
                        }else if($ms->receiver_id == Sentry::getUser()->id){
                            //Neu user hien tai xoa tin la nguoi nhan tin nhan.
                            $ms->placeholder_id = 1;
                        }

                        $ms->save();
                    }

                    Session::flash('messages','success');  
                }           
                
            }
        }

        return Redirect::back();       
    }

    public function deleteInbox(){
        $input = Request::all();
        if(isset($input['ms'])){

            foreach ($input['ms'] as $key => $value) {
                $ms = UserMessageMapple::where(['message_id'=>$value,'receiver_id'=>Sentry::getUser()->id])->first();              
                if(!empty($ms)){

                    if($ms->placeholder_id !=3){
                        Messages::where('id',$ms->message_id)->delete(); 
                        $ms->delete();
                    }else{
                        if($ms->author_id == Sentry::getUser()->id){
                            //Neu user hien tai xoa tin la nguoi gui tin nhan
                            $ms->placeholder_id = 2;                            
                        }else if($ms->receiver_id == Sentry::getUser()->id){
                            //Neu user hien tai xoa tin la nguoi nhan tin nhan.
                            $ms->placeholder_id = 1;
                        }

                        $ms->save();
                    }

                    Session::flash('messages','success');                    
                }
            }
        }

        return Redirect::back();
    }

    //Notification manager

    public function readNotification(){
        $notices = NoticesUsers::where(['receiver_id'=>Sentry::getUser()->id])->get();

        foreach ($notices as $key => $value) {
            NoticesUsers::where('id',$value->id)->update(['status'=>1]);
            $user = Users::select('id','name','alias')->where('id',$value->trigger_id)->first();
            $value->trigger_name = isset($user->name) ? $user->name :'';
            $value->trigger_alias = isset($user->alias) ? $user->alias : '';


        }

        return $notices->toJson();
    }

    public function deleteNotification(){
        $notice_id = Request::input('_notice_id');        
        try{
            $n_user = NoticesUsers::where(['id'=>$notice_id,'receiver_id'=>Sentry::getUser()->id])->first();

            if(!empty($n_user)){
                if($n_user->notice_id ==1){
                    FriendsShip::where(['mid'=>$n_user->receiver_id,'uid'=>$n_user->trigger_id])->orWhere(['uid'=>$n_user->receiver_id,'mid'=>$n_user->trigger_id])->delete();
                }

                $n_user->delete();
                return json_encode(['code'=>202,'status'=>'success']);
            }
           
        }catch(QueryException $e){

        }
        
    }   

    //Chap nhan loi de nghi choi cung.
    //Code 102 => chap nhan de nghi.
    /*public function accept(){
        $input = Request::all();       
        if(isset($input['_trigger_id']) && isset($input['_notice_id'])){
            try{
                FriendsShip::where(['mid'=>Sentry::getUser()->id,'uid'=>$input['_trigger_id']])
            ->orWhere(['uid'=>Sentry::getUser()->id,'mid'=>$input['_trigger_id']])
            ->update(['status'=>1,'actions_user'=>Sentry::getUser()->id]);

            NoticesUsers::where(['id'=>$input['_notice_id'],'receiver_id'=>Sentry::getUser()->id])->update(['receiver_id'=>$input['_trigger_id'],'trigger_id'=>Sentry::getUser()->id,'notice_id'=>2,'status'=>0]);

            return (json_encode(['code'=>102,'status'=>'success']));
            }catch(Exception $e){

            }
        }

        return json_encode(['code'=>102,'status'=>'false']);
    }*/

    public function accept(){
        $input = Request::all();       
        if(isset($input['_trigger_id'])){
            try{
                FriendsShip::where(['mid'=>Sentry::getUser()->id,'uid'=>$input['_trigger_id']])
            ->orWhere(['uid'=>Sentry::getUser()->id,'mid'=>$input['_trigger_id']])
            ->update(['status'=>1,'actions_user'=>Sentry::getUser()->id]);

            NoticesUsers::where(['trigger_id'=>$input['_trigger_id'],'receiver_id'=>Sentry::getUser()->id])->update(['receiver_id'=>$input['_trigger_id'],'trigger_id'=>Sentry::getUser()->id,'notice_id'=>2,'status'=>0]);

            return (json_encode(['code'=>102,'status'=>'success']));
            }catch(Exception $e){

            }
        }

        return json_encode(['code'=>102,'status'=>'false']);
    }

    public function getNotices(){
        if(Sentry::check()){
            $notices = NoticesUsers::where(['receiver_id'=>Sentry::getUser()->id,'status'=>0])->count();      

            $unread = UserMessageMapple::where(['receiver_id'=>Sentry::getUser()->id,'is_read'=>0])->count();  

            return json_encode([
                'notice'=>$notices,
                'messages'=>$unread
            ]);
        }

    }

    public function chat(){
        $public_messages = PublicChat::orderBy('created_at','desc')->take(100)->get();
        $public_messages = array_reverse(json_decode($public_messages));
        foreach($public_messages as $pm){
            $u = Users::select('avatar','name','alias')->where('id',$pm->uid)->first();
            $pm->u_name = isset($u->name) ? $u->name:'';
            $pm->avatar = isset($u->avatar) ? $u->avatar :'';
            $pm->alias =isset($u->alias) ? $u->alias :'';
        }
        return view ('chat_room',array('public_messages'=>$public_messages));
    }
    public function postChat(){   
        $input = Request::all();     
        if(isset($input['entry']) && !empty($input['entry'])){
            $options = array(
            'encrypted' => true
            );
            $pusher = new Pusher(
                '276195c331a0283e6d52',
                '64fabba6cbe3c6653836',
                '291546',
                $options
            );
            $data['data'] = json_encode(array(
                    'uid'=>Sentry::getUser()->id,
                    'name'=>Sentry::getUser()->name,
                    'avatar'=>Sentry::getUser()->avatar,
                    'message'=>trim(strip_tags($input['entry']))
                ));
            $pusher->trigger('public-chat', 'new-message', $data); 

            try{
                $pm = new PublicChat();
                $pm->uid  = Sentry::getUser()->id;
                $pm->content = trim(strip_tags($input['entry']));
                $pm->save();
            }catch(QueryException $ex){}
            
        }           
    }    

    public function fbCallback(){
        //die(session('state'));
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


        try {
          $accessToken = $helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
          // When Graph returns an error
          echo 'Graph returned an error: ' . $e->getMessage();
          exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
          // When validation fails or other local issues
          echo 'Facebook SDK returned an error: ' . $e->getMessage();
          exit;
        }

        if (! isset($accessToken)) {
          if ($helper->getError()) {
            header('HTTP/1.0 401 Unauthorized');
            echo "Error: " . $helper->getError() . "\n";
            echo "Error Code: " . $helper->getErrorCode() . "\n";
            echo "Error Reason: " . $helper->getErrorReason() . "\n";
            echo "Error Description: " . $helper->getErrorDescription() . "\n";
          } else {
            header('HTTP/1.0 400 Bad Request');
            echo 'Bad request';
          }
          exit;
        }

        $oAuth2Client = $fb->getOAuth2Client();

        $tokenMetadata = $oAuth2Client->debugToken($accessToken);

        $tokenMetadata->validateAppId('1288241967885581');

        $tokenMetadata->validateExpiration();

        if (! $accessToken->isLongLived()) {
        // Exchanges a short-lived access token for a long-lived one
          try {
            $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
          } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
            exit;
          }         
        }

        try {
        // Returns a `Facebook\FacebookResponse` object
          $response = $fb->get('/me?fields=id,name,email', $accessToken);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
          echo 'Graph returned an error: ' . $e->getMessage();
          exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
          echo 'Facebook SDK returned an error: ' . $e->getMessage();
          exit;
        }

        $fbuser = $response->getGraphUser();       

        $user = Users::where('email',$fbuser['email'])->first();
        if(empty($user)){
            try{
                $u = Sentry::register([
                    'name' => $fbuser['name'],
                    'email' => $fbuser['email'],
                    'password' => 'ypn' . $fbuser['id'],
                    'lanes'=>serialize([]),
                    'alias'=>Utilities::slug($fbuser['name'],'users'),
                    'fb_accesstoken'=>$accessToken,
                    'fb_id'=>$fbuser['id']
                ]);

                $notification = new NoticesUsers();
                $notification->receiver_id = $u->id;
                $notification->trigger_id = 0;//He thong
                $notification->notice_id = 0; //Thong bao update profile
                $notification->save();
            }
            catch (PasswordRequiredException $e){
                echo "wft:" . $e;
            }
            catch (UserExistsException $e){
                echo "wft1:" . $e;
            }
            catch(QueryException $e){
                echo "wft2:" . $e;
            }            
        }

        try{
            Sentry::authenticate([
            'email'=>$fbuser['email'],
            'password'=>'ypn' . $fbuser['id']
            ],false); 

            return Redirect::back();
        }
        catch (\Cartalyst\Sentry\Users\LoginRequiredException $e)
        {
            echo $e;
        }
        catch (\Cartalyst\Sentry\Users\PasswordRequiredException $e)
        {
            echo $e;
        }
        catch (\Cartalyst\Sentry\Users\WrongPasswordException $e)
        {
           echo $e;
        }
        catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
           echo "wft3:" . $e;
        }
        catch (\Cartalyst\Sentry\Users\UserNotActivatedException $e)
        {
            echo $e;
        }

        // The following is only required if the throttling is enabled
        catch (\Cartalyst\Sentry\Throttling\UserSuspendedException $e)
        {
           echo $e;
        }
        catch (\Cartalyst\Sentry\Throttling\UserBannedException $e)
        {
            echo $e;
        }
     
    }

    public function postFb(){
        $fb = new \Facebook\Facebook([
          'app_id' => '1288241967885581',
          'app_secret' => 'b2d98c55d198bc3ddc68f3ef2113ad75',
          'default_graph_version' => 'v2.8',
          'grant_type' => 'client_credentials'
          //'default_access_token' => '{access-token}', // optional
        ]);        
         
         try{
             $post = $fb->post('/396057174078674/notifications/',  array(
              'access_token' => '1288241967885581|mguCkqxpA4G3xhzNgka3lxrj2xs',
              'href' => 'https://dualnown.000webhostapp.com/',  //this does link to the app's root, don't think this actually works, seems to link to the app's canvas page
              'template' => 'fafgajfg muon moi ban dual rank cung. Hay tra loi anh ay',
              'ref' => 'Notification sent ' //this is for Facebook's insight
            ));
         }catch(Facebook\Exceptions\FacebookResponseException $ex){
            echo'caiu cc';   
         }
       
    }
}
