<?php

namespace Betterde\Tree;

use Illuminate\Database\Eloquent\Model;

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
    public function __construct(array $attributes = [])
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
     */
    public function addChildren(Node $node, string $childrenKey = 'children')
    {
        if (array_has($this->attributes, $childrenKey)) {
            $this->attributes[$childrenKey]->push($node);
        } else {
            $this->attributes[$childrenKey] = collect([]);
            $this->attributes[$childrenKey]->push($node);
        }
    }
}