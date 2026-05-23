<?php

namespace App\Services;

class MarketPriceService
{
    private $markets = [
        'biedronka' => ['name' => 'Biedronka', 'color' => '#e1131b', 'logo' => '🐞'],
        'zabka' => ['name' => 'Żabka', 'color' => '#006233', 'logo' => '🐸'],
        'lidl' => ['name' => 'Lidl', 'color' => '#0050aa', 'logo' => '🟡'],
        'auchan' => ['name' => 'Auchan', 'color' => '#e2231a', 'logo' => '🐦'],
    ];

    private $products = [
        'chleb' => ['name' => 'Chleb Pszenny 500g', 'base_price' => 3.50],
        'mleko' => ['name' => 'Mleko 3.2% 1L', 'base_price' => 3.90],
        'jajka' => ['name' => 'Jajka L (10 szt.)', 'base_price' => 9.99],
        'woda' => ['name' => 'Woda Mineralna 1.5L', 'base_price' => 1.99],
        'cola' => ['name' => 'Coca-Cola 1.5L', 'base_price' => 7.50],
        'piwo' => ['name' => 'Piwo Jasne 500ml', 'base_price' => 3.99],
        'chipsy' => ['name' => 'Chipsy Lays 140g', 'base_price' => 6.50],
        'maslo' => ['name' => 'Masło Ekstra 200g', 'base_price' => 6.99],
        'kurczak' => ['name' => 'Filet z Kurczaka 1kg', 'base_price' => 24.99],
        'ryz' => ['name' => 'Ryż Biały 1kg', 'base_price' => 4.50],
        'makaron' => ['name' => 'Makaron Spaghetti 500g', 'base_price' => 4.20],
        'ser' => ['name' => 'Ser Gouda 150g', 'base_price' => 5.50],
    ];

    public function searchItems($query)
    {
        $query = mb_strtolower(trim($query));
        $results = [];

        foreach ($this->products as $key => $product) {
            if (strpos($key, $query) !== false || strpos(mb_strtolower($product['name']), $query) !== false) {
                $prices = [];
                foreach ($this->markets as $mk => $market) {
                    $variation = rand(-10, 15) / 100;
                    $price = $product['base_price'] * (1 + $variation);
                    
                    $price = round($price * 2) / 2 - 0.01;
                    if ($price < 0.5) $price = $product['base_price'];

                    $prices[] = [
                        'market' => $market['name'],
                        'logo' => $market['logo'],
                        'color' => $market['color'],
                        'price' => number_format($price, 2)
                    ];
                }
                
                usort($prices, function($a, $b) {
                    return $a['price'] <=> $b['price'];
                });

                $results[] = [
                    'name' => $product['name'],
                    'prices' => $prices
                ];
            }
        }
        
        return $results;
    }
}
