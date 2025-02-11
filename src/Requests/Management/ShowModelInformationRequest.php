<?php

declare(strict_types=1);

namespace PhpClient\Ollama\Requests\Management;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Show information about a model
 *
 * Including: details, modelfile, template, parameters, license, system prompt.
 *
 * @see https://github.com/ollama/ollama/blob/main/docs/api.md#show-model-information
 * @version Relevant for 2025-02-11, Ollama v0.5.1
 */
final class ShowModelInformationRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $model  Name of the model to show
     * @param  bool|null  $verbose  If set to true, returns full data for verbose response fields
     */
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
