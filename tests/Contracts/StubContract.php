<?php

namespace Tests\Contracts;

interface StubContract
{
    /**
     * Should return a stub of the given object, with the
     * data overriden and ignored, if thats the case
     *
     * @return array
     */
    public function resolve(array $override = [], array $ignore = []);
}
