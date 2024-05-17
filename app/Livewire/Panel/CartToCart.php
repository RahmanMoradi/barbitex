<?php

namespace App\Livewire\Panel;

use App\Helpers\Helper;
use App\Livewire\ValidateNotify;
use App\Models\Card\Card;
use App\Models\Ticket\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class CartToCart extends Component
{
    use ValidateNotify;

    public $origin_cart, $goal_cart, $amount;

    public function render()
    {
        $cards = Card::where('user_id', auth()->id())->where('status', '1')->get();
        $admin_cards = Helper::getAdminCarts();
        return view('livewire.panel.cart-to-cart', compact('cards', 'admin_cards'));
    }

    public function submit()
    {
        $this->requestValidate();
        $amount = number_format($this->amount);
        $message = 'رسید تراکنش:';
        $message .= '<hr>';
        $message .= "شماره کارت مبدا: $this->origin_cart";
        $message .= '<hr>';
        $message .= "شماره کارت مقصد: $this->goal_cart";
        $message .= '<hr>';
        $message .= "مبلغ: $amount";
        $data = [
            'subject' => 'رسید کارت به کارت',
            'message' => $message,
            'category_id' => 1,
        ];
        Ticket::Create($data + [
                'user_id' => Auth::id(),
                'role' => 'user',
                'status' => 'new',
            ]);
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
        $this->reset();
    }

    private function requestValidate()
    {
        $data = [
            'origin_cart' => $this->origin_cart,
            'goal_cart' => $this->goal_cart,
            'amount' => $this->amount,
        ];
        $rules = [
            'origin_cart' => 'required|exists:cards,card_number',
            'goal_cart' => 'required',
            'amount' => 'required|numeric|min:100000',
        ];

        $this->validateNotify($data, $rules);
        $this->validate($rules);
    }
}
