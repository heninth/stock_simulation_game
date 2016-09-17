<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\StockSymbol;
use App\Services\StockPrice;
use App\Services\PortValue;

class UpdateStockPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:stockprice {--schedule}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update stock price.';

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
     * @return mixed
     */
    public function handle()
    {
        $max_attempts = 20;
        $attempts = 0;

        do {
            $stocks = StockPrice::getAll();
            if ($stocks == false) {
                $attempts++;
                $this->error('Error, Attempts ' . $attempts . ', Retry.');
                sleep(5);
            } else {
                break;
            }

        } while ($attempts < $max_attempts);

        if (!$this->option('schedule')) $this->line("\nUpdate stock price.");
        if (!$this->option('schedule')) $bar = $this->output->createProgressBar(count($stocks));
        foreach ($stocks as $stock) {
                $s = StockSymbol::firstOrNew(['symbol' => $stock['symbol']]);
                $s->close_price = $stock['close_price'];
                $s->is_suspended = $stock['is_suspended'];
                $s->save();
                if (!$this->option('schedule')) $bar->advance();
        }
        if (!$this->option('schedule')) $bar->finish();
        $this->info("\nUpdate stock price.");

        if (!$this->option('schedule')) $this->line("\nUpdate user port.");
        $users = DB::table('users')->select('id')->get();
        if (!$this->option('schedule')) $bar = $this->output->createProgressBar(count($users));
        foreach ($users as $user) {
            PortValue::update($user->id);
            if (!$this->option('schedule')) $bar->advance();
        }
        if (!$this->option('schedule')) $bar->finish();
        $this->info("\nUpdate user port.");

    }
}
