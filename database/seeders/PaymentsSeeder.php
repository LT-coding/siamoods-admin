<?php

namespace Database\Seeders;

use App\Models\Payments;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Payments::query()->create([
            'name' => 'cash',
            'title' => 'Կանխիկ | Իդրամ QR կոդով (առաքման ժամանակ)',
            'cash' => 1
        ]);

        Payments::query()->create([
            'name' => 'card',
            'title' => 'Կրեդիտ քարտ',
            'image' => '/images/payment/cc4.png'
        ]);

        Payments::query()->create([
            'name' => 'telcell',
            'title' => 'Telcell',
            'image' => '/images/payment/Telcell-Wallet.png'
        ]);

        Payments::query()->create([
            'name' => 'idram',
            'title' => 'Idram',
            'image' => '/images/payment/Idram.png'
        ]);
    }
}
