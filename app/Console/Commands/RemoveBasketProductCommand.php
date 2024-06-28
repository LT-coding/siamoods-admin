<?php

namespace App\Console\Commands;

use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RemoveBasketProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remove-basket-product-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('Started remove unpaid orders of guests');

        $cartItems = OrderProduct::cartProducts()
            ->where('created_at', '<=', Carbon::now()->subDay())
            ->get();

        foreach ($cartItems as $item) {
            if (!$item->user) {
                OrderProduct::cartProducts()
                    ->where('user_id',$item->user_id)
                    ->delete();
            }
        }

        Log::info('Ended remove unpaid orders of guests');
    }
}
