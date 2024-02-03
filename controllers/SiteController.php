<?php

namespace app\controllers;

use app\models\order;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    protected $arr_months = ['01' => 'Январь', '02' => 'Февраль', '03' => 'Март', '04' => 'Апрель', '05' => 'Май', '06' => 'Июнь',
        '07' => 'Июль', '08' => 'Август', '09' => 'Сентябрь', '10' => 'Октябрь', '11' => 'Ноябрь', '12' => 'Декабрь'];

    /**
     * Get data for left menu.
     *
     * @return array
     */
    private function getDataLeftMenu()
    {
        $result=[];

        $list = order::find()
            ->select(["date_trunc('month', created_at) AS date", "COUNT(created_at) AS count"])
            ->groupBy('date')
            ->orderBy('date DESC')
            ->asArray()
            ->all();

        if(!empty($list)){
            foreach ($list as $item){
                $year=date('Y', strtotime($item['date']));
                $month=date('m', strtotime($item['date']));

                $result[$year][$month]=$item['count'];
                $result[$year]['count'] = ($result[$year]['count'] ?? 0) +$item['count'];
            }
        }
        return $result;
    }

    /**
     * Get data for filter.
     *
     * @return array
     */
    private function getDataFilter()
    {
        $result = [
            'months' => [],
            'years' => []
        ];
        foreach (range(12, 24) as $item) {
            $year = '20' . $item;
            $result['years'][$year] = $year;
        }

        foreach (range(1, 12) as $item) {
            $month = ($item < 10 ? '0' : '') . $item;
            $result['months'][$month] = $month;
        }

        return $result;
    }

    /**
     * Displays index page.
     *
     * @return array
     */
    public function actionIndex()
    {
        $page = Yii::$app->request->get('page') ?? 1;
        $month = Yii::$app->request->get('month') ?? '';
        $year = Yii::$app->request->get('year') ?? '';

        $limit = 15;

        $db = order::find();

        if (!empty($year) && !empty($month)) {
            $db->where("date_part('year', created_at)='$year'")
                ->andWhere("date_part('month', created_at)='$month'");
        } else if (!empty($year)) $db->where("date_part('year', created_at)='$year'");
        else if (!empty($month)) $db->where("date_part('month', created_at)='$month'");

        $count = $db->count();

        $list_orders = $db
            ->orderBy('created_at DESC')
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->asArray()
            ->all();

        $filter = $this->getDataFilter();

        $pagination = new Pagination([
            'totalCount' => $count,
            'defaultPageSize' => $limit
        ]);

        $left_menu=$this->getDataLeftMenu();

        return $this->render('index', [
            'pagination' => $pagination,
            'list_orders' => $list_orders ?? [],
            'filter' => $filter,
            'count' => $count,
            'left_menu'=>$left_menu,
            'arr_months'=>$this->arr_months
        ]);
    }
}
