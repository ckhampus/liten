<?php

abstract class Plugin implements SplObserver {
    abstract function update(SplSubject $subject);
}