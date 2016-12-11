<?php

namespace app\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "board_user".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $board_id
 * @property string $joined_at
 *
 * @property Board $board
 * @property User $user
 */
class BoardUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'board_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'board_id'], 'required'],
            [['user_id', 'board_id'], 'integer'],
            [['joined_at'], 'safe'],
            [['board_id'], 'exist', 'skipOnError' => true, 'targetClass' => Board::className(), 'targetAttribute' => ['board_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'board_id' => 'Board ID',
            'joined_at' => 'Joined At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBoard()
    {
        return $this->hasOne(Board::className(), ['id' => 'board_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    // get list of users and their information given a board id
    public function getBoardUsers($id) {
        return User::find()
            ->select(['"user".id', 'username', 'email'])
            ->join('INNER JOIN', 'board_user', '"user".id = board_user.user_id')
            ->where(['board_user.board_id' => $id])
            ->all();
    }
}
