<?php

namespace frontend\assets;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends \yii\web\AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/custom.css',
    ];
    public $js = [
        'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
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
        'angular.min.js',
    ];
} 