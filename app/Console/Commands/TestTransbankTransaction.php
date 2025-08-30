<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TransbankService;
use Illuminate\Support\Str;

class TestTransbankTransaction extends Command
{
    protected $signature = 'transbank:test-transaction';
    protected $description = 'Test creating a Transbank transaction';

    public function handle()
    {
        $this->info('Testing Transbank Transaction Creation:');
        $this->line('');
        
        try {
            $transbankService = new TransbankService();
            $transaction = $transbankService->makeTransaction();
            
            $this->info('✅ Transaction instance created successfully');
            $this->line('Commerce Code: ' . config('services.transbank.commerce_code'));
            $this->line('Environment: ' . config('services.transbank.environment'));
            $this->line('');
            
            $this->info('Attempting to create a test transaction...');
            
            $response = $transaction->create(
                buyOrder: 'ORDER' . time(),
                sessionId: 'SESSION' . time(),
                amount: 1000,
                returnUrl: 'http://localhost:8000/checkout/success'
            );
            
            $this->info('✅ Test transaction created successfully!');
            $this->line('Token: ' . $response->getToken());
            $this->line('URL: ' . $response->getUrl());
            
        } catch (\Throwable $e) {
            $this->error('❌ Failed to create transaction: ' . $e->getMessage());
            $this->line('Full error: ' . get_class($e) . ' - ' . $e->getMessage());
            
            if ($e->getPrevious()) {
                $this->line('Previous error: ' . $e->getPrevious()->getMessage());
            }
        }
        
        return 0;
    }
}