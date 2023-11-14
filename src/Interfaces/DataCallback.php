<?php

namespace Mobiverse\LaravelMixpanel\Interfaces;

/**
 * Interface DataCallback
 */
interface DataCallback
{
    public function process(array $data = []): array;
}
