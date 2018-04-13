<?php

namespace App\Models;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Location extends Model
{

  use SortableTrait;

  protected $table = 'locations';

  public $sortable = [
      'order_column_name' => 'order_no',
      'sort_when_creating' => true,
  ];

  public function listing()
  {
    return $this->hasMany(Location::class);
  }

  public function grid($callback)
  {
    return new Grid(new static, $callback);
  }

  public function form($callback)
  {
    return new Form(new static, $callback);
  }
}
