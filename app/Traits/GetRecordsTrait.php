<?php

namespace App\Traits;

use App\Enums\RoleTypes;
use App\Enums\StatusTypes;
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
                    if ($column !== 'role' && $column !== 'status' && $column !== 'created_at') {
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
                        $statusList = StatusTypes::statusList();
                        foreach ($statusList as $key => $value) {
                            if (str_contains(mb_strtolower($value), mb_strtolower($search))) {
                                $q->orWhere('status', $key);
                            }
                        }
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
            if ($orderColumn == 'role') {
//                TODO
            } elseif ($orderColumn == 'status') {
                // Order by status
                $query->orderBy('status', $direction);
            } else {
                // Order by regular column
                $query->orderBy($orderColumn, $direction);
            }
        }
    }
}
