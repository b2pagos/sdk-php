# B2PAGOS PHP SDK

SDK oficial en PHP para integrarse con la pasarela de pagos **B2PAGOS** de forma sencilla, segura y moderna.

![Packagist Version](https://img.shields.io/packagist/v/b2pagos/sdk)
![License](https://img.shields.io/packagist/l/b2pagos/sdk)

---

## ✨ Características

- Crear transacciones (payment links)
- Autenticación vía JWT o credenciales (user/pass)
- Encriptación de tarjetas vía RSA
- Firmas HMAC para integridad
- 100% orientado a objetos y tipado fuerte
- Compatible con PHP 7.4+ y PHP 8.x

---

## 📦 Instalación

```bash
composer require b2pagos/sdk
```

O si estás en desarrollo local:

```json
"repositories": [
  {
    "type": "path",
    "url": "../sdk"
  }
],
"require": {
  "b2pagos/sdk": "*"
}
```

---

## 🚀 Uso rápido

```php
use B2Pagos\B2PClient;

$client = new B2PClient([
    'accountKey' => 'tu-account-key',
    'integrityKey' => 'tu-integrity-key',
    'username' => 'tu-email@b2pagos.com',
    'password' => 'tu-password',
    'apiUrl' => 'https://sandbox.b2pagos.com',
    'verifySSL' => false // true en producción
]);

$transaction = $client->createTransaction([
    'accountId'   => 'acct_123',
    'reference'   => 'ref_456',
    'description' => 'Compra online',
    'amount'      => 10000,
    'taxValue'    => 0,
    'taxBase'     => 0,
    'currency'    => 'COP'
]);

print_r($transaction);
```

---

## 📊 Métodos disponibles

| Método | Descripción |
|--------|-------------|
| `createTransaction()` | Crea un link de pago |
| `getUserToken()` | Login por email y password |
| `getJwt()` | Genera JWT con `integrityKey` |
| `EncryptionUtils::encryptRSA()` | Encripta datos con RSA |
| `EncryptionUtils::getPublicKey()` | Obtiene la clave pública desde API |
| `SignatureUtils::generateSignature()` | Firma HMAC-SHA256 de un payload |

---

## 🔐 Seguridad

- Las claves deben mantenerse privadas.
- En sandbox puedes usar `verifySSL => false`, en producción siempre `true`.
- Tokens tienen expiración corta (30 segundos).

---

## 🔬 Requisitos

- PHP >= 7.4
- Extensiones: `curl`, `openssl`, `mbstring`, `json`

---

## 🤝 Contribuir

¡Pull requests bienvenidos! Crea un `issue` primero si quieres discutir una funcionalidad o bug.

---

## 📝 Licencia

MIT License - B2Pagos (c) 2025

---