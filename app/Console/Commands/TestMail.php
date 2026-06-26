<?php

namespace App\Console\Commands;

use App\Mail\PostcodeNotCovered;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tests Mail Configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = config('mail.to.admin_address');
        $postcode = 'EC1A';
        Mail::to($email)->send(new PostcodeNotCovered($postcode));
    }
}
