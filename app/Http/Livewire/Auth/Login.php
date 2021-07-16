<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $username;
    public $password;
    public function render()
    {
        return view('livewire.auth.login');
    }

    public function login()
    {
        $this->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $this->username)->first();

        if (!$user) {
            return $this->emit('showAlertError', ['msg' => 'Akun tidak terdaftar']);
        }


        $credentials = [
            'username' => $this->username,
            'password' => $this->password
        ];
        if (Auth::attempt($credentials)) {
            // if success login
            if (!$user->roles()->first()) {
                return redirect(route('dashboard'));
            }

            return redirect(route('client.home'));
        } else {
            return $this->emit('showAlertError', ['msg' => 'Username atau kata sandi salah']);
        }
    }
}
