<?php

namespace CivicApp\Http\Controllers\Auth;

use App;
use CivicApp\BLL\Auth\AuthHandler;
use CivicApp\Entities\Auth\AppUser;
use CivicApp\Entities\Auth\Role as RoleEnt;
use CivicApp\Entities\Auth as AuthEntities;
use CivicApp\Models\Auth\Role;
use CivicApp\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Mockery\CountValidator\Exception;
use Psy\Util\Json;
use Validator;
use CivicApp\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use CivicApp\Utilities\Logger;
use CivicApp\Utilities\JsonMapper;
use CivicApp\BLL\Auth as BllAuth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';



    private $authHandler;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */

    protected $guard = 'webadmin';
    public function __construct(BllAuth\AuthHandler $handler)
    {
        $this->authHandler= $handler;
      //  $this->middleware('guest', ['except' => 'getLogout']);
       // $this->authHandler->hola();
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
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function getCreateAppUser()
    {
        return view('auth.CreateAppUser');
    }


    private static $rulesAppUser = [
        'username'              => 'required',
        'first_name'            => 'required',
        'last_name'             => 'required',
        'email'                 => 'required|email|unique:app_users',
        'password'              => 'required|min:6|max:20',
        'password_confirmation' => 'required|same:password'
    ];

    private static $messagesAppUser = [
        'username.required'     => 'El nombre de usuario es requerido',
        'first_name.required'   => 'El nombre es requerido',
        'last_name.required'    => 'El apellido es requerido',
        'email.required'        => 'El email es requerido',
        'email.email'           => 'El email es inválido',
        'email.unique'          => 'El email debe ser único',
        'password.required'     => 'La contraseña es requerida',
        'password.min'          => 'La contraseña necesita tener al menos 6 caracteres',
        'password.max'          => 'La contraseña sólo permite hasta 20 caracteres',
        'password_confirmation.same' => 'La contraseña y la confirmación de la contraseña deben coincidir',
        'password_confirmation.required' =>'La confirmación de contraseña es requerida'
    ];

    /**
     * @param Request $request
     * @param AppUser $appUser
     * @return $this|\Illuminate\View\View
     * @throws \CivicApp\Utilities\InvalidArgumentException
     * @throws \CivicApp\Utilities\JsonMapper_Exception
     */
    public function postCreateAppUser(Request $request, AppUser $appUser)
    {
        $methodName = 'postCreateAppUser';
        Logger::startMethod($methodName);
        try {
            $validator = Validator::make($request->all(), $this::$rulesAppUser, $this::$messagesAppUser);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $rolesView  = json_decode($request->input('hdnRoles'));

            $roles = new Collection();
            if($rolesView != null) {
                foreach ($rolesView as $role) {
                    $roleEntity = App::make(RoleEnt::class);
                    $roleEntity->id = $role->id;
                    $roleEntity->role_name = $role->role_name;

                    $roles->push($roleEntity);
                }
            }
            $appUser->username = $request->input('username');
            $appUser->first_name = $request->input('first_name');
            $appUser->last_name = $request->input('last_name');
            $appUser->email = $request->input('email');
            $appUser->password = bcrypt($request->input('password'));
           // $appUser->remember_token = $request->
            $appUser->roles = $roles;

            $this->authHandler->CreateUser($appUser);


//            $jm = new JsonMapper();
//            $user = $jm->map(
//                json_decode('{"str":"stringvalue"}'),
//                App::make(Role::class));







            // $appUser = App::make('CivicApp\Entities\Auth\AppUser');


            //$appUser->

            Logger::endMethod($methodName);
            return redirect()->route('authApp.login')
                ->with('status', 'success')
                ->with('message', 'Se ha registrado satisfactoriamente.');
        }
        catch(BllAuth\AuthValidateException $ex)
        {
            Logger::logError($methodName,$ex->getMessage());
            return redirect()->back()
                ->withErrors($ex->getMessage())
                ->withInput();
        }
        catch(Exception $ex)
        {
            Logger::logError($methodName,$ex->getMessage());
            return redirect()->back()
                ->withErrors('No se pudo crear el usuario, disculpe las molestias.')
                ->withInput();
        }

    }

    public function getLogin()
    {
        return view('auth.LoginApp');
    }

    public function postLogin(Request $request)
    {
        $email      = $request->input('email');
        $password   = $request->input('password');
        $remember   = $request->input('remember');


        if(  Auth::guard('webadmin')->attempt([
            'email'     => $email,
            'password'  => $password
        ], $remember == 1 ? true : false))
        {
            if( Auth::user()->hasRole('Admin'))
            {
                return redirect()->route('admin.home');
            }
            else
            {

                return redirect()->route('public.home');
            }



        }
        else
        {
            return redirect()->back()
                ->with('message','Incorrect email or password')
                ->with('status', 'danger')
                ->withInput();
        }

    }

    public function getLogout()
    {
        Auth::logout();

        return redirect()->route('authApp.login')
            ->with('status', 'success')
            ->with('message', 'Logged out');

    }

    public function getLogoutSocial()
    {
        \Auth::guard('websocial')->logout();

        return redirect()->route('public.home')
            ->with('status', 'success')
            ->with('message', 'Logged out');

    }

    public function getSocialRedirect( $provider )
    {
        $providerKey = \Config::get('services.' . $provider);
        if(empty($providerKey))
            return view('pages.status')
                ->with('error','No such provider');

        return Socialite::driver( $provider )->redirect();

    }

    public function getSocialHandle( $provider )
    {
        $user = Socialite::driver( $provider )->user();


        $socialUser = App::make(AuthEntities\SocialUser::class);

        $nameSplit = explode(" ", $user->name,2);
        $socialUser->username = $user->name;
        $socialUser->first_name = $nameSplit[0];
        $socialUser->last_name = $nameSplit[1];
        if($provider == 'twitter')
            $socialUser->email = $user->id.'@'.'twitter.com';
        else
            $socialUser->email = $user->email;
        $socialUser->avatar = $user->avatar;
        $socialUser->provider = $provider;
        $socialUser->provider_id = $user->id;

        //Check is this email present



        $socialUser = $this->authHandler->CreateOrUpdateSocialUser($socialUser);

        /*$userCheck = User::where('email', '=', $user->email)->first();
        if(!empty($userCheck))
        {
            $socialUser = $userCheck;
        }
        else
        {
            $sameSocialId = Social::where('social_id', '=', $user->id)->where('provider', '=', $provider )->first();

            if(empty($sameSocialId))
            {
                //There is no combination of this social id and provider, so create new one
                $newSocialUser = new User;
                $newSocialUser->email              = $user->email;
                $name = explode(' ', $user->name);
                $newSocialUser->first_name         = $name[0];
                $newSocialUser->last_name          = $name[1];
                $newSocialUser->save();

                $socialData = new Social;
                $socialData->social_id = $user->id;
                $socialData->provider= $provider;
                $newSocialUser->social()->save($socialData);

                // Add role
                $role = Role::whereName('user')->first();
                $newSocialUser->assignRole($role);

                $socialUser = $newSocialUser;
            }
            else
            {
                //Load this existing social user
                $socialUser = $sameSocialId->user;
            }

        }
        */

        Auth::guard('websocial')->loginUsingId($socialUser->id);
      //  $this->auth->guard('websocial')->login($socialUser, true);

        return redirect()->route('public.home');

        if( $this->auth->user()->hasRole('user'))
        {
            return redirect()->route('user.home');
        }

        if( $this->auth->user()->hasRole('administrator'))
        {
            return redirect()->route('admin.home');
        }

        return \App::abort(500);
    }



}
