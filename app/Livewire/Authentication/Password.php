<?php

namespace App\Livewire\Authentication;

use App\Livewire\ValidateNotify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class Password extends Component
{
    use ValidateNotify;

    public $old_password, $password, $password_confirmation;

    protected $rules = [
        'old_password' => 'required',
        'password' => 'required|min:6|confirmed',
    ];

    public function render()
    {
        return view('livewire.authentication.password');
    }

    public function changePassword()
    {
        $data = [
            'old_password' => $this->old_password,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
        ];
        $this->validateNotify($data, $this->rules);
        $this->validate();
        $user = Auth::user();
        if (Hash::check($this->old_password, $user->password)) {
            $user->update([
                'password' => Hash::make($this->password)
            ]);
            flash(Lang::get('operation completed successfully'))->success()->livewire($this);
        } else {
            flash(Lang::get('the operation failed'))->error()->livewire($this);
        }
    }
}
