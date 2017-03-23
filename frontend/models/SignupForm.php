<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;
use Yii;
use backend\models\AuthAssignment;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $first_name;
    public $last_name;
    public $username;
    public $email;
    public $password;
    public $permissions;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],

            ['username', 'required'],
            ['first_name', 'required', 'message' => 'Have to fill your first name'],
            ['last_name', 'required', 'message' => 'Have to fill your last name'],

            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        $user->save(false);

      /*
        // add permession author by default


        // the following three lines were added:
        $auth = Yii::$app->authManager;
        $authorRole = $auth->getRole('author');
        $auth->assign($authorRole, $user->getId());
      */
     /*
        // lets add the permissions
        $permissionList = $_POST['SignupForm']['permissions'];

        if(!empty($permissionList)){
            foreach ($permissionList as $permission)
            {
                $newPermission = new AuthAssignment;
                $newPermission->user_id = (string)$user->id;
                $newPermission->item_name = $permission;
                $newPermission->created_at = time();
                $newPermission->save();

            }

        }
        */


        return $user->save() ? $user : null;
    }
}
