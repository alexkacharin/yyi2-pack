<?php

use yii\db\Migration;

/**
 * Class m230613_164406_create_user_admin
 */
class m230613_164406_create_user_admin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
$auth = Yii::$app->authManager;

        // create a role named "administrator"
        $administratorRole = $auth->createRole('admin');
        $administratorRole->description = 'Administrator';
        $auth->add($administratorRole);

        // create permission for certain tasks
        $permission = $auth->createPermission('user-management');
        $permission->description = 'User Management';
        $auth->add($permission);

        // let administrators do user management
        $auth->addChild($administratorRole, $auth->getPermission('user-management'));

        // create user "admin" with password "verysecret"
        $user = new \Da\User\Model\User([
            'scenario' => 'create', 
            'email' => "email@example.com", 
            'username' => "admin", 
            'password' => "verysecret"  // >6 characters!
        ]);
        $user->confirmed_at = time();
        $user->save();

        // assign role to our admin-user
        $auth->assign($administratorRole, $user->id);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230613_164406_create_user_admin cannot be reverted.\n";
$auth = Yii::$app->authManager;

        // delete permission
        $auth->remove($auth->getPermission('user-management'));

        // delete admin-user and administrator role
        $administratorRole = $auth->getRole("administrator");
        $user = \Da\User\Model\User::findOne(['username'=>"admin"]);
        $auth->revoke($administratorRole, $user->id);
        $user->delete();
        $auth->remove($administratorRole);
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230613_164406_create_user_admin cannot be reverted.\n";

        return false;
    }
    */
}
