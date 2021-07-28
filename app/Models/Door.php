<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;

class Door extends Model
{
    use HasFactory;
    protected $table = 'doors';
    protected $fillable = [
        'ip', 'port', 'name', 'department', 'user_id', 'door_id'
    ];
    protected $casts = [
        'user_rights' => 'array'
    ];
    public $timestamps = false;

    public static function search($data)
    {
        return Door::select('doors.*')
            ->where(function ($query) use ($data) {
                $query->when($data, function ($query) use ($data) {
                    $query->orWhere('ip', 'LIKE', "%$data%");
                    $query->orWhere('name', 'LIKE', "%$data%");
                    $query->orWhere('department', 'LIKE', "%$data%");
                });
            });
    }

    public function rights()
    {
        return $this->hasMany(DoorRights::class);
    }
}
