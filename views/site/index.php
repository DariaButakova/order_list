<?php

/** @var yii\web\View $this */


use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Заказы';
?>
<div class="site-index">
    <div class="row">
        <?php if (!empty($left_menu)): ?>
            <?= $this->render('@app/views/_partial/left_menu', [
                'list' => $left_menu,
                'arr_months' => $arr_months
            ]); ?>
        <?php endif; ?>
        <div class="col-9 col-md">
            <h3>Список заказов</h3>

            <div class="body-content">

                <?= Html::beginForm(['site/index'], 'GET', ['autocomplete' => 'off']); ?>
                <div class="card card-body mt-3">
                    <div class="row mt-1">
                        <div class="col-auto mr-3">
                            <label for="month">Месяц</label>
                            <?= Html::dropDownList('month', Yii::$app->request->get('month'), $filter['months'], ['class' => 'form-select', 'prompt' => '']); ?>
                        </div>
                        <div class="col-auto ms-3">
                            <label for="year">Год</label>
                            <?= Html::dropDownList('year', Yii::$app->request->get('year'), $filter['years'], ['class' => 'form-select', 'prompt' => '']); ?>
                        </div>
                        <div class="col d-flex justify-content-end">
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Применить</button>
                                <a href="<?= Url::to(['site/index']); ?>">
                                    <button type="button" class="btn btn-light ms-3">Сбросить</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?= Html::endForm(); ?>

                <?php if (!empty($list_orders)): ?>
                    <table class="table mt-3">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Дата</th>
                            <th scope="col">Сумма</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($list_orders as $item): ?>
                            <tr>
                                <th scope="row"><?= $item["id"] ?></th>
                                <td><?= $item["created_at"] ?></td>
                                <td><?= $item["sum"] ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end">
                        Всего найдено: <?= $count ?>
                    </div>

                <?php else: ?>
                    <div class="alert alert-warning mt-2">
                        Ничего не найдено
                    </div>
                <?php endif; ?>

                <?= LinkPager::widget(['pagination' => $pagination]); ?>
            </div>
        </div>
    </div>
</div>
