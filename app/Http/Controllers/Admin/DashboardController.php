<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountAddress;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\WaitingList;
use App\OldModels\Payments;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware();
    }

    /**
     * Show the application dashboard.php.
     *
     * @return View
     */
    public function index(): View
    {
        $payments = Payment::all();
        $orders = Order::query()->where('status', Order::COMPLETED)->groupBy('payment_id')->select('payment_id', DB::raw('SUM(paid) as total'))->get();
        $sum = Order::query()->where('status', Order::COMPLETED)->sum('paid');

        $select = [
            "order_products.haysell_id",
            "products.item_name",
            DB::raw("sum(order_products.quantity) as quantity")
        ];

        $lastOrders=Order::query()
            ->where('status','<>',Order::UNDEFINED)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(7)
            ->get();

        $products10 = Order::query()
            ->select($select)
            ->where("orders.status", Order::COMPLETED)
            ->join("order_products", "orders.id", "order_products.order_id")
            ->join("products", "order_products.haysell_id", "products.haysell_id")
            ->groupBy("order_products.haysell_id")
            ->groupBy("products.item_name")
            ->orderBy('quantity', 'desc')
            ->limit(10)
            ->get();

        $select = [
            "categories.name",
            DB::raw("sum(order_products.quantity) as quantity")
        ];

        $categoriesBest = Order::query()
            ->where("orders.status", Order::COMPLETED)
            ->select($select)
            ->join("order_products", "orders.id", "order_products.order_id")
            ->join("product_categories", "product_categories.haysell_id", "order_products.haysell_id")
            ->join("categories", function (JoinClause $join) {
                $join->on("product_categories.category_id", "=", "categories.id");
                $join->on("categories.parent_id", "=", DB::raw("27499"));
            })
            ->groupBy("categories.id")
            ->groupBy("categories.name")
            ->orderBy('quantity', 'desc')
            ->get();

        $select = [
            "account_addresses.state",
            DB::raw("sum(order_products.quantity) as quantity")
        ];

        $regionStatistics = Order::query()
            ->where("orders.status", Order::COMPLETED)
            ->select($select)
            ->join("account_addresses", "orders.user_id", "account_addresses.user_id")
            ->join("order_products", "orders.id", "order_products.order_id")
            ->groupBy("account_addresses.state")
            ->orderBy('quantity', 'desc')
            ->get();

        $wait = WaitingList::query()
            ->with('product')
            ->get();

        $waiting = [];
        foreach ($wait as $w){
            $waiting[$w->haysell_id]['product'] = $w->product;
            $waiting[$w->haysell_id]['email'][] = $w->email;
        }

        return view('admin.dashboard', compact(['orders', 'sum', 'payments', 'lastOrders', 'products10', 'categoriesBest', 'regionStatistics', 'waiting']));
    }

    public function getChartData(Request $request): JsonResponse
    {
        $orders = Order::query()->where('status', Order::COMPLETED)
            ->whereYear('created_at', $request->input('year'))
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('YEAR(created_at) as year'), DB::raw('SUM(paid) as total'))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        return response()->json($orders);
    }
}
