<?php

namespace App\Models;

use App\Models\Listing;

use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\Model;

class ListingType extends Model
{
    use SortableTrait;

    protected $table = 'listing_types';
    public $modelName = 'Listing Type';

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];

    public function __construct()
    {
      return $this;
    }
}
