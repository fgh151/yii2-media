<?php

namespace fgh151\media\assets;

use yii\web\AssetBundle;

class MediaAsset extends AssetBundle
{

    public $sourcePath = __DIR__.'/files';

    public $css = [
        'css/media.css',
    ];

    public function init()
    {
        parent::init();
        if (YII_DEBUG) {
            $this->publishOptions['forceCopy'] = true;
        }
    }

}