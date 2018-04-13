<?php

namespace App\Admin\Extensions;

use Encore\Admin\Form\Field;

class PHPEditor extends Field
{
    protected $view = 'admin.php-editor';

    protected static $css = [
        '/packages/codemirror/lib/codemirror.css',
    ];

    protected static $js = [
        '/packages/codemirror/lib/codemirror.js',
        '/packages/codemirror/addon/edit/matchbrackets.js',
        '/packages/codemirror/mode/htmlmixed/htmlmixed.js',
        '/packages/codemirror/mode/xml/xml.js',
        '/packages/codemirror/mode/javascript/javascript.js',
        '/packages/codemirror/mode/css/css.js',
        '/packages/codemirror/mode/clike/clike.js',
        '/packages/codemirror/mode/php/php.js',
    ];

    public function render()
    {
        $this->script = <<<EOT

CodeMirror.fromTextArea(document.getElementById("{$this->id}"), {
    lineNumbers: true,
    mode: "text/x-php",
    extraKeys: {
        "Tab": function(cm){
            cm.replaceSelection("    " , "end");
        }
     }
});

EOT;
        return parent::render();

    }
}
