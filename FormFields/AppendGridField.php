<?php

namespace Modules\Admin\FormFields;

use TCG\Voyager\FormFields\AbstractHandler;

class AppendGridField extends AbstractHandler
{
    protected $codename = 'append_grid';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('voyager::formfields.append_grid', [
            'row' => $row,
            'options' => $options,
            'dataType' => $dataType,
            'dataTypeContent' => $dataTypeContent
        ]);
    }
}