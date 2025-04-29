<?php
declare(strict_types=1);

namespace B2Pagos;

class SignatureUtils
{
    /**
     * Genera una firma HMAC-SHA256 basada en un payload ordenado por claves.
     *
     * @param array $payload
     * @param string $integrityKey
     * @return string Firma en hexadecimal
     */
    public static function generateSignature(array $payload, string $integrityKey): string
    {
        // Ordenar el payload alfabéticamente por claves
        ksort($payload);

        // Convertir a JSON plano (sin pretty print)
        $json = json_encode($payload, JSON_UNESCAPED_UNICODE);

        // Firmar con HMAC-SHA256
        return hash_hmac('sha256', $json, $integrityKey);
    }
}
