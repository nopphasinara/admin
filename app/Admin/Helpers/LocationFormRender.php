<?php

namespace App\Admin\Helpers;

use Encore\Admin\Form;
// use Encore\Admin\Grid;
// use Encore\Admin\Facades\Admin;
// use Encore\Admin\Layout\Content;
// use App\Http\Controllers\Controller;
// use Encore\Admin\Controllers\ModelForm;

class LocationFormRender
{
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
      $form->embeds('extra', 'Extra', function ($form) {

        $form->text('extra1')->rules('required');
        $form->email('extra2')->rules('required');
        $form->mobile('extra3');
        $form->datetime('extra4');

        $form->dateRange('extra5', 'extra6', 'Date range')->rules('required');

      });

      // $form->hasMany('paintings', function ($form) {
      //   $form->text('title');
      //   $form->image('body');
      //   $form->datetime('completed_at');
      // });

      $form->tab('Basic info', function ($form) {

        $form->display('display', 'display');

        $form->divide();

        $form->html('html contents');

        $form->tags('keywords');

        $form->icon('icon');

        $states = [
          'on'  => ['value' => 1, 'text' => 'enable', 'color' => 'success'],
          'off' => ['value' => 0, 'text' => 'disable', 'color' => 'danger'],
        ];
        $form->switch('switch', 'switch')->states($states);

        $form->display('id', 'ID');
        $form->text('name', 'Name')->placeholder('Please put your name')->rules('required|min:3');
        $form->text('slug', 'Slug')->help('Slug will genreate automatically');

        // Complex validation rules can be implemented in the callback
        $form->text('validation')->rules(function ($form) {

          // If it is not an edit state, add field unique verification
          if (!$id = $form->model()->id) {
            return 'unique:users,email_address';
          }

        });

        $form->text('regex')->rules('required|regex:/^\d+$/|min:10', [
          'regex' => 'code must be numbers',
          'min'   => 'code can not be less than 10 characters',
        ]);

        $form->text('nullable')->rules('nullable');

        $form->text('rules', 'Rules')->rules('required|min:10');
        $form->select('select', 'Select')->options([
          1 => 'foo',
          2 => 'bar',
          'val' => 'Option name',
        ]);

        $form->select('user_id')->options(function ($id) {
          $user = \App\Models\User::find($id);
          if ($user) {
            return [
              $user->id => $user->name,
            ];
          }
        })->ajax('/admin/api/users');

        $form->listbox('listbox', 'listbox')->options([
          1 => 'foo',
          2 => 'bar',
          'val' => 'Option name',
        ]);

        $form->radio('radio', 'radio')->options(['m' => 'Female', 'f'=> 'Male'])->default('m');

        $form->radio('radio', 'radiostacked')->options(['m' => 'Female', 'f'=> 'Male'])->default('m')->stacked();

        $form->checkbox('checkbox', 'checkbox')->options([1 => 'foo', 2 => 'bar', 'val' => 'Option name']);

        $form->checkbox('checkboxstacked', 'checkboxstacked')->options([1 => 'foo', 2 => 'bar', 'val' => 'Option name'])->stacked();

        // Use google map
        // $form->map('latitude', 'longitude', 'Map')->useGoogleMap();

        $form->slider('slider', 'slider')->options([
          'max' => 100,
          'min' => 1,
          'step' => 1,
          'postfix' => 'years old',
        ]);

        $form->editor('editor', 'editor');

      })->tab('Profile', function ($form) {

        $form->textarea('description', 'Description')->rows(14);
        $form->multipleSelect('tags')->options(\App\Models\Tag::all()->pluck('name', 'id'));

        // $form->select('province')->options(function ($code) {
        //   $province = \App\Models\ChinaArea::where('Code', $code)->get();
        // })->load('city', '/api/city');
        // $form->select('city');

      })->tab('Jobs', function ($form) {

        // $form->text('title')->attribute([
        //   'data-title' => 'title',
        // ]);

        // $form->select('director', 'Director')->options([
        //   'John'  => 1,
        //   'Smith' => 2,
        //   'Kate'  => 3,
        // ]);

        // $form->number('rate', 'Rate');
        // $form->switch('released', 'Released?');
        // $form->dateTime('release_at', 'release time');

        $form->email('email', 'email');
        $form->password('password', 'password');
        $form->url('url', 'url');
        $form->ip('ip', 'ip');
        $form->color('color', 'color')->default('#FFFF00');
        $form->mobile('mobile', 'mobile')->options([
          'mask' => '000-000-0000',
        ]);

        $form->time('time', 'time')->format('HH:mm:ss');
        $form->date('date', 'date')->format('YYYY-MM-DD');
        $form->datetime('datetime', 'datetime')->format('YYYY-MM-DD HH:mm:ss');
        $form->timeRange('00:00:00', '23:59:59', 'Time Range');
        $form->dateRange('2000-01-01', '2010-12-31', 'Date Range');
        $form->datetimeRange('2000-01-01 00:00:00', '2010-12-31 23:59:59', 'DateTime Range');
        $form->currency('currency', 'currency')->symbol('￥');
        $form->number('number', 'number');
        $form->rate('rate', 'rate');

        $form->display('created_at', 'Created At');
        $form->display('updated_at', 'Updated At');

      });

      $form->disableReset();
      // $form->disableSubmit();

      $form->setWidth(10, 2);
      $form->setAction('admin/users');

      // $form->ignore('column1', 'column2', 'column3');
      // $form->hidden('');

      LocationFormRender::formUploadFields($form);
      LocationFormRender::formTools($form);
  }

  public static function formUploadFields($form)
  {
    // $form->file('file_column');
    $form->image('image', 'Image')->uniqueName();
    // $form->image('image', 'image');
    // Modify the image upload path and file name
    // $form->image('image', 'image')->move($dir, $name);
    // Crop picture
    // $form->image('image', 'image')->crop(int $width, int $height, [int $x, int $y]);
    // Add a watermark
    // $form->image('image', 'image')->insert($watermark, 'center');
    // add delete button
    $form->image('image', 'image')->removable();
    // use a unique name (md5(uniqid()).extension)
    // $form->image('picture')->uniqueName();
    // specify filename
    // $form->image('picture')->name(function ($file) {
    //   return 'test.'.$file->guessExtension();
    // });

    // $form->file('file', 'file');
    // Modify the file upload path and file name
    // $form->file('file', 'file')->move($dir, $name);
    // And set the upload file type
    // $form->file('file', 'file')->rules('mimes:doc,docx,xlsx');
    // add delete button
    $form->file('file', 'file')->removable();

    // multiple image
    // $form->multipleImage('multipleImage', 'multipleImage');
    // multiple file
    // $form->multipleFile('multipleFile', 'multipleFile');
    // add delete button
    $form->multipleFile('multipleFile', 'multipleFile')->removable();
  }

  public static function formTools($form)
  {
    $form->tools(function (Form\Tools $tools) {
      // Disable back btn.
      // $tools->disableBackButton();
      // Disable list btn
      $tools->disableListButton();

      // Add a button, the argument can be a string, or an instance of the object that implements the Renderable or Htmlable interface
      // $tools->add('<a class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;delete</a>');
    });
  }
}
