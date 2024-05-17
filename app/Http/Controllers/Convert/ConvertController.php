<?php

namespace App\Http\Controllers\Convert;

use App\Http\Controllers\Controller;
use App\Models\Network\Network;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ConvertController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('table')) {
            $this->import($request->table, $request->orderBy ?? 'id', $request->from ? $request->from : null, $request->to ? $request->to : null);
            return 'done';
        }
        switch ($request->action) {
            case 'user':
                $this->importUser();
                break;
            case 'card':
                $this->importCard();
                break;
            case 'docs':
                $this->importDocs();
                break;
            case 'balance':
                $this->importBalance();
                break;
            case 'txid':
                $this->importTxid();
                break;
            case 'changePassword':
                $this->changePassword();
                break;
        }
    }

    private function importUser()
    {
        $oldUsers = DB::connection('mysql_old')->table('users')->where('role', 1)->get();
        foreach ($oldUsers as $oldUser) {
            $doc = DB::connection('mysql_old')->table('user_docs')->where('user_id', $oldUser->id)->first();
            DB::table('users')->insert([
                'id' => $oldUser->id,
                'parent_id' => $oldUser->parent_id,
                'name' => $oldUser->name,
                'email' => $oldUser->email,
                'mobile' => $oldUser->mobile,
                'national_code' => $oldUser->national_code,
                'birthday' => $oldUser->birthday,
                'phone' => $oldUser->phone,
                'address' => '',
                'mobile_verified_at' => $oldUser->mobile_status ? Carbon::now() : null,
                'doc_verified_at' => $doc && $doc->status == 1 ? Carbon::now() : null,
                'email_verified_at' => null,
                'password' => $oldUser->password,
                'two_factor_type' => 'sms',
                'google2fa_secret' => null,
                'is_code_set' => 0,
                'api_token' => $oldUser->api_token,
                'max_buy' => $oldUser->max_buy,
                'day_buy' => $oldUser->day_buy,
                'level' => $oldUser->level,
                'theme' => $oldUser->theme,
            ]);
        }
    }

    private function importCard()
    {
        $oldCards = DB::connection('mysql_old')->table('cards')->where('status', '!=', 0)->get();
        foreach ($oldCards as $oldCard) {
            DB::table('cards')->insert([
                'id' => $oldCard->id,
                'user_id' => $oldCard->user_id,
                'bank_name' => $oldCard->bank_name,
                'card_number' => $oldCard->card_number,
                'account_number' => $oldCard->account_number,
                'sheba' => $oldCard->sheba,
                'status' => $oldCard->status,
            ]);
        }
    }

    private function importDocs()
    {
        $oldDocs = DB::connection('mysql_old')->table('user_docs')->get();
        foreach ($oldDocs as $doc) {
            DB::table('user_documents')->insert([
                'id' => $doc->id,
                'user_id' => $doc->user_id,
                'title' => $doc->title,
                'status' => $doc->status == 0 ? 'failed' : ($doc->status == 1 ? 'new' : 'accept'),
                'created_at' => $doc->created_at,
                'updated_at' => $doc->updated_at,
            ]);
        }
    }

    private function importBalance()
    {
        $oldBalance = DB::connection('mysql_old')->table('balances')->get();

        foreach ($oldBalance as $item) {
            DB::table('balances')->insert([
                'id' => $item->id,
                'currency' => $item->currency,
                'user_id' => $item->user_id,
                'balance' => $item->balance,
                'balance_free' => $item->balance,
                'balance_use' => 0,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ]);
        }
    }

    private function importTxid()
    {
        $oldBalance = DB::connection('mysql_old')->table('txids')->get();

        foreach ($oldBalance as $item) {
            DB::table('txids')->insert([
                'symbol' => 'OLD',
                'txid' => $item->txid,
            ]);
        }
    }

    private function import($table, $orderBy, $from, $to)
    {
        ini_set('set_time_limit', 5000);
        set_time_limit(5000);

        $users = DB::connection('mysql_old')->table('users')->pluck('id');
        $admins = DB::connection('mysql_old')->table('admins')->pluck('id');
        $markets = DB::connection('mysql_old')->table('markets')->pluck('id');
        $tickets = DB::table('tickets')->pluck('id');
        $currencies = DB::connection('mysql_old')->table('currencies')->pluck('symbol');

        //        $balances = DB::connection('mysql_old')->table('balances')->select('currency')->whereNotIn('currency', $currencies)
        //            ->groupBy('currency')
        //            ->get();
        //        dd($balances);
        //        ->where('id', '>=', 100000)->where('id', '<', 200000)
        DB::transaction(function () use ($tickets, $markets, $currencies, $from, $to, $admins, $users, $orderBy, $table) {
            DB::connection('mysql_old')->table($table)->orderBy($orderBy)
                //                ->whereIn('market_id', $markets)
                ->whereIn('user_id', $users)
                //                ->whereIn('ticket_id', $tickets)
                //                ->whereIn('currency', $currencies)
                //                ->where('balance', '!==', 0) //for balance table
                //                ->where('balance_free', '!==', 0) // for for balance table
                //                ->where('id', '>=', $from)->where('id', '<', $to) //for balance table big data
                ->chunk(1000, function ($items) use ($admins, $users, $table) {
                    foreach ($items as $item) {
                        //                        if (!in_array($item->user_id, $users->toArray())) {
                        //                            $item->user_id = 0;
                        //                        }
                        if ($item->admin_id != null && !in_array($item->admin_id, $admins->toArray())) {
                            $item->admin_id = 0;
                        }
                        if ($item->network_id !== null && !Network::find($item->network_id)) {
                            $item->network_id = null;
                        }
                        DB::table($table)->insert((array)$item);
                    }
                });
        });
    }

    public function changePassword()
    {
        ini_set('set_time_limit', 5000);
        set_time_limit(5000);
        User::latest('id')->chunk(1000, function ($users) {
            foreach ($users as $user) {
                $user->update([
                    'password' => Hash::make(Str::random(10))
                ]);
            }
        });
    }
}
