<?php

namespace app\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "board".
 *
 * @property integer $id
 * @property string $name
 * @property integer $admin_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $admin
 * @property BoardUser[] $boardUsers
 * @property Post[] $posts
 * @property Task[] $tasks
 */
class Board extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'board';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'admin_id'], 'required'],
            [['admin_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['admin_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['admin_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'admin_id' => 'Admin ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdmin()
    {
        return $this->hasOne(User::className(), ['id' => 'admin_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBoardUsers()
    {
        return $this->hasMany(BoardUser::className(), ['board_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['board_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['board_id' => 'id']);
    }

    // get list of boards in which the given user id is a member of
    public function getUserBoards($id) {
        return Board::find()
            ->join('INNER JOIN', 'board_user', 'board.id = board_user.board_id')
            ->where(['board_user.user_id' => $id])
            ->all();
    }
}
