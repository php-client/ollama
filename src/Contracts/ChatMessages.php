<?php

declare(strict_types=1);

namespace PhpClient\Ollama\Contracts;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

use function array_map;

final readonly class ChatMessages implements IteratorAggregate
{
    /**
     * @param  ChatMessage[]|array[]  $messages
     */
    public function __construct(
        public array $messages
    ) {}

    public function toArray(): array
    {
        return array_map(
            callback: static function (mixed $message): array {
                if ($message instanceof ChatMessage) {
                    return $message->toArray();
                } else {
                    return $message;
                }
            },
            array: $this->messages,
        );
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator(array: $this->toArray());
    }
}
