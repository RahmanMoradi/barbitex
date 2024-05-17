<?php

namespace App\Http\Controllers\Api\V1\Card;

use App\Http\Controllers\Controller;
use App\Http\Resources\CardResource;
use App\Models\Card\Card;
use App\Models\User;
use App\Notifications\Admin\SendNotificationToAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class CardController extends Controller
{
    public function index()
    {
        $cards = Card::where('user_id', Auth::guard('api')->id())->get();
        return $this->response(1, CardResource::collection($cards), [], Lang::get('cards registered by the user'));
    }

    public function bankList()
    {
        $data = [
            [
                'prefix' => '603799',
                'icon' => asset('/images/banks/bank_melli.png'),
                'name' => 'بانک ملی ایران'
            ],
            [
                'prefix' => '589210',
                'icon' => asset('/images/banks/bank_sepah.png'),
                'name' => 'بانک سپه'
            ],
            [
                'prefix' => '627648',
                'icon' => asset('/images/banks/bank_tosee.png'),
                'name' => 'بانک توسعه صادرات '
            ],
            [
                'prefix' => '627961',
                'icon' => asset(''),
                'name' => 'بانک صنعت و معدن'
            ],
            [
                'prefix' => '603770',
                'icon' => asset('/images/banks/bank_keshavarzi.png'),
                'name' => 'بانک کشاورزی'
            ],
            [
                'prefix' => '628023',
                'icon' => asset('/images/banks/bank_maskan.png'),
                'name' => 'بانک مسکن'
            ],
            [
                'prefix' => '627760',
                'icon' => asset(''),
                'name' => 'پست بانک ایران'
            ],
            [
                'prefix' => '502908',
                'icon' => asset('/images/banks/bank_tosee.png'),
                'name' => 'بانک توسعه تعاون'
            ],
            [
                'prefix' => '627412',
                'icon' => asset('/images/banks/bank_eghtesad_novin.png'),
                'name' => 'بانک اقتصاد نوین'
            ],
            [
                'prefix' => '622106',
                'icon' => asset('/images/banks/bank_parsian.png'),
                'name' => 'بانک پارسیان'
            ],
            [
                'prefix' => '502229',
                'icon' => asset(''),
                'name' => 'بانک پاسارگاد'
            ],
            [
                'prefix' => '627488',
                'icon' => asset('/images/banks/bank_karAfarin.png'),
                'name' => 'بانک کارآفرین'
            ],
            [
                'prefix' => '621986',
                'icon' => asset('/images/banks/bank_saman.png'),
                'name' => 'بانک سامان'
            ],
            [
                'prefix' => '639346',
                'icon' => asset('/images/banks/bank_sina.png'),
                'name' => 'بانک سینا'
            ],
            [
                'prefix' => '639607',
                'icon' => asset(''),
                'name' => 'بانک سرمایه'
            ],
            [
                'prefix' => '636214',
                'icon' => asset(''),
                'name' => 'بانک تات'
            ],
            [
                'prefix' => '502806',
                'icon' => asset(''),
                'name' => 'بانک شهر'
            ],
            [
                'prefix' => '502938',
                'icon' => asset(''),
                'name' => 'بانک دی'
            ],
            [
                'prefix' => '603769',
                'icon' => asset('/images/banks/bank_saderat.png'),
                'name' => 'بانک صادرات'
            ],
            [
                'prefix' => '610433',
                'icon' => asset('/images/banks/bank_mellat.png'),
                'name' => 'بانک ملت'
            ],
            [
                'prefix' => '627353',
                'icon' => asset('/images/banks/bank_tejarat.png'),
                'name' => 'بانک تجارت'
            ],
            [
                'prefix' => '589463',
                'icon' => asset('/images/banks/bank_refah.png'),
                'name' => 'بانک رفاه'
            ],
            [
                'prefix' => '627381',
                'icon' => asset('/images/banks/bank_ansar.png'),
                'name' => 'بانک انصار'
            ],
            [
                'prefix' => '639370',
                'icon' => asset('/images/banks/bank_mehrEghtesad.png'),
                'name' => 'بانک مهر اقتصاد'
            ],
            [
                'prefix' => '606373',
                'icon' => asset('/images/banks/bank_mehr.png'),
                'name' => 'بانک مهر ایران'
            ],

        ];
        return $this->response(1, $data, [], Lang::get('operation completed successfully'));
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'bank_name' => 'required',
            'card_number' => 'required|digits_between:16,16|unique:cards',
            'account_number' => 'numeric',
            'sheba' => 'numeric|digits_between:24,24'
        ]);
        if ($validate->fails()) {
            return $this->validateResponseFail($validate);
        }

        $card = Card::create($request->only('card_number', 'account_number', 'bank_name', 'sheba') + [
                'user_id' => Auth::guard('api')->id()
            ]);

//        Notification::send(User::whereRole(2)->get(), (new SendNotificationToAdmin('cardStore'))->delay(now()->addSecond(3)));
        $cards = Card::where('user_id', Auth::guard('api')->id())->get();

        return $this->response(1, CardResource::collection($cards), [], Lang::get('cards registered by the user'));
    }
}
