<?php
class IteratorInterno{
    protected $list;

    public function __construct($list = null){
        $this->list = $list;
    }

    public function loop(){
        print_r($this->list);
        for($this->list->first(); !$this->list->isDone();$this->list->next()){
            return $this->list->currentItem()['nome'];
        }
    }
}
?>
