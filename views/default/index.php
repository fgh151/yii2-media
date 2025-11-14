<?php
/**
 * @var $this \yii\web\View
 * @var $folders \app\modules\adm\modules\media\models\MediaFolder[]
 * @var $files \app\modules\adm\modules\media\models\MediaFile[]
 * @var $currentFolder \app\modules\adm\modules\media\models\MediaFolder|null
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\Breadcrumbs;


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
    <?= Html::a('Создать папку', ['create-folder', 'folder' => $currentFolder?->id], ['class' => 'btn btn-success']) ?>
    <?= Html::a('Загрузить файл', ['create-file', 'folder' => $currentFolder?->id], ['class' => 'btn btn-success']) ?>

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
                <div class="d-table-cell"></div>
                <div class="d-table-cell"></div>
            </a>
        <?php endforeach; ?>

        <?php foreach ($files as $file): ?>
            <div class="d-table-row ">
                <div class="d-table-cell media-icon media-icon media-file-icon"></div>
                <div class="d-table-cell media-item-title">
                    <?= $file->title ?>
                </div>
                <div class="d-table-cell">
                    <?= strtolower($file->getFileExtension())?>
                </div>
                <div class="d-table-cell media-item-preview">
                    <?php if (in_array(strtolower($file->getFileExtension()), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'])): ?>
                        <?= $this->render('_preview_image.php', ['file' => $file]) ?>
                    <?php else: ?>

                    <?php endif;?>
                </div>

                <div class="d-table-cell">
                    <a href="<?= $file->getSrc() ?>" target="_blank" class="media-action-copy js-copy" title="скопировать путь файла в буфер обмена"></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<?php
$this->registerJs(<<<JS
    $('.js-copy').on('click', async function (e) {
        e.preventDefault();
        const href= $(this).attr('href');
        await navigator.clipboard.writeText(href);
        return false;
    })
JS
);