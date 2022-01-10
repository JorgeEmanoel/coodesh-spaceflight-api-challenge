<?php

namespace App\Consumers;

use Illuminate\Support\Facades\Http;

abstract class Consumer
{
    private $base_uri;

    protected $skip = 0;

    protected $take = 100;

    protected $resource = '';

    public function __construct($base_uri)
    {
        $this->base_uri = $base_uri;
    }

    public function request(
        string $method,
        string $path,
        array $data = [],
        array $headers = []
    ) {
        $builder = Http::withHeaders($headers)
            ->acceptJson();

        if ($method === 'GET') {
            $path = $path . '?' . http_build_query($data);
        } else {
            $builder = $builder->withBody($data, 'application/json')
                ->asJson();
        }

        $response = $builder->send($method, $this->resolvePath($path));

        return [
            'success' => $response->successful(),
            'data' => $response->json(),
        ];
    }

    /**
     * @return array
     */
    abstract public function get();

    public function skip(int $skip)
    {
        $this->skip = $skip;
        return $this;
    }

    public function take(int $take)
    {
        $this->take = $take;
        return $this;
    }

    public function resource(string $name)
    {
        $this->resource = $name;
        return $this;
    }

    private function resolvePath(string $path)
    {
        return "{$this->base_uri}/$path";
    }
}
