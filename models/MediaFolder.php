<?php

namespace fgh151\media\models;

/**
 * This is the model class for table "media_folder".
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string $title
 *
 * @property MediaFolder|null $parent
 */
class MediaFolder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'media_folder';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id'], 'default', 'value' => null],
            [['parent_id'], 'default', 'value' => null],
            [['parent_id'], 'integer'],
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'title' => 'Title',
        ];
    }

    public function getParent(): \yii\db\ActiveQuery
    {
        return $this->hasOne(MediaFolder::class, ['id' => 'parent_id']);
    }

}
