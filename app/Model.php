<?php

namespace App;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    public static function getFillableAttributes()
    {
        return (new static)->getFillable();
    }
}
