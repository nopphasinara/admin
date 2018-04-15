<?php

namespace App\Models;

use App\Models\Listing;

use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use SortableTrait;

    protected $table = 'features';
    public $modelName = 'Feature';

    public function __construct()
    {
      return $this;
    }
}
