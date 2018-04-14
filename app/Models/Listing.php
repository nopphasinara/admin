<?php

namespace App\Models;

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
}
