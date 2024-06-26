<?php

namespace App\Webazin\Inquiry;

use Illuminate\Support\Facades\Http;

trait InquiryService
{
    public function __call($name, $arguments = [])
    {
        return $this->request($name, count($arguments) > 0 ? $arguments[0] : []);
    }

    private function request($name, array $arguments)
    {
        $method = $this->getMethod($name);
        $path = $this->getPath($name);
        $arguments = $this->getIfo($arguments)[$name]['arguments'];

        $response = Http::withToken($this->accessToken)->$method($path, $arguments)
            ->throw(function ($response, $e) {
                return response(['code' => 0], 200);
//                throw new \Exception($e->getMessage());
            })->json();
        return $this->response($response, $name);
    }

    private function getMethod($name): string
    {
        $method = $this->getIfo()[$name]['path'];
        return preg_split('/(?=[A-Z])/', $method)[0];
    }

    private function getPath($name)
    {
        $path = $this->baseUrl;
        if ($this->version) {
            $path = $this->baseUrl . $this->version;
        }
        $method = $this->getIfo()[$name]['path'];
        $items = preg_split('/(?=[A-Z])/', $method);

        $i = 1;
        foreach ($items as $item) {
            if ($i > 1) {
                $path .= strtolower($item) . '/';
            }
            $i++;
        }
        return rtrim($path, '/');
    }

    private function response($response, $name): array
    {
        return $this->getIfo([], $response)[$name]['response'];
    }

    /**
     * @param string $baseUrl
     */
    public function setBaseUrl(string $baseUrl): void
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }
}
