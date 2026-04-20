<?php

declare(strict_types=1);

namespace PixelPerfect\HealthCheck\Model;

final class Result
{
    public const STATUS_PASS = 'pass';
    public const STATUS_FAIL = 'fail';
    public const STATUS_WARN = 'warn';

    public function __construct(
        private readonly string $status,
        private readonly string $message = '',
    ) {
    }

    public static function pass(string $message = ''): self
    {
        return new self(self::STATUS_PASS, $message);
    }

    public static function fail(string $message): self
    {
        return new self(self::STATUS_FAIL, $message);
    }

    public static function warn(string $message): self
    {
        return new self(self::STATUS_WARN, $message);
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function isFail(): bool
    {
        return $this->status === self::STATUS_FAIL;
    }
}