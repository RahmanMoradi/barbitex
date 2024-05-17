<?php

namespace App\Livewire\Panel\Order;

use App\Models\Order\Order;
use Livewire\Component;

class Show extends Component
{
    public $order;

    public function mount(Order $order)
    {
        if ($order->user_id !== \Auth::id()) {
            return redirect('panel');
        }
        $this->order = $order;
    }

    public function render()
    {
        return view('livewire.panel.order.show');
    }
}
