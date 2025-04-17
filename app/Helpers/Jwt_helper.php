<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if (!function_exists('generate_jwt')) {
    /**
     * Generate a JWT token.
     *
     * @param array $payload The data to include in the token.
     * @return string The generated JWT token.
     */
    function generate_jwt(array $payload): string
    {
        $key = getenv('JWT_SECRET_KEY'); // Secret key from .env
        $algorithm = 'HS256'; // Algorithm to use

        return JWT::encode($payload, $key, $algorithm);
    }
}

if (!function_exists('verify_jwt')) {
    /**
     * Verify a JWT token.
     *
     * @param string $token The JWT token to verify.
     * @return object|false The decoded token payload or false if verification fails.
     */
    function verify_jwt(string $token)
    {
        try {
            $key = getenv('JWT_SECRET_KEY'); // Secret key from .env
            $algorithm = 'HS256'; // Algorithm to use

            return JWT::decode($token, new Key($key, $algorithm));
        } catch (Exception $e) {
            // Log the error or handle it as needed
            log_message('error', 'JWT Verification Failed: ' . $e->getMessage());
            return false;
        }
    }
}