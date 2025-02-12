# Php client for Ollama Api.

This is a PHP client for the [Ollama API](https://github.com/ollama/ollama/blob/main/docs/api.md).

## Installation
Install the package via composer:

```bash
composer require php-client/ollama
```

## Usage

Simple example:
```php
use PhpClient\Ollama\Ollama;

$ollama = new Ollama('http://localhost:11434');

$response = $ollama->generation()->completions([
    'model' => 'llama3.2:latest',
    'prompt' => 'Hello!',
    // Wait for end of generation before getting response:
    'stream' => false,
]);

echo $response->json('response');
```

More information available in comments and PhpDocs in the code.

Also please check the official [Ollama API docs](https://github.com/ollama/ollama/blob/main/docs/api.md).

## List of available API actions

- Generation
  - Generate completions
  - Generate chat completions
  - Generate embeddings
- Management
  - List local models
  - List running models
  - Show model information
  - Load|Unload model
  - Pull|Push model
  - Create|Copy|Delete model
  - Check blob exists
- Version


## License

This package is released under the [MIT License](LICENSE.md).
