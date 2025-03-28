<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Куда перенаправлять пользователей после входа.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Создать новый экземпляр контроллера.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Получить поле для аутентификации.
     *
     * @return string
     */
    public function username()
    {
        return 'phone';
    }

    /**
     * Валидация данных входа.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => ['required', 'string', 'regex:/^[0-9]{10}$/'],
            'password' => 'required|string',
        ]);
    }

    /**
     * Получить учетные данные для попытки входа.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');
        $credentials[$this->username()] = '+7' . $credentials[$this->username()];
        return $credentials;
    }
}
