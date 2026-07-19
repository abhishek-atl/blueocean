<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-sms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test sms integration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $smsService = app()->make('App\Services\SmsService');
        $response = $smsService->sendSms(['+447700900123'], 'Test SMS from Blue Ocean', 'Blue Ocean');
        $this->info('SMS sent successfully. Response: ' . json_encode($response));
    }
}
