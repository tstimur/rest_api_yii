<?php

namespace app\controllers;



use app\models\Lines;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\Response;

class LinesController extends ActiveController
{
    /**
     * @var string
     */
    public $modelClass = Lines::class;

    /**
     * @return array
     */
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    }

    public function actionCreate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new Lines();
        if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
            if ($model->save()) {
                return ['status' => 'success', 'data' => $model];
            } else {
                return ['status' => 'error', 'message' => 'Failed to save line'];
            }
        } else {
            return ['status' => 'error', 'message' => $model->errors];
        }
    }

}