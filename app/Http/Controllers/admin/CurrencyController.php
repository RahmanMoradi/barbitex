<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Jobs\Currency\CreateNetworkList;
use App\Jobs\Currency\CurrencyCalculateFee;
use App\Jobs\Currency\CurrencySaveQr;
use App\Jobs\Currency\CurrencyUpdateWallet;
use App\Models\Currency\Currency;
use App\Models\Order;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::orderby('id')->where('type', 'coin')->get();

        return view('admin.currency.index', compact('currencies'));
    }
}
