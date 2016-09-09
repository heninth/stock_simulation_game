<?php

use Illuminate\Database\Seeder;
use App\Libralies\StockPrice;

class StockSymbolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stock_symbols')->insert(StockPrice::getAll());
    }
}
