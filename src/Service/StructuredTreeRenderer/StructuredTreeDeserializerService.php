<?php

namespace App\Service\StructuredTreeRenderer;

/**
 * Structured Tree Deserializer Service
 */
class StructuredTreeDeserializerService
{
    const DELIMITER = '|';
    /*
     * @var string
     */
    private $fullFileName;

    private $line;

    /**
     * @param $fullFileName
     * @return array
     */
    public function getFileContent($fullFileName): string
    {
        $this->$fullFileName = $fullFileName;

        $ar = [];
        foreach (file($this->$fullFileName) as $k => $v) {
            $ar[] = explode(self::DELIMITER, $v);
        }

        $arNodes = [];
        foreach ($ar as $k => $v) {
            $arNodes[] = ['id' => (int)$v[0], 'parent_id' => (int)$v[1], 'node_name' => trim($v[2])];
        }

        $restoredTree = $this->restoreTree($arNodes);

        return $this->printTree($restoredTree);

    }

    /*
     * @param $elements
     * @return array
     */
    public function restoreTree(array &$nodes, $parentId = 0) {

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

    public function printTree($array, $level = 0) {

            foreach($array as $key => $value){
                if(is_array($value)) {
                    if (isset($value['node_name'])) {
                        $this->line .= $level / 2 . " " . $value['node_name'] . "<br>";
                    }

                    $this->printTree($value, $level + 1);
                }
            }

        return $this->line;

    }
}