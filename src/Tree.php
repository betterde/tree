<?php

namespace Betterde\Tree;

use Illuminate\Database\Eloquent\Model;

class Tree extends Model
{
    /**
     * 生成的树
     *
     * @var
     * Date: 22/03/2018
     * @author George
     */
    protected $tree;

    /**
     * Tree constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->tree = collect([]);
    }

    /**
     * 添加节点
     *
     * Date: 13/04/2018
     * @author George
     * @param Node $node
     */
    public function addNode(Node $node)
    {
        $this->tree->push($node);
    }

    public function get()
    {
        return $this->tree;
    }
}
