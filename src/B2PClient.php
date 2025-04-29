<?php
declare(strict_types=1);

namespace B2Pagos;

use GuzzleHttp\Client;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class B2PClient
{
    private Client $client;
    private string $accountKey;
    private string $integrityKey;
    private string $username;
    private string $password;
    private string $apiUrl;
    private ?string $token = null;

    public function __construct(array $config)
    {
        $this->accountKey = $config['accountKey'] ?? '';
        $this->integrityKey = $config['integrityKey'] ?? '';
        $this->username = $config['username'] ?? '';
        $this->password = $config['password'] ?? '';
        $this->apiUrl = rtrim($config['apiUrl'] ?? '', '/');

        $this->client = new Client([
            'base_uri' => $this->apiUrl,
            'verify' => $config['verifySSL'] ?? true,
            'timeout' => 10,
        ]);
    }

    public function createTransaction(array $data): array
    {
        $token = $this->getUserToken();

        $response = $this->client->post('/paymentLink/transaction', [
            'headers' => [
                'Authorization' => "Bearer {$token}",
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'account_id'   => $data['accountId'] ?? '',
                'reference'    => $data['reference'] ?? '',
                'description'  => $data['description'] ?? '',
                'total'        => $data['amount'] ?? 0,
                'tax_value'    => $data['taxValue'] ?? 0,
                'tax_base'     => $data['taxBase'] ?? 0,
                'currency'     => $data['currency'] ?? 'COP',
            ]
        ]);

        return json_decode((string)$response->getBody(), true);
    }

    private function getJwt(): string
    {
        $payload = [
            'account_key' => $this->accountKey,
            'iat' => time(),
            'exp' => time() + 30,
        ];

        return JWT::encode($payload, $this->integrityKey, 'HS256');
    }

    private function getUserToken(): string
    {
        if ($this->token) {
            return $this->token;
        }

        $response = $this->client->post('/get-access-token', [
            'json' => [
                'email' => $this->username,
                'password' => $this->password,
            ]
        ]);

        $data = json_decode((string)$response->getBody(), true);
        $this->token = $data['data'] ?? '';
        return $this->token;
    }
}
