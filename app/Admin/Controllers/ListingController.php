<?php

namespace App\Admin\Controllers;

use App\Models\Listing;
use App\Models\ListingType;
use App\Models\Location;
use App\Models\Feature;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Layout\Column;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class ListingController extends Controller
{
    use ModelForm, SortableTrait;

    protected $model;

    public function __construct()
    {
      $this->model = new Listing;
    }

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header($this->model->modelName . 's');
            // $content->description('description');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header($this->model->modelName);
            // $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header($this->model->modelName);
            // $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Listing::class, function (Grid $grid) {

            $grid->disableExport();
            $grid->id('ID')->sortable();

            $grid->image('Image')->display(function ($image) {
                if (count($image)) {
                    return $image[0];
                }
            })->image('', 100, 100);

            $grid->column('name')->display(function () {
                return '<a href="'. route('listings.edit', ['id' => $this->id]) .'">'. $this->name .'</a>';
            })->sortable();

            $grid->column('listing_type_id')->display(function () {
                $listingType = ListingType::where('id', $this->listing_type_id)->select(['id', 'name'])->first();
                return '<a href="'. route('listing-types.edit', ['id' => $this->listing_type_id]) .'">'. $listingType->name .'</a>';
            })->sortable();

            $grid->column('location_id')->display(function () {
                $location = Location::where('id', $this->location_id)->select(['id', 'name'])->first();
                return '<a href="'. route('locations.edit', ['id' => $this->location_id]) .'">'. $location->name .'</a>';
            })->sortable();

            $grid->column('Tools')->switchGroup([
                'featured',
                'web_visible',
                'for_sale',
                'for_rent',
            ], [
                'featured' => json_decode(config('attribute_response'), true),
                'web_visible' => json_decode(config('attribute_visible'), true),
                'for_sale' => json_decode(config('attribute_response'), true),
                'for_rent' => json_decode(config('attribute_response'), true),
            ]);

            $grid->created_at();


            // Customize filters
            $grid->filter(function($filter){
                $filter->disableIdFilter();

                $filter->where(function ($query) {
                    $query->where('name', 'like', "%{$this->input}%");
                }, 'Name');
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Listing::class, function (Form $form) {
            // Form building
            $form->setWidth(10, 2);
            $form->hidden('id');

            $form->tab('Info', function ($form) {
                $form->text('name', 'Name')->rules('required|min:2');
                $form->textarea('description', 'Description');
                $form->ckeditor('content', 'Content');

                $form->divide();

                $form->select('listing_type_id', 'Listing Type')->options(function () {
                    $options = [];
                    $data = ListingType::all()->toArray();
                    foreach ($data as $key => $listingType) {
                        $options[$listingType['id']] = $listingType['name'];
                    }
                    return $options;
                });

                $form->select('location_id', 'Location')->options(function () {
                    $options = [];
                    $data = Location::all()->toArray();
                    foreach ($data as $key => $location) {
                        $options[$location['id']] = $location['name'];
                    }
                    return $options;
                });

                $form->switch('for_sale')->states(json_decode(config('attribute_response'), true));
                $form->currency('sale_price')->symbol('THB');
                $form->switch('for_rent')->states(json_decode(config('attribute_response'), true));
                $form->currency('rent_price')->symbol('THB');

                $form->divide();

                $form->multipleImage('image', 'Images')
                    ->uniqueName()
                    ->help('Allow only jpg, png')
                    ->removable();

                $form->switch('featured', 'Featured')->states(json_decode(config('attribute_response'), true));
                $form->switch('web_visible', 'Visible')->states(json_decode(config('attribute_visible'), true));
            })->tab('Featured & Facilities', function ($form) {
                // $form->checkbox('zzz')->options([1 => 'foo', 2 => 'bar', 'val' => 'Option name']);
                // $form->checkbox('featured')->options([1 => 'foo', 2 => 'bar', 'val' => 'Option name'])->stacked();

                // $form->listbox('featured')->options([1 => 'foo', 2 => 'bar', 'val' => 'Option name']);

                // $form->hasMany('featureds', function (Form\NestedForm $form) {
                //     $form->text('id');
                //     $form->text('name');
                // });
            });

            // Customize before save
            $form->saving(function (Form $form) {
                $form->slug = '';
                if ($form->name) {
                    $form->slug = str_slug($form->name);
                }
            });

            $form->saved(function (Form $form) {

            });


            // Customize form & tools
            $form->disableReset();

            $form->tools(function (Form\Tools $tools) {
                $tools->disableBackButton();
            });
        });
    }
}
