<?php

namespace fgh151\media\components;

use fgh151\upload\FileUploadBehavior;
use Yii;
use yii\base\Exception;
use yii\base\InvalidArgumentException;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class UploadBehavior extends FileUploadBehavior
{
    private bool $execute = true;
    public bool $selfStorage = true;
    public bool $multiple = false;
    public ?string $externalStorageValueAttribute = null;

    /**
     * Загрузка файлов
     * @throws InvalidArgumentException
     * @throws Exception
     * @noinspection PhpMissingReturnTypeInspection
     */
    public function upload()
    {
        if ($this->execute) {
            if ($this->multiple) {
                $files = UploadedFile::getInstances($this->owner, $this->attribute);
                foreach ($files as $file) {
                    $this->saveValue($this->uploadFile($file));
                }
            } else {
                $file = UploadedFile::getInstance($this->owner, $this->attribute);
                if ($file !== null) {
                    $this->saveValue($this->uploadFile($file));
                }
            }
        }
    }

    /**
     * @throws \yii\db\Exception
     */
    private function saveValue(string $fileName): void
    {
        if ($this->selfStorage) {
            $this->owner->{$this->storageAttribute} = $fileName;
            $this->execute = false;
            $this->owner->save();
        } else {
            /** @var ActiveRecord $class */
            $class = $this->storageClass;
            $model = new $class();
            $model->{$this->externalStorageValueAttribute} = $fileName;
            /** @noinspection PhpPossiblePolymorphicInvocationInspection */
            $model->{$this->storageAttribute} = $this->owner->id;
            $model->save();
        }

    }

    /**
     * @throws Exception
     */
    private function uploadFile(UploadedFile $file): string
    {
        $path = $this->folder . DIRECTORY_SEPARATOR . substr(md5($file->name), 0, 2) . DIRECTORY_SEPARATOR . $this->owner->getPrimaryKey();

        $path = Yii::getAlias($path);
        FileHelper::createDirectory($path);

        $fileName = $file->baseName;
        if ($file->extension) {
            $fileName .= '.' . $file->extension;
        }

        $file->saveAs($path . DIRECTORY_SEPARATOR . $fileName);

        return $fileName;
    }

    public static function getPhotoPath(string $folder, string $fileName, int $entityId): string
    {
        return Yii::getAlias($folder) . DIRECTORY_SEPARATOR .
            substr(md5($fileName), 0, 2) .
            DIRECTORY_SEPARATOR . $entityId . DIRECTORY_SEPARATOR . $fileName;
    }
}
