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

  protected $casts = [
    'latlng' => 'json',
  ];

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

  public function setImagesAttribute($images)
  {
    if (is_array($images)) {
      $this->attributes['images'] = json_encode($images);
    }
  }

  public function getImagesAttribute($images)
  {
    return json_decode($images, true);
  }
}
