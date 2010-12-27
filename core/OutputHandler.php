<?php

class OutputPluginHandler implements SplSubject {
    protected $observers = array();
    
    public function attach(SplObservers $observer) {
        $id = spl_object_hash($observer);
        $this->observers[$id] = $observer;
    }
    
    public function detach(SplObservers $observer) {
        $id = spl_object_hash($observer);
        unset($this->observers[$id]);
    }
    
    public function notify() {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
}