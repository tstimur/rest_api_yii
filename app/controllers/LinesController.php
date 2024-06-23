<?php

namespace app\controllers;

use app\models\Lines;
use app\models\LinesTranslation;
use Exception;
use Yii;
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
    public function actions(): array
    {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    }

    /**
     * @return array|string[]
     */
    public function actionCreate(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Get data from POST request
        $data = Yii::$app->request->post();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $line = new Lines();
            if ($line->load($data, '') && $line->validate()) {
                if ($line->save()) {
                    if (!empty($data['linesTranslations'])) {
                        $translation = new LinesTranslation();

                        $translation->line_id = $line->id;
                        $translation->language_id = $data['linesTranslations']['language_id'];
                        $translation->value = $line->name;
                        if ($translation->load($data['linesTranslations'], '') && $translation->validate()) {
                            if (!$translation->save()) {
                                $transaction->rollBack();
                                Yii::$app->response->statusCode = 400;
                                return [
                                    'status' => 'error',
                                    'message' => 'Failed to save translation',
                                    'errors' => $translation->errors,
                                ];
                            }
                        } else {
                            $transaction->rollBack();
                            Yii::$app->response->statusCode = 400;
                            return [
                                'status' => 'error',
                                'message' => 'Translation validation failed',
                                'errors' => $translation->errors,
                            ];
                        }
                    }
                    $transaction->commit();
                    Yii::$app->response->statusCode = 201;
                    return [
                        'status' => 'success',
                        'message' => 'Lines created successfully',
                    ];
                } else {
                    Yii::$app->response->statusCode = 400;
                    return [
                        'status' => 'error',
                        'message' => 'Failed to create lines',
                        'errors' => $line->errors,
                    ];
                }
            } else {
                Yii::$app->response->statusCode = 400;
                return [
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $line->errors,
                ];
            }
        } catch (Exception $exception) {
            $transaction->rollBack();
            Yii::$app->response->statusCode = 500;
            return [
                'status' => 'error',
                'message' => 'An error occurred while saving the line',
                'errors' => $exception->getMessage(),
            ];
        }
    }
}