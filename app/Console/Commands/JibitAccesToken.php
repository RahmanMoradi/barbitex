<?php

namespace App\Console\Commands;

use anlutro\LaravelSettings\Facade as Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class JibitAccesToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jibit:generateToken';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate or refresh jibit token';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            if (!empty(Setting::get('jibitAccessToken'))) {
                $response = \Inquiry::refreshToken([
                    'accessToken' => Setting::get('jibitAccessToken'),
                    'refreshToken' => Setting::get('jibitRefreshToken'),
                ]);
                Setting::set('jibitAccessToken', $response['accessToken']);
                Setting::set('jibitRefreshToken', $response['refreshToken']);
            } else {
                $response = \Inquiry::generateToken([
                    'apiKey' => Setting::get('jibitApiKey'),
                    'secretKey' => Setting::get('jibitSecretKey')
                ]);
                Setting::set('jibitAccessToken', $response['accessToken']);
                Setting::set('jibitRefreshToken', $response['refreshToken']);
            }
        } catch (\Exception $exception) {
            Setting::set('jibitAccessToken', null);

            Artisan::call('jibit:generateToken');
        }
        Setting::save();
        return Command::SUCCESS;
    }
}
