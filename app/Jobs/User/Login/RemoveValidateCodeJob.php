<?php

namespace App\Jobs\User\Login;

use App\Models\User\ValidCode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RemoveValidateCodeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var ValidCode
     */
    private $validCode;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ValidCode $validCode)
    {
        $this->validCode = $validCode;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $this->validCode->delete();
        } catch (\Exception $exception) {
        }
    }
}
