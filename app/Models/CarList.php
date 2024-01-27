<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarList extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function scopeSearch($query, $filters)
    {
        $query->when($filters ?? false, function ($query, $search) {
            return $query->where('merk', 'ilike', '%' . $search . '%')->orWhere('model', 'ilike', '%' . $search . '%')->orWhere('no_car', 'ilike', '%' . $search . '%');
        });
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['status'] ?? false, function ($query, $status) {
            return $query->where('status', $status);
        });
    }
}
