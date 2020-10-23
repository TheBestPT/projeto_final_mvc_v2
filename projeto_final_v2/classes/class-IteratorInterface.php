<?php
interface IteratorInterface{
    public function next();
    public function isDone();
    public function first();
    public function currentItem();
}
