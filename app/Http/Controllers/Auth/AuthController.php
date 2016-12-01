<?php

namespace CivicApp\Http\Controllers\Auth;

use App;
use Auth;
use CivicApp\BLL\Auth\AuthHandler;
use CivicApp\Entities\Auth\AppUser;
use CivicApp\Entities\Auth\Role as RoleEnt;
use CivicApp\Entities\Auth as AuthEntities;
use CivicApp\Models\Auth\Role;
use CivicApp\User;
use CivicApp\Utilities\CaptchaTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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
use CivicApp\Entities\Auth\SocialUser;

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

    use AuthenticatesAndRegistersUsers, ThrottlesLogins, CaptchaTrait;

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
        $this->authHandler = $handler;
        //  $this->middleware('guest', ['except' => 'getLogout']);
        // $this->authHandler->hola();
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
       /* return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);*/
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

    private static $rulesSocialUser = [
        'username'              => 'required|unique:social_users',
        'first_name'            => 'required',
        'last_name'             => 'required',
        'gender'                => 'required',
        'email'                 => 'required|email|unique:social_users',
        'password'              => 'required|min:6|max:20',
        'password_confirmation' => 'required|same:password',
        'g-recaptcha-response'  => 'required',
        'captcha'               => 'required|min:1'
    ];

    private static $messagesValidationUser = [
        'username.required'              => 'El nombre de usuario es requerido',
        'username.unique'                => 'Ya existe una cueanta creada con este nombre de usuario, el nombre de usuario es requerido',
        'first_name.required'            => 'El nombre es requerido',
        'last_name.required'             => 'El apellido es requerido',
        'email.required'                 => 'El email es requerido',
        'email.email'                    => 'El email es inválido',
        'email.unique'                   => 'Ya existe una cuenta creada con este mail, el email debe ser único',
        'password.required'              => 'La contraseña es requerida',
        'password.min'                   => 'La contraseña necesita tener al menos 6 caracteres',
        'password.max'                   => 'La contraseña sólo permite hasta 20 caracteres',
        'password_confirmation.same'     => 'La contraseña y la confirmación de la contraseña deben coincidir',
        'password_confirmation.required' => 'La confirmación de contraseña es requerida',
        'gender'                         => 'El género es requerido.',
        'captcha.min'                    => 'Captcha incorrecto, por favor intente de nuevo.',
        'g-recaptcha-response.required'  => 'Captcha es requerido'
    ];


    /**
     * @param Request $request
     * @param AppUser $appUser
     *
     * @return $this|\Illuminate\View\View
     * @throws \CivicApp\Utilities\InvalidArgumentException
     * @throws \CivicApp\Utilities\JsonMapper_Exception
     */
    public function postCreateAppUser(Request $request, AppUser $appUser)
    {
        $methodName = 'postCreateAppUser';
        Logger::startMethod($methodName);
        try {
            $validator = Validator::make($request->all(), $this::$rulesAppUser, $this::$messagesValidationUser);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $rolesView = json_decode($request->input('hdnRoles'));

            $roles = new Collection();
            if ($rolesView != null) {
                foreach ($rolesView as $role) {
                    $roleEntity            = App::make(RoleEnt::class);
                    $roleEntity->id        = $role->id;
                    $roleEntity->role_name = $role->role_name;

                    $roles->push($roleEntity);
                }
            }
            $appUser->username   = $request->input('username');
            $appUser->first_name = $request->input('first_name');
            $appUser->last_name  = $request->input('last_name');
            $appUser->email      = $request->input('email');
            $appUser->password   = bcrypt($request->input('password'));
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

            return redirect()->route('authApp.login')->with('status', 'success')->with('message',
                    'Se ha registrado satisfactoriamente.');
        } catch (BllAuth\AuthValidateException $ex) {
            Logger::logError($methodName, $ex->getMessage());

            return redirect()->back()->withErrors($ex->getMessage())->withInput();
        } catch (Exception $ex) {
            Logger::logError($methodName, $ex->getMessage());

            return redirect()->back()->withErrors('No se pudo crear el usuario, disculpe las molestias.')->withInput();
        }

    }


    public function getLogin()
    {
        if (Auth::guard('webadmin')->check()) {
            return redirect()->route('admin.home');
        }
        if (Auth::guard('websocial')->check()) {
            return redirect()->route('public.home');
        }

        return view('auth.LoginApp');
    }


    public function postLogin(Request $request)
    {
        if (Auth::guard('webadmin')->check()) {
            return redirect()->route('admin.home');
        }

        $email    = $request->input('email');
        $password = $request->input('password');
        $remember = $request->input('remember');

        if (Auth::guard('webadmin')->attempt([
            'email'    => $email,
            'password' => $password
        ], $remember == 1 ? true : false)
        ) {

            return redirect()->route('admin.home');

        } else {
            return redirect()->back()->with('message', 'Email o Password Incorrecto')->with('status',
                    'danger')->withInput();
        }

    }


    public function postSocialLogin(Request $request)
    {
        $method = 'postSocialLogin';
        try {
            Logger::startMethod($method);

            if (Auth::guard('websocial')->check()) {
                Logger::endMethod($method);

                return response()->json([
                    'status' => 'OK'
                ]);
            }

            if ( ! $request->has('email') || empty( $request->email ) || ! $request->has('password') || empty( $request->password )) {
                $returnHTML = view('includes.status')->with('status', 'danger')->with('message',
                    'El email y el password son requeridos.')->render();

                Logger::endMethod($method);

                return response()->json([
                    'status'      => 'Error',
                    'htmlMessage' => $returnHTML
                ]);
            }



            $email    = $request->input('email');
            $password = $request->input('password');
            $remember = $request->input('remember');

            if($this->authHandler->IsUserSpamer($email))
            {
                $returnHTML = view('includes.status')->with('status', 'danger')->with('message',
                    trans('autherrorcodes.0009'))->render();

                Logger::endMethod($method);

                return response()->json([
                    'status'      => 'Error',
                    'htmlMessage' => $returnHTML
                ]);
            }

            if (Auth::guard('websocial')->attempt([
                'email'    => $email,
                'password' => $password,
                'activated'=> 1
            ], $remember)
            ) {
                Logger::endMethod($method);



                return response()->json([
                    'status' => 'OK'
                ]);
            } else {

                if($this->authHandler->IsPendingActivation($email))
                {
                    throw new BllAuth\AuthValidateException('El usuario aún no está activo, revise su correo o si desea volver a recibir el link de confirmación presioone el siquiente link
                        <br><a style="cursor: pointer;" data-route="'.route('resend_mail_confirmation').'" data-email="'.$email.'" onclick="CivicApp.RegisterUser.ResendConfirmationEmail(this)">Reenviar el código de activación</a>');

                }

                throw new BllAuth\AuthValidateException('Email o Password Incorrecto.');


            }

        }catch ( BllAuth\AuthValidateException $ex)
        {
            $returnHTML = view('includes.status')->with('status', 'danger')->with('message',
                $ex->getMessage())->render();

            Logger::logError($method, $ex->getMessage());

            return response()->json([
                'status'      => 'Error',
                'htmlMessage' => $returnHTML
            ]);
        }
        catch (\Exception $ex) {
            $returnHTML = view('includes.status')->with('status', 'danger')->with('message',
                'Se ha producido un error inesperado, disculpe las molestias.')->render();

            Logger::endMethod($method);

            return response()->json([
                'status'      => 'Error',
                'htmlMessage' => $returnHTML,
                'errorDetail' => $ex->getMessage() . '.' . $ex->getTraceAsString()
            ]);
        }

    }

    public  function postResendConfirmation(Request $request)
    {
        $method= 'postResendConfirmation';
        Logger::startMethod('postResendConfirmation');
        try {
            if(!$request->has('email'))
            {
                throw new BllAuth\AuthValidateException('No se ha recibido el email correctamente.');
            }
            $this->authHandler->ResendEmailConfirmation($request->email);

            $returnHTML = view('includes.status')->with('status', 'success')->with('message',
                'Se ha enviado el correa de activación correctamente, verifique su correo, gracias.')->render();

            Logger::endMethod($method);

            return response()->json([
                'status'      => 'OK',
                'htmlMessage' => $returnHTML,
            ]);
        }
        catch(BllAuth\AuthValidateException $ex)
        {
            $returnHTML = view('includes.status')->with('status', 'danger')->with('message',
                $ex->getMessage())->render();

            Logger::endMethod($method);

            return response()->json([
                'status'      => 'Error',
                'htmlMessage' => $returnHTML,
            ]);
        }
        catch(\Exception $ex)
        {
            $returnHTML = view('includes.status')->with('status', 'danger')->with('message',
                'Se ha producido un error inesperado, disculpe las molestias.')->render();

            Logger::endMethod($method);

            return response()->json([
                'status'      => 'Error',
                'htmlMessage' => $returnHTML,
                'errorDetail' => $ex->getMessage() . '.' . $ex->getTraceAsString()
            ]);
        };
    }


    public function getLogout()
    {
        Auth::guard('webadmin')->logout();

        return redirect()->route('authApp.login')->with('status', 'success')->with('message', 'Logged out');

    }


    public function getLogoutSocial()
    {
        \Auth::guard('websocial')->logout();

        return redirect()->route('public.home')->with('status', 'success')->with('message', 'Logged out');

    }


    public function getSocialRedirect($provider)
    {
        $providerKey = \Config::get('services.' . $provider);
        if (empty( $providerKey )) {
            return view('pages.status')->with('error', 'No such provider');
        }

        return Socialite::driver($provider)->redirect();

    }


    /**
     * @param $provider
     *
     * @return \Illuminate\Http\RedirectResponse|void
     * @throws BllAuth\AuthValidateException
     */
    public function getSocialHandle($provider)
    {
        try {

            $user = Socialite::driver($provider)->user();

            $socialUser = App::make(AuthEntities\SocialUser::class);

            $nameSplit              = explode(" ", $user->name, 2);
            $socialUser->username   = $user->name;
            $socialUser->first_name = $nameSplit[0];
            $socialUser->last_name  = $nameSplit[1];
            if ($provider == 'twitter') {
                $socialUser->email = $user->id . '@' . 'twitter.com';
            } else {
                $socialUser->email = $user->email;
            }
            $socialUser->avatar      = $user->avatar;
            $socialUser->provider    = $provider;
            $socialUser->provider_id = $user->id;

            //Check is this email present

            $socialUser = $this->authHandler->CreateOrUpdateSocialUser($socialUser);

            Auth::guard('websocial')->loginUsingId($socialUser->id);

            //  $this->auth->guard('websocial')->login($socialUser, true);

            return redirect()->route('public.home');

        } catch (BllAuth\AuthValidateException  $ex) {
            return redirect()->route('public.home')->withErrors([ $ex->getMessage() ]);
        } catch (\Exception $ex) {
            return \App::abort(500);
        }


    }


    public function postCreateSocialUser(Request $request)
    {
        $methodName = 'postCreateAppUser';
        Logger::startMethod($methodName);
        try {
            if ($request->has('user')) {

                $user = json_decode($request->user);

                $validator = Validator::make([
                    'username'              => $user->username,
                    'last_name'             => $user->last_name,
                    'first_name'            => $user->first_name,
                    'email'                 => $user->email,
                    'gender'                => $user->gender,
                    'password'              => $user->password,
                    'password_confirmation' => $user->password_confirmation,
                    'g-recaptcha-response'  => $request['g-recaptcha-response'],
                    'captcha'               => $this->captchaCheck()
                ], $this::$rulesSocialUser, $this::$messagesValidationUser);

                if ($validator->fails()) {

                    $returnHTML = view('includes.errors')->withErrors($validator)->render();

                    return response()->json([
                        'status'      => 'Error',
                        'htmlMessage' => $returnHTML
                    ]);

                }

                $newUser             = App::make(SocialUser::class);
                $newUser->username   = $user->username;
                $newUser->first_name = $user->first_name;
                $newUser->last_name  = $user->last_name;
                $newUser->email      = $user->email;
                $newUser->password   = bcrypt($user->password);
                $newUser->gender     = $user->gender;

                if ($user->gender == 'M') {
                    $newUser->avatar = env('AVATAR_M');
                } else {
                    $newUser->avatar = env('AVATAR_F');
                }

                $this->authHandler->CreateOwnUser($newUser,
                    isset( $request->avatarUpload ) ? $request->avatarUpload : null);

                $returnHTML = view('includes.status')->with('status', 'success')->with('message',
                    'Se ha registrado satisfactoriamente.Verifique su dirección de correo para activar la cuenta.')->render();
                Logger::endMethod($methodName);

                return response()->json([
                    'status'      => 'OK',
                    'htmlMessage' => $returnHTML
                ]);

            }
        } catch (BllAuth\AuthValidateException $ex) {
            Logger::logError($methodName, $ex->getMessage());
            $returnHTML = view('includes.status')->with('status', 'danger')->with('message',
                $ex->getMessage())->render();

            return response()->json([
                'status'      => 'Error',
                'htmlMessage' => $returnHTML
            ]);
        } catch (\Exception $ex) {
            Logger::logError($methodName, $ex->getMessage());
            $returnHTML = view('includes.status')->with('status', 'danger')->with('message',
                $ex->getMessage())->render();

            return response()->json([
                'status'      => 'Error',
                'htmlMessage' => $returnHTML
            ]);
        }

    }


    public function getConfirm($confirmation_code)
    {
        $methodName='postConfirm';
        try {

            Logger::startMethod($methodName);
            if ( ! $confirmation_code) {
                throw new BllAuth\AuthValidateException('');
            }
            else
            {
                $userId = $this->authHandler->ConfirmUser($confirmation_code);
                Auth::guard('websocial')->loginUsingId($userId);
                Logger::endMethod($methodName);
                return redirect()->route('public.home');
            }

        } catch (BllAuth\AuthValidateException $ex) {
            Logger::logError($methodName, $ex->getMessage());
            return redirect()->route('public.home')->withErrors([ $ex->getMessage() ]);


        } catch (\Exception $ex) {
            Logger::logError($methodName, $ex->getMessage());
            return redirect()->route('public.home')->withErrors([ $ex->getMessage() ]);
        }
    }
}
