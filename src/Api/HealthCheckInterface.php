<?php

declare(strict_types=1);

namespace PixelPerfect\HealthCheck\Api;

use PixelPerfect\HealthCheck\Model\Result;

interface HealthCheckInterface
{
    public function getName(): string;

    public function run(): Result;
}
