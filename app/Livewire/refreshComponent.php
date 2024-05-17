<?php


namespace App\Livewire;


trait refreshComponent
{
    public function getListeners()
    {
        return [
            "refreshComponent" => '$refresh',
        ];
    }
}
