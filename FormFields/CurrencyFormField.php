<?php

namespace Modules\Admin\FormFields;

use TCG\Voyager\FormFields\AbstractHandler;

class CurrencyFormField extends AbstractHandler
{
    protected $codename = 'currency';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('formfields.currency', [
            'row' => $row,
            'options' => $options,
            'dataType' => $dataType,
            'dataTypeContent' => $dataTypeContent
        ]);
    }
}