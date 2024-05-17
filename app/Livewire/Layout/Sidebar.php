<?php

namespace App\Livewire\Layout;

use App\Livewire\refreshComponent;
use App\Models\Card\Card;
use App\Models\Ticket\Ticket;
use App\Models\User\UserDocument;
use App\Models\Wallet;
use Livewire\Component;

class Sidebar extends Component
{
    use refreshComponent;

    public $decrementCount, $cardCount, $ticketCount, $documentCount;

    public function mount()
    {
        $this->documentCount = UserDocument::whereStatus('new')->count();
        $this->cardCount = Card::whereStatus('0')->count();
        $this->ticketCount = Ticket::whereIn('status', ['new', 'user'])->where('ticket_id', null)->count();
        $this->decrementCount = Wallet::whereStatus('new')->count();
    }

    public function render()
    {
        return view('livewire.layout.sidebar');
    }
}
