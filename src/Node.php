<?php

namespace Betterde\Tree;

use Illuminate\Database\Eloquent\Model;

use Arr;

/**
 * Date: 13/04/2018
 * @author George
 * @property *
 * @package Betterde\Tree
 */
class Node extends Model
{
    protected $guarded = [];

    /**
     * Node constructor.
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->fill($attributes);
    }

    /**
     * 添加子节点
     *
     * Date: 13/04/2018
     * @author George
     * @param Node $node
     * @param string $childrenKey
     * 11/06/2020 修改 array_has 函数为 Arr::has
     */
    public function addChildren(Node $node, string $childrenKey = 'children')
    {
        if (Arr::has($this->attributes, $childrenKey)) {
            $this->attributes[$childrenKey]->push($node);
        } else {
            $this->attributes[$childrenKey] = collect([]);
            $this->attributes[$childrenKey]->push($node);
        }
    }
}
