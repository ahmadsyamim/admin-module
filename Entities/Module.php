<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;


class Module extends Model
{
    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();

        // static::creating(function ($query) {
        //     $query->type = self::$singleTableType;
        // });

        static::saving(function ($model) {
            $model->slug = strtolower($model->title);
        });

        static::saved(function ($model) {
        });

    }

}
