<?php

namespace app\controllers;

use app\models\Stations;
use Yii;
use yii\rest\ActiveController;
use yii\web\Response;

class StationsController extends ActiveController
{
    public $modelClass = Stations::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
        return $actions;
    }

    public function actionCreate()
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

    public function actionUpdate($id)
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

    public function actionDelete($id)
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