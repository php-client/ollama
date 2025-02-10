<?php

declare(strict_types=1);

namespace PhpClient\Ollama\Enums;

enum MessageRole: string
{
    case System = 'system';
    case User = 'user';
    case Assistant = 'assistant';
    case Tool = 'tool';
}
