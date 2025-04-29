<?php
declare(strict_types=1);

namespace B2Pagos;

use GuzzleHttp\Client;
use Exception;

class EncryptionUtils
{
    /**
     * Encripta un string usando una clave pública (RSA).
     *
     * @param string $data
     * @param string $publicKey PEM-formatted public key
     * @return string base64-encoded encrypted string
     * @throws Exception
     */
    public static function encryptRSA(string $data, string $publicKey): string
    {
        $encrypted = '';
        $success = openssl_public_encrypt($data, $encrypted, $publicKey);

        if (!$success) {
            throw new Exception('No se pudo encriptar con la clave pública.');
        }

        return base64_encode($encrypted);
    }

    /**
     * Obtiene la clave pública desde el endpoint de B2PAGOS.
     *
     * @param string $apiUrl Base URL (ej: https://sandbox.b2pagos.com)
     * @param bool $verifySSL
     * @return string
     * @throws Exception
     */
    public static function getPublicKey(string $apiUrl, bool $verifySSL = true): string
    {
        $client = new Client([
            'base_uri' => rtrim($apiUrl, '/'),
            'verify' => $verifySSL
        ]);

        $response = $client->get('/public-key');
        $data = json_decode((string)$response->getBody(), true);

        if (empty($data['publicKey'])) {
            throw new Exception('Clave pública no encontrada en la respuesta.');
        }

        return $data['publicKey'];
    }
}
