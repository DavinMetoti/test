<?php
class Node {
    public $key;
    public $value;
    public $prev;
    public $next;
    public function __construct($key, $value) {
        $this->key = $key;
        $this->value = $value;
        $this->prev = null;
        $this->next = null;
    }
}

class LRUCache {
    private $capacity;
    private $map;
    private $head;
    private $tail;

    public function __construct($capacity)
    {
        $this->capacity = $capacity;
        $this->map = [];
        $this->head = new Node(-1, -1); 
        $this->tail = new Node(-1, -1);
        $this->head->next = $this->tail;
        $this->tail->prev = $this->head;
    }

    public function get($key)
    {
        if (!isset($this->map[$key])) {
            return -1;
        }
        $node = $this->map[$key];
        $this->moveToHead($node);
        return $node->value;
    }

    public function put($key, $value)
    {
        if (isset($this->map[$key])) {
            $node = $this->map[$key];
            $node->value = $value;
            $this->moveToHead($node);
        } else {
            $node = new Node($key, $value);
            $this->map[$key] = $node;
            $this->addNode($node);
            if (count($this->map) > $this->capacity) {
                $removed = $this->popTail();
                if ($removed !== null) {
                    unset($this->map[$removed->key]);
                }
            }
        }
        return null;
    }

    private function addNode($node) {
        $node->prev = $this->head;
        $node->next = $this->head->next;
        if ($this->head->next !== null) {
            $this->head->next->prev = $node;
        }
        $this->head->next = $node;
    }

    private function removeNode($node) {
        $prev = $node->prev;
        $next = $node->next;
        $prev->next = $next;
        $next->prev = $prev;
    }

    private function moveToHead($node) {
        $this->removeNode($node);
        $this->addNode($node);
    }

    private function popTail() {
        $node = $this->tail->prev;
        $this->removeNode($node);
        return $node;
    }
}

// Contoh penggunaan
$cache = new LRUCache(2);

$cache->put(1, 1);          //null
$cache->put(2, 2);          //null
var_dump($cache->get(1));   //int(1)
$cache->put(3, 3);          //null (evict key 2)
var_dump($cache->get(2));   //int(-1)
$cache->put(4, 4);          //null (evict key 1)
var_dump($cache->get(1));   //int(-1)
var_dump($cache->get(3));   //int(3)
var_dump($cache->get(4));   //int(4)


