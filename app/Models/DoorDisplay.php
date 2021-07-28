<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoorDisplay extends Model
{
    use HasFactory;
    protected $table = 'doordisplay';
    protected $fillable = [
        'name', 'cabinet_number', 'status' , 'doors_id'
    ];
    public $timestamps = false;
}
