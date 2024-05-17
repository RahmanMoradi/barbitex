<?php
namespace App\Services\TraitService;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

trait QrSaveTrait
{
    private function qrCodeSave($currency)
    {
        $patch = public_path('uploads/currency/image/');
        $renderer = new ImageRenderer(
            new RendererStyle(100),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        foreach ($currency->networks as $network) {
            if (isset($network->address)) {
                try {
                    $writer->writeFile($network->address, $patch . "qrWallet$network->coin$network->network.svg");
                    $network->qr_address = '/uploads/currency/image/' . "qrWallet$network->coin$network->network.svg";
                } catch (\Exception $exception) {

                }
            }
            if (isset($network->tag)) {
                try {
                    $writer->writeFile($network->tag, $patch . "qrTag$network->coin$network->network.svg");
                    $network->qr_tag = '/uploads/currency/image/' . "qrTag$network->coin$network->network.svg";
                } catch (\Exception $exception) {

                }
            }
            $network->save();
        }
    }
}
