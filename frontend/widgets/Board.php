<?php
namespace frontend\widgets;

class Board extends Card
{
    protected $_type;
    public $item;

    public function init()
    {
        parent::init();
        $this->_type = 'board';

        if ($this->item !== null) {
        	$this->item['created_at'] = !empty($this->item['created_at']) ? date('M j Y, G:iA', strtotime($this->item['created_at'])) : '';
        	$this->item['updated_at'] = !empty($this->item['updated_at']) ? date('M j Y, G:iA', strtotime($this->item['updated_at'])) : '';
        }
    }
}