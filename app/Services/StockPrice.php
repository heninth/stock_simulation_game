<?php

namespace App\Services;

use Symfony\Component\DomCrawler\Crawler;

class StockPrice
{
    /**
     * Retrieve stock price form set.or.th
     *
     * @return array
     */
    public static function getAll ()
    {
        $stocks = static::crawler('http://marketdata.set.or.th/mkt/commonstocklistresult.do?market=SET&type=S', 'SET');
        $stocks = array_merge($stocks, static::crawler('http://marketdata.set.or.th/mkt/commonstocklistresult.do?market=mai&type=S', 'mai'));
        return $stocks;
    }

    private static function crawler($url, $market)
    {
        $html = file_get_contents($url);
        $crawler = new Crawler($html);

        return $crawler->filter('#maincontent > .row > .row')->eq(1)->filter('tbody > tr')->each(function (Crawler $node, $i) use($market) {
            $symbol = preg_replace('/[^A-Za-z0-9\-\&]/', ' ', $node->filter('td')->eq(0)->text());
            $symbol = trim($symbol);
            $data['symbol'] = html_entity_decode($symbol);
            $data['close_price'] = str_replace(',', '', $node->filter('td')->eq(5)->text());
            $data['is_suspended'] = false;
            if ($data['close_price'] == '-')
            {
                $data['close_price'] = '0.00';
                $data['is_suspended'] = true;
            }
            $data['market'] = $market;
            return $data;
        });
    }
}

?>
