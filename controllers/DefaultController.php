<?php

namespace fgh151\media\controllers;

use fgh151\media\assets\MediaAsset;
use fgh151\media\models\MediaFile;
use fgh151\media\models\MediaFolder;
use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function init()
    {
        parent::init();
        MediaAsset::register($this->view);
    }
    public function actionIndex($folder = null)
    {
        $folders = MediaFolder::find()->where(['parent_id' => $folder])->all();
        $files = MediaFile::find()->where(['media_folder_id' => $folder])->all();

        $currentFolder = $folder != null ? MediaFolder::findOne($folder) : null;

        return $this->render('index', [
            'folders' => $folders,
            'files' => $files,
            'currentFolder' => $currentFolder,
        ]);
    }

    public function actionCreateFolder($folder = null)
    {
        $model = new MediaFolder(['parent_id' => $folder]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'folder' => $folder]);
        }
        return $this->render('create-folder', [
            'model' => $model,
        ]);

    }

    public function actionCreateFile($folder = null)
    {
        $model = new MediaFile(['media_folder_id' => $folder]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'folder' => $folder]);
        }
        return $this->render('create-file', [
            'model' => $model,
        ]);
    }
}