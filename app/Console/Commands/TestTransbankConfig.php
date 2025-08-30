<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestTransbankConfig extends Command
{
    protected $signature = 'transbank:test-config';
    protected $description = 'Test Transbank configuration values';

    public function handle()
    {
        $this->info('Testing Transbank Configuration:');
        $this->line('');
        
        $commerceCode = config('services.transbank.commerce_code', env('TBK_COMMERCE_CODE'));
        $apiKey = config('services.transbank.api_key', env('TBK_API_KEY'));
        $environment = config('services.transbank.environment', env('TBK_INTEGRATION_TYPE', 'TEST'));
        
        $this->table(['Setting', 'Value'], [
            ['TBK_COMMERCE_CODE (env)', env('TBK_COMMERCE_CODE') ?? 'NOT SET'],
            ['TBK_API_KEY (env)', env('TBK_API_KEY') ? 'SET (' . strlen(env('TBK_API_KEY')) . ' chars)' : 'NOT SET'],
            ['TBK_INTEGRATION_TYPE (env)', env('TBK_INTEGRATION_TYPE') ?? 'NOT SET'],
            ['services.transbank.commerce_code', $commerceCode ?? 'NOT SET'],
            ['services.transbank.api_key', $apiKey ? 'SET (' . strlen($apiKey) . ' chars)' : 'NOT SET'],
            ['services.transbank.environment', $environment ?? 'NOT SET'],
            ['APP_ENV', app()->environment()],
        ]);
        
        if (!$commerceCode || !$apiKey) {
            $this->error('❌ Missing required Transbank credentials!');
            $this->line('Please add to your .env file:');
            $this->line('TBK_COMMERCE_CODE=597055555532');
            $this->line('TBK_API_KEY=579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C');
            $this->line('TBK_INTEGRATION_TYPE=TEST');
        } else {
            $this->info('✅ Transbank credentials are configured');
        }
        
        return 0;
    }
}
