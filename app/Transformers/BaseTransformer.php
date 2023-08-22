<?php

namespace App\Transformers;
use League\Fractal\TransformerAbstract;

abstract class BaseTransformer extends TransformerAbstract
{
    use TransformTrait;

    abstract public function getItemKey() :string ;

    abstract public function getCollectionKey() :string;
}