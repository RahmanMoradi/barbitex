<?php

namespace App\Livewire\Admin\Tournament;

use App\Livewire\ValidateNotify;
use App\Models\User;
use Livewire\Component;

class Tournament extends Component
{
    use ValidateNotify;

    public $tournament, $user, $listNumber, $edit, $model;

    public function render()
    {
        $tournaments = \App\Models\Tournament\Tournament::orderBy('number')->get();
        return view('livewire.admin.tournament.tournament', compact('tournaments'));
    }

    public function store()
    {
        $rules = [
            'tournament' => 'required',
            'user' => 'required|email|exists:users,email',
            'listNumber' => 'required|numeric'
        ];
        $data = [
            'tournament' => $this->tournament . '',
            'type' => $this->tournament . '',
            'user' => $this->user,
            'user_id' => User::whereEmail($this->user)->first()->id,
            'listNumber' => $this->listNumber,
            'number' => $this->listNumber,
        ];
        $this->validateNotify($data, $rules);
        $this->validate($rules);

        \App\Models\Tournament\Tournament::create($data);
        flash(trans('operation completed successfully'))->success()->livewire($this);
        $this->clear();
    }

    public function delete(\App\Models\Tournament\Tournament $tournament)
    {
        $tournament->delete();
        flash(trans('operation completed successfully'))->success()->livewire($this);
    }

    public function edit(\App\Models\Tournament\Tournament $tournament)
    {
        $this->user = optional($tournament->user)->email;
        $this->listNumber = $tournament->number;
        $this->tournament = $tournament->type;
        $this->edit = true;
        $this->model = $tournament;
    }

    public function update(\App\Models\Tournament\Tournament $tournament)
    {
        $rules = [
            'tournament' => 'required',
            'user' => 'required|email|exists:users,email',
            'listNumber' => 'required|numeric'
        ];
        $data = [
            'tournament' => $this->tournament . '',
            'type' => $this->tournament . '',
            'user' => $this->user,
            'user_id' => User::whereEmail($this->user)->first()->id,
            'listNumber' => $this->listNumber,
            'number' => $this->listNumber,
        ];
        $this->validateNotify($data, $rules);
        $this->validate($rules);
        $tournament->update($data);
        $this->clear();
        flash(trans('operation completed successfully'))->success()->livewire($this);
    }

    private function clear()
    {
        $this->user = '';
        $this->tournament = '';
        $this->listNumber = '';
        $this->edit = false;
        $this->model = null;
    }
}
