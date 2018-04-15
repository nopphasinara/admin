<?php

namespace App\Models;

use App\Models\ListingType;
use App\Models\Feature;

use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use SortableTrait;

    protected $table = 'listings';
    public $modelName = 'Listing';

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];

    public function __construct()
    {
      return $this;
    }

    // Model Attributes
    public function setImageAttribute($image)
    {
        if (is_array($image)) {
            $this->attributes['image'] = json_encode($image);
        }
    }

    public function getImageAttribute($image)
    {
        return json_decode($image, true);
    }
}
