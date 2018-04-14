<?php

namespace App\Models;

use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use SortableTrait;

    protected $table = 'locations';
    public $modelName = 'Location';

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];

    public function __construct()
    {
      return $this;
    }
}
