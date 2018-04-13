<?php

namespace App\Admin\Helpers;

// use Encore\Admin\Form;
// use Encore\Admin\Grid;
// use Encore\Admin\Facades\Admin;
// use Encore\Admin\Layout\Content;
// use App\Http\Controllers\Controller;
// use Encore\Admin\Controllers\ModelForm;

class LocationFormRender
{
  protected $grid;

  public function __construct($grid)
  {
      $this->grid = $grid;
  }

  public static function gridRender($grid)
  {
    $grid->id('ID')->sortable();
    //Set host, width and height
    // $grid->image()->image('http://laravel-admin.org/img/redpacket.png', 100, 100);
    $grid->name('Name')->sortable();
    // $grid->name()->limit(30)->ucfirst()->substr(1, 10);

    // $grid->listings('Total Listings')->display(function ($listings) {
    //   $count = count($listings);
    //   return "{$count}";
    // });

    // $grid->title()->color('#ccc');

    $grid->created_at();
    $grid->paginate(30);
    $grid->orderable();
    $grid->disableExport();

    $grid->model()->orderBy('id', 'ASC');

    // chain method calls to display multiple images
    // $grid->images();
    // $grid->images()->display(function ($images) {
    //   return json_decode($images, true);
    // })->map(function ($path) {
    //   return 'http://localhost/images/'. $path;
    // })->image();

    // set the `text`、`color`、and `value`
    // $states = [
    //   'on'  => ['value' => 1, 'text' => 'YES', 'color' => 'primary'],
    //   'off' => ['value' => 2, 'text' => 'NO', 'color' => 'default'],
    // ];
    // $grid->status()->switch($states);
    //
    // $states = [
    //   'on' => ['text' => 'YES'],
    //   'off' => ['text' => 'NO'],
    // ];
    //
    // $grid->column('switch_group')->switchGroup([
    //   'hot'       => 'Hot',
    //   'new'       => 'New'
    //   'recommend' => 'Recommend',
    // ], $states);


    // $grid->name()->editable();

    $grid->created_at();
    // $grid->updated_at();
    // $grid->release_at();

    LocationFormRender::gridFilters($grid);
    LocationFormRender::gridActions($grid);
  }

  public static function gridFilters($grid)
  {
    $grid->filter(function ($filter) {
      $filter->equal('datetime')->datetime([]);

      // `date()` equals to `datetime(['format' => 'YYYY-MM-DD'])`
      $filter->equal('date')->date();

      // `time()` equals to `datetime(['format' => 'HH:mm:ss'])`
      $filter->equal('time')->time();

      // `day()` equals to `datetime(['format' => 'DD'])`
      $filter->equal('day')->day();

      // `month()` equals to `datetime(['format' => 'MM'])`
      $filter->equal('month')->month();

      // `year()` equals to `datetime(['format' => 'YYYY'])`
      $filter->equal('year')->year();

      $filter->in('checkbox')->checkbox([
        'm'    => 'Male',
        'f'    => 'Female',
      ]);
      $filter->equal('radio')->radio([
        ''   => 'All',
        0    => 'Unreleased',
        1    => 'Released',
      ]);
      $filter->in('multipleSelect')->multipleSelect(['key' => 'value']);

      // // Or from the api to obtain data, api format reference model-form `multipleSelect` component
      $filter->in('multipleSelectapi')->multipleSelect('api/users');

      $filter->equal('url')->url();

      $filter->equal('email')->email();

      $filter->equal('integer')->integer();

      $filter->equal('ip')->ip();

      $filter->equal('mac')->mac();

      $filter->equal('mobile')->mobile();

      $filter->equal('select')->select(['key' => 'value']);

      // Or from the api to obtain data, api format reference model-form `select` component
      $filter->equal('selectapi')->select('api/users');

      // $options refer to https://github.com/RobinHerbots/Inputmask/blob/4.x/README_numeric.md
      $filter->equal('decimal')->decimal([]);

      // $options refer to https://github.com/RobinHerbots/Inputmask/blob/4.x/README_numeric.md
      $filter->equal('currency')->currency([]);

      // $options refer to https://github.com/RobinHerbots/Inputmask/blob/4.x/README_numeric.md
      $filter->equal('percentage')->percentage([]);

      // $options refer to https://github.com/RobinHerbots/Inputmask
      $filter->equal('inputmask')->inputmask([], $icon = 'pencil');

      $filter->equal('placeholder')->placeholder('Please input...');

      // Remove the default id filter
      $filter->disableIdFilter();
      // Add a column filter
      $filter->like('name', '$label');
      $filter->equal('column', '$label');
      $filter->notEqual('column', '$label');
      $filter->like('column', '$label');
      $filter->ilike('column', '$label');
      $filter->gt('column', '$label');
      $filter->lt('column', '$label');
      $filter->between('column', '$label');
      // set datetime field type
      $filter->between('column', '$label')->datetime();
      // set time field type
      $filter->between('column', '$label')->time();
      $filter->in('column', '$label')->multipleSelect(['key' => 'value']);
      $filter->notIn('column', '$label')->multipleSelect(['key' => 'value']);
      $filter->date('column', '$label');
      $filter->day('column', '$label');
      $filter->month('column', '$label');
      $filter->year('column', '$label');
      $filter->where(function ($query) {
        $query->whereHas('profile', function ($query) {
          $query->where('address', 'like', "%{$this->input}%")
                ->orWhere('email', 'like', "%{$this->input}%");
        });

        $query->whereRaw("`rate` >= 6 AND `created_at` = {$this->input}");
        $query->where('title', 'like', "%{$this->input}%")
              ->orWhere('content', 'like', "%{$this->input}%");
      }, 'Text');
    });
  }

  public static function gridActions($grid)
  {
    $grid->actions(function ($actions) {
      // $actions->append(new CheckRow($actions->getKey()));
      // $actions->append('');
      // $actions->prepend('');
      // echo '<pre>'; print_r($actions->getKey()); echo '</pre>';
      // echo '<pre>'; print_r($actions->row); echo '</pre>';
      // $actions->disableDelete();
      // $actions->disableEdit();
    });
  }

  public static function formRender($form)
  {
      $form->display('id', 'ID');

      $form->display('created_at', 'Created At');
      $form->display('updated_at', 'Updated At');
  }
}
