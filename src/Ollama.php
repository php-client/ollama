<?php

declare(strict_types=1);

namespace PhpClient\Ollama;

use PhpClient\Ollama\Resources\Api;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\HasTimeout;

final class Ollama extends Connector
{
    use HasTimeout;

    public readonly Api $api;

    public function __construct(
        private readonly string $baseUrl,
    ) {
        $this->api = new Api(connector: $this);
    }

    public function resolveBaseUrl(): string
    {
        return $this->baseUrl;
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }
}
