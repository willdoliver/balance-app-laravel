<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceModel extends Model
{
    use HasFactory;

    /**
     * @var array<int, string, string>
     */
    protected $fillable = [
        'accountId',
        'balance'
    ];
}
