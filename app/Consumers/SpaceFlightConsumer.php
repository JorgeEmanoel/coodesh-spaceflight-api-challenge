<?php

namespace App\Consumers;

final class SpaceFlightConsumer extends Consumer
{
    public function __construct()
    {
        parent::__construct(env('SPACE_FLIGHT_API_ENDPOINT'));
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function get()
    {
        if (!$this->resource) {
            throw new \Exception('No resource specified. Use the resource() method before calling get()');
        }

        return $this->request(
            'GET',
            "$this->resource/",
            [
                '_limit' => $this->take,
                '_start' => $this->skip,
            ]
        );
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function count()
    {
        if (!$this->resource) {
            throw new \Exception('No resource specified. Use the resource() method before calling count()');
        }

        return $this->request(
            'GET',
            "$this->resource/count"
        );
    }
}
