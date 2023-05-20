<?php

namespace App\traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

trait BCA
{
    public function generateSignatureAsymmetric()
    {
        $client_id = config('bca.client_id');
        $privateKeyPath = config('bca.private_key');

        $timestamp = Carbon::now()->toIso8601String();
        $StringToSign = $client_id . "|" . $timestamp;


        $privateKey = file_get_contents($privateKeyPath);
        $signatureBase = null;
        openssl_sign($StringToSign, $signatureBase, $privateKey, OPENSSL_ALGO_SHA256);
        $signature = base64_encode($signatureBase);

        $headers = [
            'X-TIMESTAMP' => $timestamp,
            'X-CLIENT-KEY' => $client_id,
            'X-SIGNATURE' => $signature,
            'Content-Type' => 'application/json'
        ];
//        dd($headers);
        $body = '{
                  "grantType": "client_credentials"
                 }';
        $res = Http::withHeaders($headers)->withBody($body)->post(config('bca.url').'/openapi/v1.0/access-token/b2b');

        return $res->json()['accessToken'];
    }
    public function generateSignatureSymmetric($httpMethod, $relativeUrl, $requestBody)
    {
        $clientId = config('bca.client_id');
        $clientSecret = config('bca.client_secret');

        $timestamp = Carbon::now()->toIso8601String();

        $minifyJson = $requestBody;
        $sha256Hash = hash('sha256', $minifyJson);
//        dd($minifyJson);
//        $hexEncodedHash = bin2hex($sha256Hash);

        $encodedUri = preg_replace_callback(
            '/[^\/\?\=\&a-zA-Z0-9\-_~\.]/',
            function ($matches) {
                return rawurlencode($matches[0]);
            },
            $relativeUrl
        );
        $stringToSign = strtoupper($httpMethod).":".$encodedUri.":".$this->generateSignatureAsymmetric().":".
            strtolower($sha256Hash).":".$timestamp;
dd($stringToSign);
        $hmac = hash_hmac('sha512', $stringToSign,$clientSecret);
        $signature = base64_encode($hmac);
//        dd($signature);

        $headers = [
            'X-TIMESTAMP' => $timestamp,
            'X-CLIENT-KEY' => $clientId,
            'X-SIGNATURE' => $signature,
            'Content-Type' => 'application/json'
        ];
//        dd($headers);
        $body = '{
                  "grantType": "client_credentials"
                 }';
        $res = Http::withHeaders($headers)->withBody($body)->post(config('bca.url').'/openapi/v1.0/access-token/b2b');
        return $res->json();
    }
}
