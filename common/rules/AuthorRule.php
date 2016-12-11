<?php
namespace common\rules;

use yii\rbac\Rule;
use common\models\User;
use yii\helpers\User as UserHelper;

/**
 * Checks if a board/task/post belongs to a user
 */
class AuthorRule extends Rule
{
    public $name = 'isAuthor';

    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        if (!isset($params['type']))
            return false;

        switch($params['type']) {
            case 'board':
                return isset($params['item']) ? $params['item']->admin_id == $user : false || 
                    in_array('admin', UserHelper::getUserRoles($user));
            case 'task':
            case 'post':
                return isset($params['item']) ? $params['item']->author_id == $user : false || 
                    in_array('admin', UserHelper::getUserRoles($user));
            default:
                return false;
        }
    }
}