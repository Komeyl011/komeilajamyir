<?php

namespace App\Http\Controllers;

use Symfony\Component\Panther\Client;
use Illuminate\Http\Request;

class CurrencyPrice extends Controller
{
    public function index()
    {
        // $client = Client::createChromeClient(chromeDriverBinary: asset("/chromedriver"));  // Launch headless Chrome
        $client = Client::createFirefoxClient();  // Launch headless FireFox
        $crawler = $client->request('GET', 'https://www.tgju.org/currency');  // Replace with your target URL

        $tables = $crawler->filter('table');

        $results = [];

        foreach ($tables as $index => $table) {
            if ($index + 1 > 2) break;  // Process only the first 2 tables

            $rows = (new \Symfony\Component\DomCrawler\Crawler($table))->filter('tbody tr');

            foreach ($rows as $row) {
                $rowCrawler = new \Symfony\Component\DomCrawler\Crawler($row);
                $currencyName = $rowCrawler->filter('th')->text('');
                $currentPrice = $rowCrawler->filter('.nf')->first()->text('');

                $results[] = [
                    'currency_name' => trim($currencyName),
                    'price' => trim($currentPrice),
                ];
            }
        }

        print_r($results);  // Output results
    }
}
