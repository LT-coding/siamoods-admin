<?php

namespace App\Traits;

use App\Enums\LabelType;
use App\Enums\OrderStatusEnum;
use App\Enums\PromotionType;
use App\Enums\ReviewStatus;
use App\Enums\RoleTypes;
use App\Enums\StatusTypes;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait GetRecordsTrait
{
    public function searchAndSort(Request $request, $query, $columns, $orderColumns): void
    {
        if ($request->has('search') && !empty($request->search['value'])) {
            $search = $request->search['value'];
            $query->where(function ($q) use ($search, $columns) {
                foreach ($columns as $column) {
                    $customColumns = ['product_id','role','status','category','created_at','label_type','promo_type',
                        'sender_email','recipient_email','spend','exist','review_status','user_name', 'phone', 'zip', 'order_status', 'payment'
                    ];
                    // Skip custom attributes for now
                    if (!in_array($column,$customColumns)) {
                        $q->orWhere($column, 'like', "%{$search}%");
                    }

                    if ($column === 'role') {
                        foreach (RoleTypes::cases() as $roleType) {
                            if (str_contains(mb_strtolower($roleType->value), mb_strtolower($search))) {
                                $q->orWhereHas('roles', function ($subQuery) use ($roleType) {
                                    $subQuery->where('name', $roleType->name);
                                });
                            }
                        }
                    }
                    if ($column === 'created_at') {
                        $q->orWhere(DB::raw("DATE_FORMAT(created_at, '%d.%m.%Y')"), 'like', "%{$search}%");
                    }
                    if ($column === 'product_id') {
                        $q->orWhere('products.id', 'like', "%{$search}%");
                    }
                    if ($column === 'status') {
                        $list = StatusTypes::statusList();
                        foreach ($list as $key => $value) {
                            if (str_contains(mb_strtolower($value), mb_strtolower($search))) {
                                $q->orWhere('status', $key);
                            }
                        }
                    }
                    if ($column === 'review_status') {
                        $list = ReviewStatus::statusList();
                        foreach ($list as $key => $value) {
                            if (str_contains(mb_strtolower($value), mb_strtolower($search))) {
                                $q->orWhere('status', $key);
                            }
                        }
                    }
                    if ($column === 'label_type') {
                        $list = LabelType::typeList();
                        foreach ($list as $key => $value) {
                            if (str_contains(mb_strtolower($value), mb_strtolower($search))) {
                                $q->orWhere('type', $key);
                            }
                        }
                    }
                    if ($column === 'promo_type') {
                        $list = PromotionType::typeList();
                        foreach ($list as $key => $value) {
                            if (str_contains(mb_strtolower($value), mb_strtolower($search))) {
                                $q->orWhere('type', $key);
                            }
                        }
                    }
                    if ($column === 'category') {
                        $q->searchAndSortByCategory($search);
                    }
                    if ($column === 'sender_email') {
                        $q->orWhereHas('senderUser', function ($subQuery) use ($search) {
                            $subQuery->where('email', 'like', "%{$search}%");
                        });
                    }
                    if ($column === 'recipient_email') {
                        $q->orWhereHas('recipientUser', function ($subQuery) use ($search) {
                            $subQuery->where('email', 'like', "%{$search}%");
                        });
                    }
                    if (in_array($column,['user_name','phone'])) {
                        $q->orWhereHas('user', function ($subQuery) use ($search) {
                            $subQuery->where(function ($sq) use ($search){
                                $sq->where(DB::raw("CONCAT(IFNULL(name, ''), ' ', IFNULL(lastname, ''), IF(name IS NULL AND lastname IS NULL, email, ''))"), 'like',  "%{$search}%")
                                    ->orWhere('phone', 'like', "%{$search}%");
                            });

                        });
                    }
                    if ($column === 'zip') {
                        $q->orWhereHas('user.shippingAddress', function ($subQuery) use ($search) {
                            $subQuery->where('zip', 'like', "%{$search}%");
                        });
                    }
                    if ($column === 'order_status') {
                        $statusKeys = array_keys(array_filter(OrderStatusEnum::searchList(), function($status) use ($search) {
                            return stripos($status, $search) !== false;
                        }));
                        if (!empty($statusKeys)) {
                            $q->orWhereIn('status', $statusKeys);
                        }
                    }
                    if ($column === 'payment') {
                        $q->orWhereHas('payment', function ($subQuery) use ($search) {
                            $subQuery->where('title', 'like', "%{$search}%");
                        });
                    }
                }
            });
        }

        if ($request->has('from') || $request->has('to')) {
            $from = $request->get('from');
            $to = $request->get('to');
            $query->where([['created_at', '>=', $from],['created_at', '<=', $to]]);
        }

        if ($request->has('order') && !empty($request->order)) {
            $order = $request->order[0];
            $columnIndex = $order['column'];
            $direction = $order['dir'];
            $orderColumn = $orderColumns[$columnIndex];

            // Check if order column is a custom attribute
            if ($orderColumn == 'status') {
                $query->orderBy('status', $direction);
            } elseif ($orderColumn == 'product_id') {
                $query->orderBy('id', $direction);
            } elseif ($orderColumn == 'sender_email') {
                $query->join('users as sender_users', 'sender_users.id', '=', 'gift_cards.sender_id')
                    ->select('gift_cards.*', 'sender_users.email as sender_email')
                    ->orderBy('sender_email', $direction)
                    ->orderBy('gift_cards.id', 'desc');
            } elseif ($orderColumn == 'recipient_email') {
                $query->join('users as recipient_users', 'recipient_users.id', '=', 'gift_cards.recipient_id')
                    ->select('gift_cards.*', 'recipient_users.email as recipient_email')
                    ->orderBy('recipient_email', $direction)
                    ->orderBy('gift_cards.id', 'desc');
            } elseif ($orderColumn == 'category') {
                $query->searchAndSortByCategory(null, $direction);
            } elseif ($orderColumn == 'user_name') {
                $query->join('users', 'users.id', '=', 'orders.user_id')
                    ->select('orders.*', DB::raw("CONCAT(IFNULL(users.name, ''), ' ', IFNULL(users.lastname, ''), IF(users.name IS NULL AND users.lastname IS NULL, users.email, '')) as user_name"))
                    ->orderBy('user_name', $direction);
            } elseif ($orderColumn == 'phone') {
                $query->join('users', 'users.id', '=', 'orders.user_id')
                    ->select('orders.*', 'users.phone as user_phone')
                    ->orderBy('user_phone', $direction);
            } elseif ($orderColumn == 'zip') {
                $query->join('users', 'users.id', '=', 'orders.user_id')
                    ->join('account_addresses', 'account_addresses.user_id', '=', 'users.id')
                    ->select('orders.*', 'account_addresses.zip as user_zip')
                    ->orderBy('user_zip', $direction);
            } elseif ($orderColumn == 'payment') {
                $query->join('payments', 'payments.id', '=', 'orders.payment_method_id')
                    ->select('orders.*', 'payments.title as payment_title')
                    ->orderBy('payment_title', $direction);
            } elseif ($orderColumn == 'order_status') {
                $query->orderBy('status', $direction);
            } else {
                // Order by regular column
                $query->orderBy($orderColumn, $direction);
            }
        }
    }
}
