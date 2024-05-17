<?php

namespace App\Livewire\Vip;

use App\Models\Balance\Balance;
use App\Models\vip\VipPackage;
use App\Models\vip\VipUsers;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class Buy extends Component
{
    public $selectPack;

    public function render()
    {
        $packs = VipPackage::all();
        return view('livewire.vip.buy', compact('packs'));
    }

    public function pay()
    {
        $pack = VipPackage::find($this->selectPack);
        $vip = VipUsers::where('user_id', Auth::id())->first();
        if (Auth::user()->balance < $pack->price) {
            flash(Lang::get('balance insufficient'))->error()->livewire($this);
            return;
        }
        Wallet::create([
            'admin_id' => 0,
            'user_id' => Auth::id(),
            'currency' => 'IRT',
            'price' => -$pack->price,
            'description' => Lang::get('credit deduction for purchasing vip pack'),
            'type' => 'decrement',
            'status' => 'done'
        ]);
        Balance::createUnique('IRT', Auth::user(), -$pack->price);
        if ($vip) {
            $days = optional($this->vip)->expire_at > Carbon::now() ?
                Carbon::now()->diffInDays($vip->expire_at) : 0;

            $vip->update([
                'package_id' => $pack->id,
                'user_id' => Auth::id(),
                'expire_at' => $days > 0 ? Carbon::now()->addDays($days + $pack->days) : Carbon::now()->addDays($pack->days)
            ]);
        } else {
            VipUsers::create([
                'package_id' => $pack->id,
                'user_id' => Auth::id(),
                'expire_at' => Carbon::now()->addDays($pack->days),
                'start_at' => Carbon::now()
            ]);
        }
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
        return $this->redirect('/panel/vip');
    }
}
