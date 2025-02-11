<?php

declare(strict_types=1);

namespace PhpClient\Ollama\Requests\Management;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Ensures that the file blob (Binary Large Object) used with create a model exists on the server.
 *
 * This checks your Ollama server and not ollama.com.
 *
 * @see https://github.com/ollama/ollama/blob/main/docs/api.md#check-if-a-blob-exists
 * @version Relevant for 2025-02-11, Ollama v0.5.1
 */
final class CheckBlobExistsRequest extends Request
{
    protected Method $method = Method::HEAD;

    /**
     * @param  string  $digest  The SHA256 digest of the blob
     */
    public function __construct(
        public readonly string $digest,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/api/blobs/$this->digest";
    }
}
