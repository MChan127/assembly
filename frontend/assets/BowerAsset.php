<?php

namespace frontend\assets;

/**
 * Asset bundle containing Bower scripts.
 */
class BowerAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@bower';
    public $js = [
        'jQuery.dotdotdot/src/jquery.dotdotdot.min.js',
    ];
}