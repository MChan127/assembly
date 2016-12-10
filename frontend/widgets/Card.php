<?php
namespace frontend\widgets;

use yii\base\Widget;

class Card extends Widget
{
    protected $_type;
    public $item;

    public function init()
    {
        parent::init();
    }

    public function run() {
        if ($this->_type !== null && $this->item !== null)
            return $this->render('card/' . $this->_type, ['item' => $this->item]);
    }
}