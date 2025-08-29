<?php

class TreeNode {
    public $val = null;
    public $left = null;
    public $right = null;

    function __construct($value) {
        $this->val = $value;
    }
} 

class Codec {
    function __construct()
    {
        // Saya tidak pakai inisialisasi khusus, jadi langsung panggil fungsi dan class.
    }

    /**
     * Mengubah pohon binary menjadi string.
     * @param TreeNode $root
     * @return String
     */
    function serialize($root)
    {
        if ($root === null) return "";
        $result = [];
        $queue = [$root];
        while (!empty($queue)) {
            $node = array_shift($queue);
            if ($node === null) {
                $result[] = "null";
            } else {
                $result[] = $node->val;
                $queue[] = $node->left;
                $queue[] = $node->right;
            }
        }
        while (end($result) === "null") {
            array_pop($result);
        }
        return implode(",", $result);
    }

    /**
     * Mengubah string menjadi pohon binary.
     * @param String $data
     * @return TreeNode
     */
    function deserialize($data)
    {
        if ($data === "") return null;
        $vals = explode(",", $data);
        $root = new TreeNode($vals[0]);
        $queue = [$root];
        $i = 1;
        while (!empty($queue)) {
            $node = array_shift($queue);
            if ($i < count($vals)) {
                if ($vals[$i] !== "null") {
                    $node->left = new TreeNode($vals[$i]);
                    $queue[] = $node->left;
                }
                $i++;
            }
            if ($i < count($vals)) {
                if ($vals[$i] !== "null") {
                    $node->right = new TreeNode($vals[$i]);
                    $queue[] = $node->right;
                }
                $i++;
            }
        }
        return $root;
    }
}

// Contoh penggunaan
$root = new TreeNode(1);
$root->left = new TreeNode(2);
$root->right = new TreeNode(3);
$root->right->left = new TreeNode(4);
$root->right->right = new TreeNode(5);

$ser = new Codec();
$data = $ser->serialize($root);
echo $data . "\n"; //Contoh DFS : "1,2,null,3,4,5" || Format BFS : "1,2,3,null,4,5" saya pakai format BFS

$deser = new Codec();
$ans = $deser->deserialize($data);
echo $ans->val . "\n"; // 1
echo $ans->left->val . "\n"; // 2
echo $ans->right->val . "\n"; // 3
echo $ans->right->left->val . "\n"; // 4
echo $ans->right->right->val . "\n"; // 5
