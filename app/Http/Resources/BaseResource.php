<?php

namespace App\Http\Resources;

use App\Helpers\Helper;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    public $apiV2;

    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->apiV2 = isset(Helper::modules()['api_version']) && Helper::modules()['api_version'] === 2;
    }
}
