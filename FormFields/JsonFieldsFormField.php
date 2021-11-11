<?php

namespace Modules\Admin\FormFields;

use TCG\Voyager\FormFields\AbstractHandler;

class JsonFieldsFormField extends AbstractHandler
{
    protected $codename = 'json_fields';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('voyager::formfields.json_fields', [
            'row' => $row,
            'options' => $options,
            'dataType' => $dataType,
            'dataTypeContent' => $dataTypeContent
        ]);
    }
}