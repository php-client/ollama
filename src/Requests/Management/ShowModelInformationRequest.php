<?php

declare(strict_types=1);

namespace PhpClient\Ollama\Requests\Management;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

final class ShowModelInformationRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        public readonly string $model,
        public readonly null|bool $verbose = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/api/show';
    }

    protected function defaultBody(): array
    {
        return array_filter(
            array: [
                'model' => $this->model,
                'verbose' => $this->verbose,
            ],
            callback: static fn(mixed $value): bool => $value !== null,
        );
    }
}
