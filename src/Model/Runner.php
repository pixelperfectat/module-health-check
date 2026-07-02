<?php

declare(strict_types=1);

namespace PixelPerfect\HealthCheck\Model;

use PixelPerfect\HealthCheck\Api\HealthCheckInterface;

class Runner
{
    /**
     * @param HealthCheckInterface[] $checks
     */
    public function __construct(
        private readonly array $checks = []
    ) {
    }

    /**
     * @return array<string, Result>
     */
    public function runAll(): array
    {
        $results = [];
        foreach ($this->checks as $check) {
            try {
                $results[$check->getName()] = $check->run();
            } catch (\Throwable $e) {
                $results[$check->getName()] = Result::fail('Exception: ' . $e->getMessage());
            }
        }
        return $results;
    }
}
