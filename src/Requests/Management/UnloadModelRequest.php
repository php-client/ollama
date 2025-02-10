<?php

declare(strict_types=1);

namespace PhpClient\Ollama\Requests\Management;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

final class UnloadModelRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        public readonly string $model,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/api/generate';
    }

    protected function defaultBody(): array
    {
        return [
            'model' => $this->model,
            'keep_alive' => 0,
        ];
    }
}
