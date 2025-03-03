<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\StudentFee;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name', 'father_name', 'contact', 'date_of_birth', 'roll_no', 'standard', 'medium', 'fee_type', 'address', 'uuid'];
    protected $hidden = ['id', 'created_at', 'updated_at', 'deleted_at'];

    public function StudentFee()
    {
        return $this->hasOne(StudentFee::class);
    }
}
