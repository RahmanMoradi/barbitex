<?php

namespace App\Livewire\Admin\Wallet;

use App\Jobs\User\Notification\SendNotificationToUserJob;
use App\Livewire\Layout\Sidebar;
use App\Livewire\refreshComponent;
use App\Models\Balance\Balance;
use App\Models\User;
use App\Models\Wallet;
use App\Notifications\Admin\SendNotificationToAdmin;
use App\Notifications\Test\TestNotification;
use Illuminate\Notifications\Events\BroadcastNotificationCreated;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use Livewire\WithPagination;

class DecrementRequest extends Component
{
    use WithPagination, refreshComponent;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $wallets = Wallet::whereStatus('new')
            ->orderByDesc('created_at')->paginate();
        return view('livewire.admin.wallet.decrement-request', compact('wallets'));
    }

    public function operator(Wallet $wallet)
    {
        if ($wallet->admin_id == null) {
            $wallet->update([
                'admin_id' => Auth::guard('admin')->id()
            ]);
            flash(Lang::get('operation completed successfully'))->success()->livewire($this);
        } else {
            flash(Lang::get('already selected by another operator'))->error()->livewire($this);
        }
    }

    public function sendToUser(Wallet $wallet)
    {
        if ($this->checkIsNew($wallet) && $this->checkAmin($wallet)) {
            if ($wallet->type == 'decrement') {
                if ($wallet->currency != 'IRT') {
                    $wallet->currencyRelation->service()->withdraw($wallet);
                } else {
                    $wallet->update([
                        'status' => 'done',
                        'description' => Lang::get('deposited to your bank account')
                    ]);
                }
            } else {
                $wallet->update([
                    'status' => 'done'
                ]);
                Balance::createUnique($wallet->currency, User::find($wallet->user_id), $wallet->price);
            }
            flash(Lang::get('operation completed successfully'))->success()->livewire($this);
        }
        $this->emitTo(Sidebar::class, 'refreshComponent');
    }

    public function pay(Wallet $wallet, $status)
    {
        $wallet->update([
            'status' => $status,
            'description' => $wallet->description . '  ' . Lang::get('admin description: deposited to your account by the admin')
        ]);
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
        $this->render();
    }

    public function cancel(Wallet $wallet)
    {
        if ($this->checkAmin($wallet)) {
            if ($wallet->type == 'decrement') {
                Balance::createUnique($wallet->currency, User::find($wallet->user_id), -$wallet->price);
            }
            $wallet->update([
                'status' => 'cancel',
                'description' => Lang::get('canceled by admin')
            ]);
        }
        $this->emitTo(Sidebar::class, 'refreshComponent');
    }

    private function checkAmin(Wallet $wallet)
    {
        if ($wallet->admin_id != Auth::guard('admin')->id()) {
            flash(Lang::get('illegal access'))->error()->livewire($this);
            return 0;
        }
        return 1;
    }

    private function checkIsNew(Wallet $wallet)
    {
        return $wallet->status == 'new';
    }
}
