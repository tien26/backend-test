<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class CarLoan extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function scopeRelationLoan($query, $filter)
    {
        return DB::table('car_loans as a')
            ->join('user_details as b', 'b.user_id', '=', 'a.user_id')
            ->join('car_lists as c', 'c.id', '=', 'a.car_id')
            ->select(
                'a.id',
                'a.user_id',
                'a.car_id',
                'a.no_loan',
                'a.start_date',
                'a.end_date',
                'a.status',
                'b.name',
                'b.sim',
                'b.phone',
                'c.merk',
                'c.model',
                'c.no_car',
                'c.price',
            )
            ->when($filter, function ($query, $no_loan) {
                return $query->where('a.no_loan', 'ilike', '%' . $no_loan . '%');
            })
            // ->when($filter['status'], function ($query, $status) {
            //     return $query->where('a.status', $status);
            // })
            ->orderBy('a.updated_at', 'desc')->where('a.status', true);
    }
}
