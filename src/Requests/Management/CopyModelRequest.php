<?php

declare(strict_types=1);

namespace PhpClient\Ollama\Requests\Management;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

final class CopyModelRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        public readonly string $source,
        public readonly string $destination,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/api/copy';
    }

    protected function defaultBody(): array
    {
        return [
            'source' => $this->source,
            'destination' => $this->destination,
        ];
    }
}
