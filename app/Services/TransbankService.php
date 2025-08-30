<?php

namespace App\Services;

use Transbank\Webpay\WebpayPlus\Transaction as WebpayTransaction;
use Transbank\Webpay\Options;

class TransbankService
{
    /**
     * Create a properly configured WebpayTransaction instance
     *
     * @return WebpayTransaction
     */
    public function makeTransaction(): WebpayTransaction
    {
        // Get credentials from config with fallbacks
        $commerceCode = config('services.transbank.commerce_code');
        $apiKey = config('services.transbank.api_key');
        $environment = config('services.transbank.environment');

        if (!$commerceCode || !$apiKey) {
            throw new \RuntimeException('Missing Transbank credentials. Please set TBK_COMMERCE_CODE and TBK_API_KEY in .env');
        }

        // Build Transaction using the correct Options class expected by SDK 5.x
        // Constructor order: apiKey, commerceCode, integrationType
        $options = new Options($apiKey, $commerceCode, $environment);
        
        return new WebpayTransaction($options);
    }

    /**
     * Get Transbank configuration values
     *
     * @return array
     */
    public function getConfig(): array
    {
        return [
            'commerce_code' => config('services.transbank.commerce_code'),
            'environment' => config('services.transbank.environment'),
            'api_key_set' => !empty(config('services.transbank.api_key')),
        ];
    }
}
