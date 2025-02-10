<?php

declare(strict_types=1);

namespace PhpClient\Ollama\Requests\Management;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

final class PushModelRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        public readonly string $model,
        public readonly null|bool $insecure = null,
        public readonly null|bool $stream = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/api/push';
    }

    protected function defaultBody(): array
    {
        return array_filter(
            array: [
                'model' => $this->model,
                'insecure' => $this->insecure,
                'stream' => $this->stream,
            ],
            callback: static fn(mixed $value): bool => $value !== null,
        );
    }
}
