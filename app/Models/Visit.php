<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;
    protected $table = 'visits';
    protected $fillable = [
        'date_created' , 'date_finished', 'date_confirmed', 'visit_information', 'visit_date',
        'comments', 'recommendations', 'conclusion', 'status', 'unlock_id',
        'doors_id', 'user_id', 'doctor_id'
    ];
    protected $casts = [
        'unregistereduserdata' => 'array'
    ];
    public $timestamps = false;

    public static function search($data)
    {
        return Visit::select('visits.*')
            ->where(function ($query) use ($data) {
                $query->when($data, function ($query) use ($data) {
                    $query->orWhere('users.name', 'LIKE', "%$data%");
                });
            });
    }
}
