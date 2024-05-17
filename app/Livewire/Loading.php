<?php

namespace App\Livewire;

trait Loading
{
    public function updating()
    {
        $this->emitTo(\App\Livewire\Layout\Loading::class,'loading');
    }

    public function updated()
    {

        $this->emitTo(\App\Livewire\Layout\Loading::class,'loading');
    }
}
