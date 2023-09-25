<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helper\ZoopGateway;
use App\Payment;

class TesteZoopIntegration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zoop:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Teste Zoop Integration';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $lastRecharge = Payment::orderBy('id', 'DESC')->limit(1)->first();

        $zoopGateway = new ZoopGateway;

        $authorize = $zoopGateway->createCharge($lastRecharge);

        $this->info(print_r($authorize->getResponse()));
    }
}
