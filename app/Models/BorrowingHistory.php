<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class BorrowingHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function scopeHistory($query, array $filter)
    {
        return DB::table('borrowing_histories as a')
            ->join('car_loans as b', 'b.id', '=', 'a.loan_id')
            ->join('user_details as c', 'c.id', '=', 'b.user_id')
            ->select(
                'a.id',
                'a.loan_id',
                'a.total',
                'a.status',
                'b.user_id',
                'b.car_id',
                'b.no_loan',
                'b.start_date',
                'b.end_date',
                'c.name',
                'c.phone',
                'c.sim',
            )
            ->when($filter['loan'] ?? false, function ($query, $no_loan) {
                return $query->where('b.no_loan', 'ilike', '%' . $no_loan . '%');
            })
            ->when($filter['user'] ?? false, function ($query, $user) {
                return $query->where('b.user_id', $user);
            });
        // ->orderBy('a.updated_at', 'desc');
    }
}
