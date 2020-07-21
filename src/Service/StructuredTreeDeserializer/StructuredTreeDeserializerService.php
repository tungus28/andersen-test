<?php

namespace App\Service\StructuredTreeDeserializer;

/**
 * Structured Tree Deserializer Service
 */
class StructuredTreeDeserializerService
{
    const DELIMITER = '|';
    const PADDING = '-';

    /*
     * @var array
     */
    private $treePreparedForPrint;

    /**
     * @param $fullFileName
     * @return array
     */
    public function deserializeTreeFromFile($fullFileName) : array
    {
        $ar = [];
        foreach (file($fullFileName) as $k => $v) {
            $ar[] = explode(self::DELIMITER, $v);
        }

        $arNodes = [];
        foreach ($ar as $k => $v) {
            $arNodes[] = ['id' => (int)$v[0], 'parent_id' => (int)$v[1], 'node_name' => trim($v[2])];
        }

        return $this->prepareTreeForPrint($this->restoreTree($arNodes));

    }

    /**
     * @param $nodes
     * @param $parentId
     * @return array
     */
    private function restoreTree(array &$nodes, $parentId = 0) : array
    {
        $tree = [];
        foreach ($nodes as &$node) {
            if ($node['parent_id'] == $parentId) {
                $children = $this->restoreTree($nodes, $node['id']);
                if ($children) {
                    $node['children'] = $children;
                }
                $tree[$node['id']] = $node;
                unset($node);
            }
        }

        return $tree;

    }

    /**
     * @param $array
     * @param int $level
     * @return array
     */
    private function prepareTreeForPrint($array, $level = 0) : array
    {
        foreach($array as $key => $value){
            if(is_array($value)) {
                if (isset($value['node_name'])) {
                    $this->treePreparedForPrint[] = str_repeat(self::PADDING,$level / 2 ) . $value['node_name'];
                }

                $this->prepareTreeForPrint($value, $level + 1);
            }
        }

        return $this->treePreparedForPrint;
    }
}