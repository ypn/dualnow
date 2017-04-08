<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Cartalyst\Sentry\Users\LoginRequiredException;
use Cartalyst\Sentry\Users\PasswordRequiredException;
use Cartalyst\Sentry\Users\UserExistsException;
use App\Entities\NoticesUsers;
use Illuminate\Database\QueryException;
use App\Helpers\Utilities;
use Validator;
use Request;
use Sentry;
use Facebook;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */


    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create()
    {        
        $input = Request::all();   
        $validator = $this->validator($input);      
        if(!$validator->fails()){          
            try{
                $user = Sentry::register([
                'name' => trim(strip_tags($input['name'])),
                'email' => trim(strip_tags($input['email'])),
                'password' => trim(strip_tags($input['password'])),
                'lanes'=>serialize([]),
                'alias'=>Utilities::slug(trim(strip_tags($input['name'])),'users')
                ]);

                //push notification for user change their profile
                $notification = new NoticesUsers();
                $notification->receiver_id = $user->id;
                $notification->trigger_id = 0;//He thong
                $notification->notice_id = 0; //Thong bao update profile
                $notification->save();


                return json_encode(['code'=>100,'status'=>"success"]);
            }             
            catch (PasswordRequiredException $e)
            {               
                
                return json_encode(['code'=>100,'status'=>"pass_required"]);
            }
            catch (UserExistsException $e)
            {              
               
                return json_encode(['code'=>100,'status'=>"user_exist"]);
            }

            catch(QueryException $e){
                return json_encode(['code'=>100,'status'=>"query_exception"]);
            }

            
        }        
    }    
}
