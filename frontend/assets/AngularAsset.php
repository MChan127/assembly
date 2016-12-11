<?php

namespace frontend\assets;

/**
 * Asset bundle containing all the AngularJS scripts.
 */
class AngularAsset extends \yii\web\AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/angularjs/app.js',
    ];
    public $depends = [
        'yii\angular\AngularAsset',
    ];
}

namespace yii\angular;

/**
 * Create asset bundle to import AngularJS
 */
class AngularAsset extends \yii\web\AssetBundle {
    public $sourcePath = '@bower/angular';
    public $js = [
        'angular.js',
    ];
} 