<?php

namespace App\Livewire\Authentication;

use App\Livewire\ValidateNotify;
use App\Models\User;
use App\Notifications\Admin\SendNotificationToAdmin;
use App\Rules\CardNumber;
use App\Rules\IranAlphabet;
use App\Rules\IsNotPersian;
use Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class Card extends Component
{
    use ValidateNotify;

    public $cards, $bank_name, $card_number, $account_number, $sheba;

    protected function rules()
    {
        return [
            'bank_name' => 'required',
            'card_number' => ['required','unique:cards', new CardNumber],
            'account_number' => ['numeric', new IsNotPersian],
            'sheba' => 'numeric|digits_between:24,24'
        ];
    }

    public function mount()
    {
        $this->cards = Auth::user()->cards;
    }

    public function render()
    {
        return view('livewire.authentication.card');
    }

    public function store()
    {
        $data = [
            'bank_name' => $this->bank_name,
            'card_number' => $this->card_number,
            'account_number' => $this->account_number,
            'sheba' => $this->sheba
        ];
        $this->validateNotify($data, $this->rules());
        $this->validate();

        \App\Models\Card\Card::create($data + [
                'user_id' => Auth::id()
            ]);
        $this->cards = Auth::user()->cards;

        flash(Lang::get('operation completed successfully'))->success()->livewire($this);

        return back();
    }
}
