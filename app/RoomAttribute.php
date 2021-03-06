<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomAttribute extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'room_attributes';

    /**
     * @var array
     */
    protected $fillable = [
        'room_attribute_name'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'room_attribute_id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
