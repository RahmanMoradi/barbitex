<?php

namespace App\Livewire\Admin\Services;

use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use phpseclib\Net\SSH2;

class Services extends Component
{
    public function render()
    {
        $ssh = new SSH2(env('SSHIP'));
        if (!$ssh->login(env('SSHUSER'), env('SSHPASSWORD'))) {
            flash(Lang::get('failed to connect to server'))->error()->livewire($this);
            $pm2Status = Lang::get('failed to connect to server');
            $supervisorctlStatus = Lang::get('failed to connect to server');
        } else {
            $pm2Status = $ssh->exec('pm2 status 0');
            $supervisorctlStatus = $ssh->exec('supervisorctl status all');
        }
        return view('livewire.admin.services.services', compact('pm2Status', 'supervisorctlStatus'));
    }
}
