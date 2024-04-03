<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Payment::query()->create([
            'name' => 'cash',
            'title' => 'Կանխիկ | Իդրամ QR կոդով (առաքման ժամանակ)',
            'cash' => 1
        ]);

        Payment::query()->create([
            'name' => 'card',
            'title' => 'Կրեդիտ քարտ',
            'image' => '/images/payment/cc4.png'
        ]);

        Payment::query()->create([
            'name' => 'telcell',
            'title' => 'Telcell',
            'image' => '/images/payment/Telcell-Wallet.png'
        ]);

        Payment::query()->create([
            'name' => 'idram',
            'title' => 'Idram',
            'image' => '/images/payment/Idram.png'
        ]);
    }
}
