<?php

namespace App\Livewire\Panel;

use Livewire\Component;

class Tournament extends Component
{
    public function render()
    {
        $tournaments = \App\Models\Tournament\Tournament::orderBy('number')->get();
        return view('livewire.panel.tournament', compact('tournaments'));
    }

    function get_starred($str)
    {
        $str = explode('@', $str);
        $mail = $str[1];
        $str = $str[0];
        $str_array = str_split($str);
        foreach ($str_array as $key => $char) {
            if ($key == 0 || $key == count($str_array) - 1) continue;
            if ($char != '-') $str[$key] = '*';
        }
        return $str . '@' . $mail;
    }
}
