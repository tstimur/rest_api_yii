<?php

namespace app\controllers;

use app\models\Stations;
use Yii;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;
use yii\web\Response;

class StationsController extends ActiveController
{
    public $modelClass = Stations::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'add-station' => ['POST'],
                'delete-station' => ['POST'],
                'update-station' => ['POST'],
            ],
        ];
        return $behaviors;
    }

    public function actionAddStation()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new Stations();
        if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
            if ($model->save()) {
                return ['status' => 'success', 'data' => $model];
            } else {
                return ['status' => 'error', 'message' => 'Failed to save station'];
            }
        } else {
            return ['status' => 'error', 'message' => $model->errors];
        }
    }

    public function actionUpdateStation($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = Stations::findOne($id);
        if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
            if ($model->save()) {
                return ['status' => 'success', 'data' => $model];
            } else {
                return ['status' => 'error', 'message' => 'Failed to update station'];
            }
        } else {
            return ['status' => 'error', 'message' => $model->errors];
        }
    }

    public function actionDeleteStation($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = Stations::findOne($id);
        if ($model->delete()) {
            return ['status' => 'success', 'data' => $model];
        } else {
            return ['status' => 'error', 'message' => 'Failed to delete station'];
        }
    }
}