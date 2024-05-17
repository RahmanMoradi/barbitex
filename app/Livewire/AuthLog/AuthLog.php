<?php

namespace App\Livewire\AuthLog;

use Livewire\Component;
use \App\Models\Webazin\Auth\AuthLog as AuthLogModel;
use Livewire\WithPagination;

class AuthLog extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $user_id;

    public function mount($user_id = null)
    {
        $this->user_id = $user_id;
    }

    public function render()
    {
        $logs = $this->getLogs();
        return view('livewire.auth-log.auth-log', compact('logs'));
    }

    private function getLogs()
    {
        if ($this->user_id) {
            return AuthLogModel::where('user_id', $this->user_id)->orderByDesc('created_at')->paginate();
        }
        return AuthLogModel::orderByDesc('created_at')->paginate();
    }
}
