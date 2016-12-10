<?php
namespace frontend\widgets;

class Task extends Card
{
    protected $_type;
    public $item;

    public function init()
    {
        parent::init();
        $this->_type = 'task';

        if ($this->item !== null) {
        	$this->item['created_at'] = date('M j Y, G:iA', strtotime($this->item['created_at']));
        	$this->item['updated_at'] = date('M j Y, G:iA', strtotime($this->item['updated_at']));
        }
    }
}