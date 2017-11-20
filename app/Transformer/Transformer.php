<?php

namespace App\Transformer;

use Illuminate\Database\Eloquent\Model;

abstract class Transformer  
{
    public function transformCollection($items)
    {
        return array_map([$this, 'transform'], $items);
    }

    public abstract function transform($item);

}
