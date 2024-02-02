<?php use yii\helpers\Url;
?>
<div class="col-3 col-md-auto ps-0">
    <ul class="list-group list-group-flush">
        <?php foreach ($list as $key_year => $item_year): ?>
            <li class="list-group-item">
                <a href="<?=Url::to(['/', 'year' => $key_year, 'month' => ''])?>"><?= $key_year ?></a>
                <span class="badge bg-primary rounded-pill"><?= $item_year['count'] ?></span>
                <?php if (!empty($item_year)): ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($item_year as $key_month => $item_month): if ($key_month != 'count'): ?>
                            <li class="list-group-item">
                                <a href="<?=Url::to(['/', 'year' => $key_year, 'month' => $key_month])?>"> <?= $arr_months[$key_month] ?></a>
                                <span class="badge bg-primary rounded-pill"><?= $item_month ?></span>
                            </li>
                        <?php endif; endforeach; ?>
                    </ul>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>