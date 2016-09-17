<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

use App\Services\StockPrice;
use App\Services\PortValue;

class UpdateStockPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:stockprice';

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
        $max_attempts = 10;
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

        $this->line("\nUpdate stock price.");
        $bar = $this->output->createProgressBar(count($stocks));
        foreach ($stocks as $stock) {
                DB::table('stock_symbols')->where('symbol', $stock['symbol'])->update([
                    'close_price' => $stock['close_price'],
                    'is_suspended' => $stock['is_suspended']
                ]);
                $bar->advance();
        }
        $bar->finish();

        $this->info("\nUpdate stock price.");
        $this->line("\nUpdate user port.");
        $users = DB::table('users')->select('id')->get();
        $bar = $this->output->createProgressBar(count($users));
        foreach ($users as $user) {
            PortValue::update($user->id);
            $bar->advance();
        }
        $bar->finish();
        $this->info("\nUpdate user port.");

    }
}
