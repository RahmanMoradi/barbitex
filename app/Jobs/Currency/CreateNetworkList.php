<?php

namespace App\Jobs\Currency;

use anlutro\LaravelSettings\Facade as Setting;
use App\Livewire\Admin\Currency\Currencies;
use App\Models\Currency\Currency;
use App\Models\Network\Network;
use App\Models\Webazin\Binance\Facades\Binance;
use App\Models\Webazin\Kucoin\Facades\Kucoin;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateNetworkList implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $currency;
    public $symbol;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($symbol)
    {
        $this->symbol = $symbol;
        $this->currency = Currency::whereSymbol($symbol)->first();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->currency->adminUpdate();;
    }
}
