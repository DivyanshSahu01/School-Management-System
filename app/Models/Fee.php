<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;
    protected $fillable = ['admission_fee', 'exam_fee', 'monthly_fee'];
    protected $hidden = ['id', 'created_at', 'updated_at'];
}
