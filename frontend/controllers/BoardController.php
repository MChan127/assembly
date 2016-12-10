<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

use app\models\Board;
use app\models\BoardUser;

class BoardController extends Controller
{
    /**
     * Displays a single Board model.
     * @param integer $id
     * @return mixed
     */
    public function actionIndex($id)
    {
        return $this->render('index', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Board model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Board();
        $post = Yii::$app->request->post();

        //if ($model->load(Yii::$app->request->post()) && $model->save()) {
        if (!empty($post['Board'])) {
            $post = $post['Board'];
            $model->name = $post['name'];
            if (empty($post['admin_id'])) {
                $model->admin_id = Yii::$app->user->id;
            } else {
                $model->admin_id = $post['admin_id'];
            }
            $model->save();

            // create the user-board relationship model
            $board_user = new BoardUser();
            $board_user->board_id = $model->id;
            $board_user->user_id = Yii::$app->user->id;
            $board_user->save();

            // check if this is an admin user
            //if (strcasecmp(key(Yii::$app->authmanager->getRoles(Yii::$app->user->id)), 'admin') === 0) {
                return $this->redirect(['index', 'id' => $model->id]);
            //}
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the Board model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Board the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Board::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
