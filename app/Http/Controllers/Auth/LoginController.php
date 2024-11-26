<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected function credentials(\Illuminate\Http\Request $request)
    {
        return ['email' => $request->{$this->username()}, 'password' => $request->password,];
    }
    protected function sendFailedLoginResponse(\Illuminate\Http\Request $request)
    {
        if ( !User::where('email', $request->email)->first() ) {
            return redirect()->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors([
                    $this->username() => 'El email no es correcto',
                ]);
        }
        if ( !User::where('email', $request->email)->where('password', bcrypt($request->password))->first() ) {
            return redirect()->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors([
                    'password' => 'Contraseña Incorrecta ',
                ]);
        }
    }
    public function verificar_email(\Illuminate\Http\Request $request){
        $user=User::query()
            ->where('email',$request->email)->first();
        if($user == null){
            return redirect()->back()->withErrors([
                'email' => 'El correo no se encuentra registrado',
            ]);
        }else{
            $pregunta1=$user->seguridad->pregunta_1;
            $respuesta1=$user->seguridad->respuesta_1;
            $pregunta2=$user->seguridad->pregunta_2;
            $respuesta2=$user->seguridad->respuesta_2;
            return redirect()->back()->withInput($request->only($this->username(), 'remember'))->with([
                'status'=>'true',
                'success' => 'Correo Verificado Exitosamente',
                'pregunta1'=>$pregunta1,
                'status_preguntas'=>'false',
                'user_id'=>$user->id,
                'pregunta2'=>$pregunta2,
            ]);
        }

    }
    public function reset_pasword(){
        $pregunta1='';
        $respuesta1='';
        $pregunta2='';
        $respuesta2='';
        return view('/auth/passwords/reset')->with([
            'status'=>false,
            'status_preguntas'=>false,
            'pregunta1'=>$pregunta1,
            'pregunta2'=>$pregunta2,
            'respuesta1'=>$respuesta1,
            'respuesta2'=>$respuesta2,
        ]);
    }
    public function verificar_preguntas(\Illuminate\Http\Request $request){
        $user=User::query()
            ->where('id',$request->user_id)->first();
        $respuesta1=$user->seguridad->respuesta_1;
        $respuesta2=$user->seguridad->respuesta_2;
        if($user->seguridad->respuesta_1 == $request->respuesta1 && $user->seguridad->respuesta_2 == $request->respuesta2){
            return redirect()->back()->withInput($request->only($this->username(), 'remember'))->with([
                'status'=>'true',
                'status_preguntas'=>'true',
                'user_id'=>$user->id,
                'email'=>$user->email,
                'success' => 'Preguntas Verificadas Exitosamente',
                'respuesta1'=>strtoupper($respuesta1),
                'respuesta2'=>strtoupper($respuesta2),
            ]);
        }else{
            return redirect()->back()
                ->with([
                    'status'=>'false',
                    'status_preguntas'=>'false',
                    'error' => 'Las respuestas no coinciden',
                ]);
        }

    }
    public function updatecontraseña(\Illuminate\Http\Request $request){
        $user=User::query()
            ->where('id',$request->user_id)->first();
        $contra1=$request->contraseña;
        $contra2=$request->contraseña2;
        if($contra1 == $contra2){
            $user->update([
                'password'=>bcrypt($contra1),
            ]);
            return redirect()->to('login')->with([
                'success' => 'Contraseña Actualizada Exitosamente',
            ]);
        }else{
            return redirect()->back()
                ->with([
                    'status'=>'true',
                    'status_preguntas'=>'true',
                    'user_id'=>$user->id,
                    'email'=>$user->email,
                    'error' => 'Las respuestas no coinciden',
                ]);
        }

    }

}
