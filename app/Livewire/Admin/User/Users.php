<?php

namespace App\Livewire\Admin\User;

use App\Models\Balance\Balance;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    public $search;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        if (!$this->search) {
            $users = User::orderByDesc('created_at')->paginate();
        } else {
            $users = $this->filter();
        }
        $wrongBalance = Balance::whereRaw('balance < balance_free')->get();
        return view('livewire.admin.user.users', compact('users', 'wrongBalance'));
    }

    public function delete(User $user)
    {
        try {
            return DB::transaction(function () use ($user) {
                DB::table('user_documents')->where('user_id', $user->id)->delete();
                DB::table('balances')->where('user_id', $user->id)->delete();
                DB::table('wallets')->where('user_id', $user->id)->delete();
                DB::table('tickets')->where('user_id', $user->id)->delete();
                DB::table('market_orders')->where('user_id', $user->id)->delete();
                DB::table('cards')->where('user_id', $user->id)->delete();
                DB::table('auth_logs')->where('user_id', $user->id)->delete();
                DB::table('portfolios')->where('user_id', $user->id)->delete();
                DB::table('orders')->where('user_id', $user->id)->delete();

                $user->delete();
                flash(Lang::get('operation completed successfully'))->success()->livewire($this);
                $this->render();
            });
        } catch (\Exception $exception) {
            flash(Lang::get($exception->getMessage()))->error()->livewire($this);
        }
    }

    private function filter()
    {
        return User::where('name', 'LIKE', '%' . $this->search . '%')
            ->orWhere('id', 'LIKE', '%' . $this->search . '%')
            ->orWhere('email', 'LIKE', '%' . $this->search . '%')
            ->orWhere('mobile', 'LIKE', '%' . $this->search . '%')->paginate();
    }
}
