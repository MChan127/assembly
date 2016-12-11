<?php
namespace common\rules;

use yii\rbac\Rule;
use common\models\User;
use yii\helpers\User as UserHelper;
use app\models\BoardUser;

/**
 * Checks if a user is a member of a board
 */
class MemberRule extends Rule
{
    public $name = 'isMember';

    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        if (!isset($params['board']))
            return false;

        if (in_array('admin', UserHelper::getUserRoles($user))) {
            return true;
        }

        $check = BoardUser::find()
            ->where(['board_id' => $params['board'], 'user_id' => $user])
            ->one();
        return !empty($check);
    }
}