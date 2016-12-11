<?php

namespace yii\helpers;

use Yii;

class User {
	public static function getUserRoles($id) {
        $roles = Yii::$app->authManager->getRoles($id);

        return array_keys($roles);
    }
}