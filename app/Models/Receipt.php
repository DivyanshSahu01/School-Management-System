<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

class Receipt extends Model
{
    use HasFactory;
    protected $casts = ['created_at' => 'date:d/m/Y', 'updated_at' => 'datetime:d/m/Y H:m'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
