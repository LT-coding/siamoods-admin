<?php

namespace App\Traits;

use App\Enums\LabelType;
use App\Enums\PromotionType;
use App\Enums\ReviewStatus;
use App\Enums\RoleTypes;
use App\Enums\StatusTypes;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait GetRecordsTrait
{
    public function searchAndSort(Request $request, $query, $columns, $orderColumns): void
    {
        if ($request->has('search') && !empty($request->search['value'])) {
            $search = $request->search['value'];
            $query->where(function ($q) use ($search, $columns) {
                foreach ($columns as $column) {
                    // Skip custom attributes for now
                    if (!in_array($column,['role','status','category','created_at','label_type','promo_type','sender_email','recipient_email','spend','exist','review_status'])) {
                        $q->orWhere($column, 'like', "%{$search}%");
                    }

                    if ($column === 'role') {
                        // Search by custom role names from the enum
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
//                        $q->searchAndSortByCategory($search);
                    }

                    if ($column === 'sender_email') {
                        $q->orWhereHas('senderUser', function ($subQuery) use ($search) {
                            $subQuery->where('email', 'like', '%' . $search . '%');
                        });
                    }

                    if ($column === 'recipient_email') {
                        $q->orWhereHas('recipientUser', function ($subQuery) use ($search) {
                            $subQuery->where('email', 'like', '%' . $search . '%');
                        });
                    }
                }
            });
        }

        if ($request->has('order') && !empty($request->order)) {
            $order = $request->order[0];
            $columnIndex = $order['column'];
            $direction = $order['dir'];
            $orderColumn = $orderColumns[$columnIndex];

            // Check if order column is a custom attribute
            if ($orderColumn == 'status') {
                $query->orderBy('status', $direction);
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
            } else {
                // Order by regular column
                $query->orderBy($orderColumn, $direction);
            }
        }
    }
}
