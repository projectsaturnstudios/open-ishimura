<?php

declare(strict_types=1);

use GuzzleHttp\Client as GuzzleClient;
use OpenAI\Client;
use OpenAI\OpenAIClient;
use OpenAI\GooseAIClient;
use OpenAI\Transporters\HttpTransporter;
use OpenAI\ValueObjects\ApiKey;
use OpenAI\ValueObjects\Transporter\BaseUri;
use OpenAI\ValueObjects\Transporter\Headers;

final class OpenAI
{
    /**
     * Creates a new Open AI Client with the given API token.
     */
    public static function client(string $apiKey, string|null $url = null, string|null $organization = null, array $abilities = [
        'completions' => true,
        'edits' => true,
        'embeddings' => true,
        'files' => true,
        'fine_tunes' => true,
        'images' => true,
        'models' => true,
        'engines' => false,
        'moderations' => true,
    ]): Client
    {
        $apiKey = ApiKey::from($apiKey);

        $baseUri = BaseUri::from($url ?? 'api.openai.com/v1');

        $headers = Headers::withAuthorization($apiKey);

        if ($organization !== null) {
            $headers = $headers->withOrganization($organization);
        }

        $client = new GuzzleClient();

        $transporter = new HttpTransporter($client, $baseUri, $headers);

        return $abilities['engines'] ? new GooseAIClient($transporter, $abilities) : new OpenAIClient($transporter, $abilities);
    }
}
