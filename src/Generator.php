<?php

namespace Betterde\Tree;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Betterde\Tree\Exceptions\TreeException;

/**
 * 树生成器
 *
 * Date: 13/04/2018
 * @author George
 * @package Betterde\Tree
 */
class Generator
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
     * 暂存区
     *
     * @var Collection
     * Date: 22/03/2018
     * @author George
     */
    protected $collection;

    /**
     * 定义主键名称
     *
     * @var string
     * Date: 22/03/2018
     * @author George
     */
    private $primaryKey = 'id';

    /**
     * 定义父键名称
     *
     * @var string
     * Date: 22/03/2018
     * @author George
     */
    private $parentKey = 'parent_id';

    /**
     * 定义子键名称
     *
     * @var string
     * Date: 22/03/2018
     * @author George
     */
    private $childrenKey = 'children';

    /**
     * Generator constructor.
     */
    public function __construct()
    {
        $this->tree = new Tree();
    }


    /**
     * 生成树结构
     *
     * Date: 09/04/2018
     * @author George
     * @param $collection
     * @param string $primaryKey
     * @param string $parentKey
     * @param string $childrenKey
     * @param string $topvalue
     * @return Collection|mixed
     * @throws TreeException
     */
        public function make($collection, string $primaryKey = 'id', string $parentKey = 'parent_id', string $childrenKey = 'children', string $topvalue = "")
    {
        $collection = $this->transform($collection);

        $this->primaryKey = $primaryKey;
        $this->parentKey = $parentKey;
        $this->childrenKey = $childrenKey;

        $this->collection = $collection->groupBy($this->parentKey);

        if ($this->addTopNode($topvalue)) {
            return $collection;
        }

        if (count($this->collection) > 0) {
            foreach ($this->tree->get() as $key => $item) {
                $this->recursion($item);
            }
        }

        return $this->tree->get();
    }

    /**
     * 添加顶级节点
     *
     * Date: 13/04/2018
     * @author George
     * @param $topvalue
     * @return bool
     * @throws TreeException
     */
    public function addTopNode($topvalue)
    {
        $nodes = $this->collection->pull($topvalue);

        if (empty($nodes)) {
            return true;
        }
        foreach ($nodes as $item) {
            $node = new Node($this->isArray($item));
            $this->tree->addNode($node);
        }
        return false;
    }

    /**
     * 递归生成树结构
     *
     * Date: 22/03/2018
     * @author George
     * @param $item
     */
    private function recursion(Node $item)
    {
        if ($this->collection->has($item->{$this->primaryKey})) {
            $this->collection->pull($item->{$this->primaryKey})->map(function ($temp) use ($item) {
                $node = new Node($this->isArray($temp));
                $item->addChildren($node, $this->childrenKey);
                $this->recursion($node);
            });
        }
    }

    /**
     * 转换数据类型
     *
     * Date: 09/04/2018
     * @author George
     * @param $collection
     * @return Collection
     * @throws TreeException
     */
    private function transform($collection)
    {
        if ($collection instanceof Collection) {
            return $collection;
        }

        if (is_array($collection)) {
            return collect($collection);
        }

        throw new TreeException('数据类型错误');
    }

    /**
     * Date: 13/04/2018
     * @author George
     * @param $item
     * @return array
     * @throws TreeException
     */
    public function isArray($item)
    {
        if (is_array($item)) {
            return $item;
        }

        if ($item instanceof Model) {
            return $item->toArray();
        }
        throw new TreeException('数据类型错误');
    }
}