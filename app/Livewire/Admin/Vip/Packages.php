<?php

namespace App\Livewire\Admin\Vip;

use App\Livewire\ValidateNotify;
use App\Models\Balance\Balance;
use App\Models\User;
use App\Models\vip\VipPackage;
use App\Models\vip\VipUsers;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Packages extends Component
{
    use ValidateNotify, WithPagination, WithFileUploads;

    public $collapse = true,
        $pack = ['id' => '', 'title' => '', 'image' => '', 'days' => '', 'price' => '', 'description' => ''],
        $buy = ['user_id' => '', 'pack' => '', 'user' => ''],
        $packs;

    public function mount()
    {
        $this->packs = VipPackage::all();
    }

    public function render()
    {
        $actives = VipUsers::paginate();
        return view('livewire.admin.vip.packages', compact('actives'));
    }

    public function storePack()
    {
        $rule = [
            'pack.title' => 'required',
            'pack.days' => 'required',
            'pack.price' => 'required',
        ];
        $data = [
            'pack' => [
                'id' => $this->pack['id'],
                'title' => $this->pack['title'],
                'days' => $this->pack['days'],
                'price' => $this->pack['price'],
                'description' => $this->pack['description'],
            ]
        ];
        $this->validateNotify($data, $rule);
        $this->validate($rule);
        if (isset($data['pack']['id']) && $data['pack']['id'] != '') {
            $vipPack = VipPackage::find($data['pack']['id']);
            $data['pack']['image'] = ($this->pack['image'] != null || $this->pack['image'] != "") ?
                $this->pack['image']->storePublicly('vip/image', 'public') :
                str_replace('/uploads', '', $vipPack->image);

            $vipPack->update($data['pack']);
        } else {
            $data['pack']['image'] = ($this->pack['image'] != null || $this->pack['image'] != "") ?
                $this->pack['image']->storePublicly('vip/image', 'public') : '';

            VipPackage::create($data['pack']);
        }
        $this->clear();
        $this->mount();
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
    }

    private function clear()
    {
        $this->pack['id'] = '';
        $this->pack['title'] = '';
        $this->pack['image'] = null;
        $this->pack['days'] = '';
        $this->pack['price'] = '';
        $this->pack['description'] = '';
        $this->dispatchBrowserEvent('clearImage');
    }

    public function deActive(VipUsers $vipUser)
    {
        $vipUser->update([
            'expire_at' => Carbon::now()
        ]);

        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
    }

    public function edit(VipPackage $vipPackage)
    {
        $this->collapse = false;
        $this->pack['id'] = $vipPackage->id;
        $this->pack['title'] = $vipPackage->title;
        $this->pack['price'] = $vipPackage->price;
        $this->pack['days'] = $vipPackage->days;
        $this->pack['description'] = $vipPackage->description;
    }

    public function delete(VipPackage $vipPackage)
    {
        $vipPackage->delete();
        $this->mount();

        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
    }

    public function buy()
    {
        if ($this->buy['user_id'] != '') {
            $this->buy['user'] = User::find($this->buy['user_id']);
            if (!$this->buy['user']) {
                flash(Lang::get('User not found!'))->error()->livewire($this);
            }
        }
        $user = $this->buy['user'];
        $pack = VipPackage::find($this->buy['pack']);
        $vip = VipUsers::where('user_id', $this->buy['user_id'])->first();

        if ($user->balance < $pack->price) {
            flash(Lang::get('balance insufficient'))->error()->livewire($this);
            return;
        }

        Wallet::create([
            'admin_id' => 0,
            'user_id' => $user->id,
            'currency' => 'IRT',
            'price' => -$pack->price,
            'description' => Lang::get('credit deduction for purchasing vip pack'),
            'type' => 'decrement',
            'status' => 'done'
        ]);
        Balance::createUnique('IRT', $user, -$pack->price);
        if ($vip) {
            $days = $vip->expire_at > Carbon::now() ?
                Carbon::now()->diffInDays($vip->expire_at) : 0;

            $vip->update([
                'package_id' => $pack->id,
                'user_id' => $user->id,
                'expire_at' => $days > 0 ? Carbon::now()->addDays($days + $pack->days) : Carbon::now()->addDays($pack->days)
            ]);
        } else {
            VipUsers::create([
                'package_id' => $pack->id,
                'user_id' => $user->id,
                'expire_at' => Carbon::now()->addDays($pack->days),
                'start_at' => Carbon::now()
            ]);
        }
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
    }
}
