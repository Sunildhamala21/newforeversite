<?php

return [
    'paymentEnabled' => env('PAYMENT_ENABLED', false),

    'OfficeId' => env('HBL_OFFICE_ID'),

    /**
     * payment end point
     */
    'EndPoint' => env('HBL_PAYMENT_END_POINT'),

    /**
     * JWE Key Id.
     */
    'EncryptionKeyId' => env('HBL_ENCRYPTION_KEY_ID'),

    /**
     * Access Token.
     */
    'AccessToken' => env('HBL_ACCESS_TOKEN'),

    /**
     * Token Type - Used in JWS and JWE header.
     */
    'TokenType' => 'JWT',

    /**
     * JWS (JSON Web Signature) Signature Algorithm - This parameter identifies the cryptographic algorithm used to
     * secure the JWS.
     */
    'JWSAlgorithm' => 'PS256',

    /**
     * JWE (JSON Web Encryption) Key Encryption Algorithm - This parameter identifies the cryptographic algorithm
     * used to secure the JWE.
     */
    'JWEAlgorithm' => 'RSA-OAEP',

    /**
     * JWE (JSON Web Encryption) Content Encryption Algorithm - This parameter identifies the content encryption
     * algorithm used on the plaintext to produce the encrypted ciphertext.
     */
    'JWEEncrptionAlgorithm' => 'A128CBC-HS256',

    /**
     * Merchant Signing Private Key is used to cryptographically sign and create the request JWS.
     */
    'MerchantSigningPrivateKey' => env('HBL_PRIVATE_KEY_JWS'),

    /**
     * PACO Encryption Public Key is used to cryptographically encrypt and create the request JWE.
     */
    'PacoEncryptionPublicKey' => env('HBL_PACO_ENCRYPTION_PUBLIC_KEY'),

    /**
     * PACO Signing Public Key is used to cryptographically verify the response JWS signature.
     */
    'PacoSigningPublicKey' => env('HBL_PACO_SIGNING_PUBLIC_KEY'),

    /**
     * Merchant Decryption Private Key used to cryptographically decrypt the response JWE.
     */
    'MerchantDecryptionPrivateKey' => env('HBL_PRIVATE_KEY_JWE'),

    /**
     * Input Currecy for example USD or NRP.
     */
    'InputCurrency' => env('HBL_INPUT_CURRENCY'),

    /**
     * Input 3DS should be Y for production and N for development
     */
    'Input3DS' => env('HBL_INPUT_3D'),
];
