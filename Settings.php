<?php

class Settings implements Iterator, ArrayAccess {
    protected $settings = array();
    protected $position = 0;
    
    public function __construct(array $data = NULL) {
        if (!is_null($data)) {
            $this->settings = $data;
        }
        
        $this->position = 0;
    }
    
    // Iterator

    public function current() {
        return $this->settings[$this->position];
    }

    public function key() {
        return $this->position;
    }

    public function next() {
        ++$this->position;
    }

    public function rewind() {
        $this->position = 0;
    }

    public function valid() {
        return isset($this->settings[$this->position]);
    }
    
    // ArrayAccess

    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->settings[] = $value;
        } else {
            $this->settings[$offset] = $value;
        }
    }

    public function offsetExists($offset) {
        return isset($this->settings[$offset]);
    }

    public function offsetUnset($offset) {
        unset($this->settings[$offset]);
    }

    public function offsetGet($offset) {
        return isset($this->settings[$offset]) ? $this->settings[$offset] : NULL;
    }
}