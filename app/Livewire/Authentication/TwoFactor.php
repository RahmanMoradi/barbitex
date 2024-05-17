<?php

namespace App\Livewire\Authentication;

use App\Models\Card\Card;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use Google2FA;
use PragmaRX\Google2FA\Google2FA as Google2faVerify;
use PragmaRX\Google2FA\Support\Constants;

class TwoFactor extends Component
{
    public $QR_Image, $secret, $smsLogin, $code, $googleLogin, $emailLogin;

    public function mount()
    {
        $user = Auth::user();
        $this->smsLogin = Auth::user()->two_factor_type == 'sms';
        $this->emailLogin = Auth::user()->two_factor_type == 'email';
        $this->googleLogin = Auth::user()->two_factor_type == 'google';
        Google2FA::setAlgorithm(Constants::SHA512);
        if (!$user->google2fa_secret) {
            $this->secret = Google2FA::generateSecretKey();
            $user->update(['google2fa_secret' => $this->secret]);
        } else {
            $this->secret = $user->google2fa_secret;
        }
        Google2FA::getQrCodeService('svg');
        $this->QR_Image = Google2FA::getQRCodeInline(
            config('app.name'),
            $user->email,
            $user->google2fa_secret
        );
    }

    public function render()
    {
        return view('livewire.authentication.two-factor');
    }

    public function smsLoginActive()
    {
        Auth::user()->update([
            'two_factor_type' => $this->smsLogin ? 'sms' : 'none',
        ]);
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
        $this->mount();
    }

    public function emailLoginActive()
    {
        Auth::user()->update([
            'two_factor_type' => $this->emailLogin ? 'email' : 'none',
        ]);
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
        $this->mount();
    }

    public function googleLoginActive()
    {
        $user = Auth::user();

        // Enable Google2FA if Google Authenticator code matches secret
        $google2Fa = new Google2faVerify();
        $secret = $this->code;
        $valid = $google2Fa->verifyKey($user->google2fa_secret, $secret);
        // If Google2FA code is valid enable Google2FA
        if ($valid) {
            Auth::user()->update([
                'two_factor_type' => Auth::user()->two_factor_type == 'google' ? 'none' : 'google',
                'is_code_set' => 1
            ]);

            // Else redirect with invalid code error
        } else {
            flash(Lang::get('the operation failed'))->error()->livewwire($this);

            return back();
        }
        $this->code = '';
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
        $this->mount();
    }
}
