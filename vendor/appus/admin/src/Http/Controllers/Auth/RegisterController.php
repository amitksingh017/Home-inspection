<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 08.01.2020
 */

namespace Appus\Admin\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Appus\Admin\Http\Controllers\Auth\Traits\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('admin_guest');
    }

    /**
     * @return string
     */
    public function redirectTo(): string
    {
        return route('dashboard');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'url' => $this->redirectPath()]);
        }

        return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $model = $this->getModel();
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . $model->getTable()],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
        if (config('admin.auth.terms_and_conditions_route')) {
            $rules['agree'] = ['required'];
        }
        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return mixed
     */
    protected function create(array $data)
    {
        $model = $this->getModel();
        return $model->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * @return Model
     */
    protected function getModel(): Model
    {
        $defaultGuard = config('auth.defaults.guard');
        $provider = config('auth.guards.' . $defaultGuard . '.provider');
        $model = config('auth.providers.' . $provider . '.model');
        return app($model);
    }

}
