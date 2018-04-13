<?php

use App\Admin\Extensions\Column\ExpandRow;
use App\Admin\Extensions\Column\OpenMap;
use App\Admin\Extensions\Column\FloatBar;
use App\Admin\Extensions\Column\Qrcode;
use App\Admin\Extensions\Column\UrlWrapper;
use App\Admin\Extensions\Form\WangEditor;
use App\Admin\Extensions\Nav\Links;
use App\Admin\Extensions\Nav\SearchBar;
use Encore\Admin\Grid;
use Encore\Admin\Form;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Grid\Column;
// use App\Admin\Extensions\Form\PHPEditor;
// use App\Admin\Extensions\Form\CKEditor;

Form::forget(['map', 'editor']);

Form::extend('editor', WangEditor::class);
// Form::extend('php', PHPEditor::class);
// Form::extend('ckeditor', CKEditor::class);

Admin::css('/vendor/prism/prism.css');
Admin::js('/vendor/prism/prism.js');
Admin::js('/vendor/clipboard/dist/clipboard.min.js');

Column::extend('expand', ExpandRow::class);
Column::extend('openMap', OpenMap::class);
Column::extend('floatBar', FloatBar::class);
Column::extend('qrcode', Qrcode::class);
Column::extend('urlWrapper', UrlWrapper::class);
Column::extend('action', Grid\Displayers\Actions::class);
Column::extend('color', function ($value, $color) {
    return "<span style='color: $color'>$value</span>";
});

Column::extend('prependIcon', function ($value, $icon) {

    return "<span style='color: #999;'><i class='fa fa-$icon'></i>  $value</span>";

});

Admin::navbar(function (\Encore\Admin\Widgets\Navbar $navbar) {

    // $navbar->left(SearchBar::render());
    $navbar->left(view('admin.search-bar'));

    $navbar->right(new Links());

});
