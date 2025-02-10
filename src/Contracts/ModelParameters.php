<?php

declare(strict_types=1);

namespace PhpClient\Ollama\Contracts;

use function array_filter;

final readonly class ModelParameters
{
    public function __construct(
        public ?int $mirostat = null,
        public ?float $mirostatEta = null,
        public ?float $mirostatTau = null,
        public ?int $numCtx = null,
        public ?int $repeatLastN = null,
        public ?float $repeatPenalty = null,
        public ?float $temperature = null,
        public ?int $seed = null,
        public ?string $stop = null,
        public ?int $numPredict = null,
        public ?int $topK = null,
        public ?float $topP = null,
        public ?float $minP = null,
    ) {}

    public function toArray(): array
    {
        return array_filter(
            array: [
                'mirostat' => $this->mirostat,
                'mirostat_eta' => $this->mirostatEta,
                'mirostat_tau' => $this->mirostatTau,
                'num_ctx' => $this->numCtx,
                'repeat_last_n' => $this->repeatLastN,
                'repeat_penalty' => $this->repeatPenalty,
                'temperature' => $this->temperature,
                'seed' => $this->seed,
                'stop' => $this->stop,
                'num_predict' => $this->numPredict,
                'top_k' => $this->topK,
                'top_p' => $this->topP,
                'min_p' => $this->minP,
            ],
            callback: static fn (mixed $value): bool => $value !== null,
        );
    }
}
