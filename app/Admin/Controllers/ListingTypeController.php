<?php

namespace App\Admin\Controllers;

use App\Models\ListingType;
use App\Models\Painter;
use App\Models\Painting;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

use App\Admin\Helpers\ListingTypeFormRender;

class ListingTypeController extends Controller
{
    use ModelForm;

    protected $modelName;
    protected $header;
    protected $description;

    public function __construct()
    {
        $this->modelName = 'Listing Type';
        $this->header = 'Listing Types';
        $this->description = '';
    }

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header($this->header);
            $content->description($this->description);

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

            $content->header('Edit ' . $this->modelName);
            $content->description($this->description);

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

            $content->header('Create ' . $this->modelName);
            $content->description($this->description);

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
        return Admin::grid(ListingType::class, function (Grid $grid) {
            // $grid->model()->where('id', '>', 100);
            // $grid->model()->orderBy('id', 'desc');
            // $grid->model()->take(100);

            $grid->id('ID')->sortable();
            $grid->name('Name')->sortable();
            $grid->image('Thumbnail')->image('', 100, 100);
            $grid->featured('Featured')->sortable();
            $grid->visible('Visible')->sortable();
            // $grid->title()->limit(30)->ucfirst()->substr(1, 10);
            // $grid->title()->editable('select', [1 => 'option1', 2 => 'option2', 3 => 'option3']);

            // $grid->director()->display(function($userId) {
            //     return User::find($userId)->name;
            // });

            $grid->created_at('Created At')->sortable();

            $grid->paginate(30);

            ListingTypeController::filterGrid($grid);
            ListingTypeController::actionGrid($grid);
            ListingTypeController::disableTools(['grid' => $grid]);
        });
    }

    public static function actionGrid($grid)
    {
        $grid->actions(function ($actions) {
            // append an action.
            // $actions->append('<a href=""><i class="fa fa-eye"></i></a>');
            // prepend an action.
            // $actions->prepend('<a href=""><i class="fa fa-paper-plane"></i></a>');
            // $actions->disableDelete();
            // $actions->disableEdit();
            // echo '<pre>'; print_r($actions->getKey()); echo '</pre>';
            // echo '<pre>'; print_r($actions->row); echo '</pre>';
        });
    }

    public static function filterGrid($grid)
    {
        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->equal('featured', 'Featured')->checkbox([
              "YES" => "YES",
            ]);

            // $filter->equal('name', 'Name');
            // $filter->equal('slug', 'Slug');

            $filter->where(function ($query) {
                $query->where('name', 'like', "%{$this->input}%")
                    ->orWhere('slug', 'like', "%{$this->input}%");
            }, 'Text');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(ListingType::class, function (Form $form) {
            $form->display('id', 'ID');
            $form->text('name', 'Name')
                ->rules('required', []);
            $form->text('slug', 'Slug')->rules(function ($form) {
              if (!$id = $form->model()->id) {
                return 'nullable|unique:locations,slug';
              }
            });

            $form->divide();

            $form->editor('description', 'Description')
                ->rules('nullable', []);

            $form->divide();

            $form->image('image', 'Image')
                ->removable();

            $form->switch('featured', 'Featured')
                ->states(json_decode(config('attribute_response'), true));

            $form->switch('visible', 'Visible')
                ->states(json_decode(config('attribute_visible'), true));

            $form->saving(function ($form) {
                $form->slug = str_slug($form->name);
            });

            $form->saved(function ($form) {
                //
            });

            ListingTypeController::disableTools(['form' => $form]);
        });
    }

    public static function disableTools($options = ['grid' => null, 'form' => null])
    {
        extract($options);

        if (isset($form)) {
          $form->disableReset();

          $form->tools(function (Form\Tools $tools) {
              $tools->disableBackButton();
              // $tools->disableListButton();
              // $tools->add('<a class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;delete</a>');
          });
        }

        if (isset($grid)) {
          // $grid->disableCreateButton();
          // $grid->disablePagination();
          // $grid->disableFilter();
          $grid->disableExport();
          // $grid->disableRowSelector();
          // $grid->disableActions();
          // $grid->perPages([10, 20, 30, 40, 50]);
        }
    }
}
