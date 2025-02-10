<?php

declare(strict_types=1);

namespace PhpClient\Ollama\Contracts;

use PhpClient\Ollama\Enums\MessageRole;

use function array_filter;

final readonly class ChatMessage
{
    public function __construct(
        public string|MessageRole $role,
        public string $content,
        public null|array $images = null,
        public null|array $toolCalls = null,
    ) {}

    public function toArray(): array
    {
        return array_filter(
            array: [
                'role' => $this->role instanceof MessageRole
                    ? $this->role->value
                    : $this->role,
                'content' => $this->content,
                'images' => $this->images,
                'tool_calls' => $this->toolCalls,
            ],
            callback: static fn (null|string|array $value): bool => $value !== null,
        );
    }
}
