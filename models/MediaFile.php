<?php

namespace fgh151\media\models;

use fgh151\media\components\UploadBehavior;
use Yii;

/**
 * This is the model class for table "media_file".
 *
 * @property int $id
 * @property int $media_folder_id
 * @property string $title
 */
class MediaFile extends \yii\db\ActiveRecord
{
    public $upload;

    /**
     * Директория, куда загружаем картинки
     * @var string
     */
    private string $baseUploadPath = '/uploads/media';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'media_file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['media_folder_id', 'title'], 'required'],
            [['media_folder_id'], 'default', 'value' => null],
            [['media_folder_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    public function behaviors()
    {
        return [

            [
                'class' => UploadBehavior::class,
                'attribute' => 'upload',
                'storageAttribute' => 'file',
                'folder' => Yii::getAlias('@webroot').$this->baseUploadPath,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'media_folder_id' => 'Media Folder ID',
            'title' => 'Название',
        ];
    }

    public function getFileExtension(): string
    {
        $src = $this->getSrc();
        $fileExtension = pathinfo($src, PATHINFO_EXTENSION);
        return strtolower($fileExtension);
    }


    public function getSrc(string $attribute = 'file'): string
    {
        if ($this->getAttribute($attribute) !== null) {
            return UploadBehavior::getPhotoPath($this->baseUploadPath, $this->getAttribute($attribute), $this->id);
        }

        return '/web-app-manifest-512x512.png';
    }
}
