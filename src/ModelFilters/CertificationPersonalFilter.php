<?php

namespace Tomeet\Certification\ModelFilters;

use EloquentFilter\ModelFilter;

class CertificationPersonalFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function id($id)
    {
        $id_array = explode(',', $id);
        if (!empty($id_array)) {
            return $this->whereIn('id', $id_array);
        }
    }
}
