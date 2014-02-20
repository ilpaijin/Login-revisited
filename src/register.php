<?php 
    require_once 'core/init.php';

    if(Li\Input::exists())
    {
        if(Li\Token::check(Li\Input::get('csrf-token')))
        {
            $validator = new Li\Validator(array('csrf' => true ));

            $validation = $validator->addRules(array(
                'username' => 'required|max:5|unique',
                'password' => 'min:3',
                'password_again' => 'equals:password'
            ))->validate($_POST);

            if($validation->passes())
            {
                $user = new Li\User();

                $salt = Li\Hash::salt(32);

                try
                {
                    $user->create(array(
                        'username' => Li\Input::get('username'), 
                        'password' => Li\Hash::make(Li\Input::get('password'), $salt),
                        'salt' => $salt,
                        'name' => Li\Input::get('name'),
                        'joined' => date('Y-m-d H:i:s'),
                        'group' => 1     
                    ));
                } catch(\Exception $e)
                {   
                    die($e);
                }

                Li\Session::flash('success', 'You registered successfully');
                header('Location: index.php');
            } else 
            {
                var_dump($validation->errors());
            }
        }
    }

?>

<form action="" method="post">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?php echo escape(Li\Input::get('username')); ?>" autocomplete="off" />
        <span><?php if(Li\Input::exists()) { echo escape($validation->errorsUsernames()) ?: ''; } ?></span>
    </div>
    
    <div class="password">
        <label for="password">Choose a password</label>
        <input type="password" name="password" id="password" />
        <span><?php if(Li\Input::exists()) { echo escape($validation->errorsPassword()) ?: '';} ?></span>
    </div>
    
    <div class="password_again">
        <label for="password_again">Enter your password again</label>
        <input type="password" name="password_again" id="password_again" />
        <span><?php if(Li\Input::exists()) { echo escape($validation->errorsPassword_again()) ?: '';} ?></span>
    </div>

    <div class="name">
        <label for="name">Name</label>
        <input type="text" name="name" value="<?php echo escape(Li\Input::get('name')); ?>" id="name" />
        <span><?php if(Li\Input::exists()) { echo escape($validation->errorsName()) ?: '';} ?></span>
    </div>

    <input type="hidden" name="csrf-token" value="<?php echo Li\Token::generate(); ?>">
    <input type="submit" value="Register" />
</form>