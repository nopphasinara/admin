<?php

namespace App\Models;

use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\Model;

class Facilities extends Model
{
    use SortableTrait;

    protected $table = 'facilities';
    public $modelName = 'Facilities';

    public function __construct()
    {
      return $this;
    }
}
