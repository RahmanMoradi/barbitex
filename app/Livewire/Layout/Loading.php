<?php

namespace App\Livewire\Layout;

use Livewire\Component;

class Loading extends Component
{
    public $loading;

    public function getListeners()
    {
        return [
            "loading" => 'loadingChange',
        ];
    }

    public function mount()
    {
        $this->loading = false;
    }

    public function render()
    {
        return view('livewire.layout.loading');
    }

    public function loadingChange()
    {
        $this->loading = !$this->loading;
    }
}
