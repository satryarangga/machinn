<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyAttribute extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'property_attributes';

    /**
     * @var array
     */
    protected $fillable = [
        'property_attribute_name', 'type', 'purchase_date', 'purchase_amount', 'qty'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'property_attribute_id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @param $category
     * @return string
     */
    public static function categoryName ($category){
        switch($category){
            case 1:
                return 'Furniture Hotel';
            break;
            case 2:
                return 'Electronic';
            break;
            case 3;
                return 'Kitchen Equipment';
            break;
            default;
                return 'Others';
            break;
        }

    }
}
