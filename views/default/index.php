<?php
/**
 * @var $this \yii\web\View
 * @var $folders \fgh151\media\models\MediaFolder[]
 * @var $files \fgh151\media\models\MediaFile[]
 * @var $currentFolder \fgh151\media\models\MediaFolder|null
 */

use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Url;


$path[] = ['label' => '/', 'url' => ['index']];
if ($currentFolder) {

    $parent = $currentFolder->parent;
    while ($parent != null) {
        $path[] = ['label' => $parent->title, 'url' => ['index', 'folder' => $parent->id]];
        $parent = $parent->parent;
    }
    $path[] = ['label' => $currentFolder->title, 'url' => ['index', 'folder' => $currentFolder->id]];
}
?>

<div class="media-manager">
    <?= \kartik\helpers\Html::a('Создать папку', ['create-folder', 'folder' => $currentFolder?->id], ['class' => 'btn btn-success']) ?>
    <?= \kartik\helpers\Html::a('Загрузить файл', ['create-file', 'folder' => $currentFolder?->id], ['class' => 'btn btn-success']) ?>

    <?= Breadcrumbs::widget([
            'itemTemplate' => "<li class=\"breadcrumb-item media-folder-icon\">{link}</li>\n",
            'homeLink' => false,
            'links' => $path,
    ]) ?>
    <div class="d-table media-table">
        <?php foreach ($folders as $folder): ?>
            <a href="<?= Url::to(['index', 'folder' => $folder->id]) ?>" class="d-table-row ">
                <div class="d-table-cell media-icon media-icon media-folder-icon"></div>
                <div class="d-table-cell media-item-title">
                    <?= $folder->title ?>
                </div>
                <div class="d-table-cell"></div>
            </a>
        <?php endforeach; ?>

        <?php foreach ($files as $file): ?>
            <a href="<?= $file->getSrc() ?>" target="_blank" class="d-table-row ">
                <div class="d-table-cell media-icon media-icon media-file-icon"></div>
                <div class="d-table-cell media-item-title">
                    <?= $file->title ?>
                </div>
                <div class="d-table-cell media-item-preview">
                    <?php if (in_array(strtolower($file->getFileExtension()), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'])): ?>
                        <?= $this->render('_preview_image.php', ['file' => $file]) ?>
                    <?php else: ?>

                    <?php endif;?>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>
