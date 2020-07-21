<?php
declare(strict_types=1);

namespace App\Service\StructuredTreeDeserializer;

/**
 * Structured Tree Deserializer Service
 */
class StructuredTreeDeserializerService
{
    private const DELIMITER = '|';
    private const PADDING = '-';

    /*
     * @var array
     */
    private $treePreparedForPrint;

    /**
     * @param string $fullDataFileName
     * @return array
     */
    public function deserializeTreeFromFile(string $fullDataFileName) : array
    {
        $fileLines = [];
        foreach (file($fullDataFileName) as $k => $v) {
            $fileLines[] = explode(self::DELIMITER, $v);
        }

        $nodes = [];
        foreach ($fileLines as $value) {
            $nodes[] = ['id' => (int)$value[0], 'parent_id' => (int)$value[1], 'node_name' => trim($value[2])];
        }

        return $this->prepareTreeForPrint($this->restoreTree($nodes));

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
        foreach ($array as $key => $value){
            if (is_array($value)) {
                if (isset($value['node_name'])) {
                    $this->treePreparedForPrint[] = str_repeat(self::PADDING, $level / 2 ) . $value['node_name'];
                }

                $this->prepareTreeForPrint($value, $level + 1);
            }
        }

        return $this->treePreparedForPrint;
    }
}