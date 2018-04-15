<?php

namespace App\Admin\Controllers;

use App\Models\Facilities;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Layout\Column;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class FacilitiesController extends Controller
{
    use ModelForm;

    protected $model;

    public function __construct()
    {
      $this->model = new Facilities;
    }

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header($this->model->modelName);
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
        return Admin::grid(Facilities::class, function (Grid $grid) {

            $grid->disableExport();
            $grid->id('ID')->sortable();
            $grid->column('name')->display(function () {
                return '<a href="'. route('facilities.edit', ['id' => $this->id]) .'">'. $this->name .'</a>';
            })->sortable();

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
        return Admin::form(Facilities::class, function (Form $form) {

            // Form building
            $form->setWidth(10, 2);
            $form->hidden('id');

            $form->text('name', 'Name')->rules('required|min:2');

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
