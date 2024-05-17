<?php

namespace App\Livewire\Authentication;

use App\Http\Controllers\Traits\General\Uploadable;
use App\Livewire\ValidateNotify;
use App\Models\User\UserDocument;
use App\Models\User\ValidCode;
use App\Rules\IranAlphabet;
use App\Rules\IranMobile;
use App\Rules\NationalCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Document extends Component
{
    use ValidateNotify, WithFileUploads, Uploadable;

    public $mobile, $name, $national_code, $birthday, $docs, $code, $send,$email;

    protected function rules()
    {
        return [
            'national_code' => ['required', new NationalCode, 'unique:users,national_code,' . Auth::id()],
            'birthday' => 'required',
            'name' => ['required', new IranAlphabet],
            'docs' => 'required|image',
        ];
    }

    protected function smsRules()
    {
        return [
            'mobile' => ['required', Rule::unique('users')->ignore(Auth::id()), new IranMobile],
        ];
    }

    protected function emailRules()
    {
        return [
            'email' => ['required', Rule::unique('users')->ignore(Auth::id()), 'email'],
        ];
    }

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->national_code = $user->national_code;
        $this->birthday = $user->birthday;
        $this->mobile = $user->mobile;
        $this->email = $user->email;
        $this->send = 0;
    }

    public function render()
    {
        return view('livewire.authentication.document');
    }

    public function store()
    {
        $data = [
            'national_code' => $this->national_code,
            'birthday' => $this->birthday,
            'name' => $this->name,
            'docs' => $this->docs,
        ];
        $this->validateNotify($data, $this->rules());
        $this->validate();
        $user = Auth::user();
        if ($user->docs && $user->docs->status == 'new') {
            flash(Lang::get('you have already submitted your documents, wait for confirmation'))->error();

            return back();
        }
        if ($user->docs && $user->docs->status == 'accept') {
            flash(Lang::get('you have already submitted your documents and your document has been verified'))->error();

            return back();
        }
        if ($user->docs) {
            Storage::disk('public')->delete($user->docs->title);
            $user->docs->update([
                'title' => $this->uploadFile('docs/image/', $this->docs),
                'status' => 'new'
            ]);
        } else {
            UserDocument::create([
                'user_id' => $user->id,
                'title' => $this->uploadFile('docs/image/', $this->docs)
            ]);
        }
        $user->update($data);
        flash(Lang::get('operation completed successfully'))->success();
        return $this->redirect('/panel/authentication/profile');
    }

    public function sendSms()
    {
        $data = [
            'mobile' => $this->mobile,
        ];
        $this->validateNotify($data, $this->smsRules());
        $this->validate($this->smsRules());

        $check = ValidCode::where('user_id', Auth::id())->count();
        if ($check > 0) {
            flash(Lang::get('you have just requested a code'))->error()->livewire($this);
        } else {
            Auth::user()->update($data);
            Auth::user()->sendMobileVerificationNotification();
            $this->send = 1;
            flash(Lang::get('code send'))->success()->livewire($this);
        }
    }

    public function ValidateSms()
    {
        $check = ValidCode::where('user_id', Auth::id())->first();
        $code = $check?->code === $this->code;
        if ($code) {
            Auth::user()->markMobileAsVerified();
            flash(Lang::get('your mobile number has been confirmed'))->success()->livewire($this);
            $check->delete();
            return $this->redirect('/panel/authentication/profile');
        } else {
            flash(Lang::get('code is invalid'))->error()->livewire($this);
        }
    }

    public function sendEmail()
    {
        $data = [
            'email' => $this->email,
        ];
        $this->validateNotify($data, $this->emailRules());
        $this->validate($this->emailRules());

        $check = ValidCode::where('user_id', Auth::id())->count();
        if ($check > 0) {
            flash(Lang::get('you have just requested a code'))->error()->livewire($this);
        } else {
            Auth::user()->update($data);
            Auth::user()->sendEmailVerificationNotification();
            $this->send = 1;
            flash(Lang::get('code send'))->success()->livewire($this);
        }
    }

    public function ValidateEmail()
    {
        $check = ValidCode::where('user_id', Auth::id())->first();
        $code = $check->code === $this->code;
        if ($code) {
            Auth::user()->markEmailAsVerified();
            flash(Lang::get('your email number has been confirmed'))->success()->livewire($this);
            $check->delete();
            return $this->redirect('/panel/authentication/profile');
        } else {
            flash(Lang::get('code is invalid'))->error()->livewire($this);
        }
    }
}
