<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Form;
use Encore\Admin\Widgets\Table;
use Encore\Admin\Widgets\Collapse;

class HomeController extends Controller
{
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('Dashboard');
            $content->description('Description...');

            $content->row(Dashboard::title());

            $content->row(function (Row $row) {

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::environment());
                });

                $row->column(4, function (Column $column) {
                    $collapse = new Collapse();
                    $collapse->add('Bar', 'xxxxx');
                    $collapse->add('Orders', 'aaaa');

                    $form = new Form();

                    $form->action('example');

                    $form->email('email')->default('qwe@aweq.com');
                    $form->password('password');
                    $form->text('name');
                    $form->url('url');
                    $form->color('color');
                    $form->map('lat', 'lng');
                    $form->date('date');
                    $form->json('val');
                    $form->dateRange('created_at', 'updated_at');

                    // $column->append($form->render());
                    // $column->append($collapse->render());
                    $column->append(Dashboard::extensions());
                });

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::dependencies());
                });
            });
        });
    }
}
