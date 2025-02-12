<?php

declare(strict_types=1);

namespace PhpClient\Ollama;

use PhpClient\Ollama\Resources\Api;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\HasTimeout;

/**
 * PHP Client for Ollama API.
 *
 * @see https://github.com/ollama/ollama/blob/main/docs/api.md
 * @version Relevant for 2025-02-11, Ollama v0.5.1
 */
final class Ollama extends Connector
{
    use HasTimeout;

    public readonly Api $api;

    public readonly float $requestTimeout;

    /**
     * @param  string  $baseUrl  The base URL of the Ollama server
     */
    public function __construct(
        private readonly string $baseUrl,
    ) {
        $this->api = new Api(connector: $this);
        $this->requestTimeout = 300.0;
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
