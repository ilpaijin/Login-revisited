<?php 
    require_once 'core/init.php';

    if(classes\Input::exists())
    {
        echo classes\Input::get('name');
    }

?>

<form action="" method="post">
    <div class="field">
        <label for="username">
            Username
        </label>
        <input type="text" name="username" id="username" value="" autocomplete="off" />
    </div>
    
    <div class="password">
        <label for="password">Choose a password</label>
        <input type="text" name="passowrd" id="password" />
    </div>
    
    <div class="password">
        <label for="password_again">Enter your password again</label>
        <input type="text" name="passowrd_again" id="password_again" />
    </div>

    <div class="password">
        <label for="name">Name</label>
        <input type="text" name="name" value="" id="name" />
    </div>

    <input type="submit" value="Register" />
</form>