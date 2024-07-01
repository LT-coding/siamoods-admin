<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentMethod::query()->create([
            'name' => 'cash',
            'title' => 'Կանխիկ | Իդրամ QR կոդով (առաքման ժամանակ)',
            'cash' => 1
        ]);

        PaymentMethod::query()->create([
            'name' => 'card',
            'title' => 'Կրեդիտ քարտ',
            'image' => '/images/payment/cc4.png'
        ]);

        PaymentMethod::query()->create([
            'name' => 'telcell',
            'title' => 'Telcell',
            'image' => '/images/payment/Telcell-Wallet.png'
        ]);

        PaymentMethod::query()->create([
            'name' => 'idram',
            'title' => 'Idram',
            'image' => '/images/payment/Idram.png'
        ]);
    }
}
