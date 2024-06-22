<?php

namespace app\controllers;

use app\models\Stations;
use app\models\StationsAudio;
use app\models\StationsExits;
use app\models\StationsFeatures;
use app\models\StationsTransfers;
use app\models\StationsTranslation;
use Yii;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;
use yii\web\Response;

class StationsController extends ActiveController
{
    /**
     * @var string
     */
    public $modelClass = Stations::class;

    /**
     * @return array|array[]
     */
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

    /**
     * @return array|string[]
     */
    public function actionAddStation()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Get data from POST request
        $data = Yii::$app->request->post();
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $station = new Stations();
            if ($station->load($data, '') && $station->validate() && $station->save()) {
                if (!empty($data['stationsTranslations'])) {
                        $translation = new StationsTranslation();
                        $translation->station_id = $station->id;
                        $translation->language_id = $data['stationsTranslations']['language_id'];
                        $translation->value = $station->name;
                        if ($translation->load($data['stationsTranslations'], '') && $translation->validate()) {
                            if (!$translation->save()) {
                                throw new \Exception('Failed to save station translation');
                            }
                        } else {
                            throw new \Exception('Station translation validation failed');
                        }
                }

                if (!empty($data['stationsTransfers'])) {

                        $transfer = new StationsTransfers();
                        $transfer->station_id = $station->id;
                        $transfer->station_to_id = $station->id;
                        $transfer->type = $data['stationsTransfers']['type'];
                        $transfer->name = $data['stationsTransfers']['name'];
                        $transfer->code = $data['stationsTransfers']['code'];
                        $transfer->icon = $data['stationsTransfers']['icon'] ?? '';
                        if ($transfer->load($data['stationsTransfers'], '') && $transfer->validate()) {
                            if (!$transfer->save()) {
                                throw new \Exception('Failed to save station transfer');
                            }
                        } else {
                            throw new \Exception('Station transfer validation failed');
                        }
                }

                if (!empty($data['stationsAudio'])) {

                        $audio = new StationsAudio();
                        $audio->station_id = $station->id;
                        $audio->direction = $data['stationsAudio']['direction'];
                        $audio->action = $data['stationsAudio']['action'];
                        $audio->sound = $data['stationsAudio']['sound'];
                        if ($audio->load($data['stationsAudio'], '') && $audio->validate()) {
                            if (!$audio->save()) {
                                throw new \Exception('Failed to save station audio');
                            }
                        } else {
                            throw new \Exception('Station audio validation failed');
                        }

                }

                if (!empty($data['stationsFeatures'])) {

                        $feature = new StationsFeatures();
                        $feature->station_id = $station->id;
                        $feature->feature_id = $data['stationsFeatures']['feature_id'];
                        if ($feature->load($data['stationsFeatures'], '') && $feature->validate()) {
                            if (!$feature->save()) {
                                throw new \Exception('Failed to save station feature');
                            }
                        } else {
                            throw new \Exception('Station feature validation failed');
                        }

                }

                if (!empty($data['stationsExits'])) {

                        $exit = new stationsExits();
                        $exit->station_id = $station->id;
                        $exit->direction = $data['stationsExits']['direction'];
                        $exit->doors = $data['stationsExits']['doors'];
                        if ($exit->load($data['stationsExits'], '') && $exit->validate()) {
                            if (!$exit->save()) {
                                throw new \Exception('Failed to save station exit');
                            }
                        } else {
                            throw new \Exception('Station exit validation failed');
                        }
                }
                $transaction->commit();
                return [
                    'status' => 'success',
                    'message' => 'Station and related data created successfully',
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Failed to create station',
                    'errors' => $station->errors,
                ];
            }

        } catch (\Exception $exception) {
            $transaction->rollBack();
            return [
                'status' => 'error',
                'message' => 'An error occurred while saving the station',
                'errors' => $exception->getMessage(),
            ];
        }
    }

    /**
     * @param $id
     * @return array|string[]
     * @throws Exception
     */
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

    /**
     * @param $id
     * @return array|string[]
     * @throws \Throwable
     * @throws StaleObjectException
     */
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