<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesTargetBudget extends Model
{
    use HasFactory;

    protected $table = 'sales_target_budgets';

    protected $fillable = [
        'users_id',
        'period',
        'total_sales_target',
        'room_rev_target',
        'fb_rev_target',
        'budget_w1',
        'budget_w2',
        'budget_w3',
        'budget_w4',
    ];

    protected $casts = [
        'total_sales_target' => 'double',
        'room_rev_target'    => 'double',
        'fb_rev_target'      => 'double',
        'budget_w1'          => 'double',
        'budget_w2'          => 'double',
        'budget_w3'          => 'double',
        'budget_w4'          => 'double',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
