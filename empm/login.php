<?php

include 'header.php';


$form_submission = isset($_POST['form_submission']) ? $_POST['form_submission'] : '';
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$errors = array();

if ($form_submission === 'yes') :

    if (empty($username)) {
        $errors[] = 'Empty or invalid Username!';
    }

    if (empty($password)) {
        $errors[] = 'Empty or invalid Password!';
    }

    if (empty($errors) && $user_id = empm_check_user_login($username, $password)) {

        // User logged in and store data in cookie
        setcookie('user_logged_in', $user_id);

        header('Location: index.php');
    }

    $errors[] = 'Wrong Username or Password!';

endif;


// Check if user already logged in
if (empm_current_user_id()) {
    header('Location: index.php');
}

?>

<main class="form-signin text-center mt-5">
    <form action="" method="post">
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

        <?php if (count($errors) > 0) : foreach ($errors as $error) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endforeach; endif; ?>

        <div class="form-floating mb-3">
            <input type="text" name="username" class="form-control" id="username" placeholder="john" value="<?php echo $username; ?>">
            <label for="username">Username</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" value="<?php echo $password; ?>">
            <label for="floatingPassword">Password</label>
        </div>
        <input type="hidden" name="form_submission" value="yes">
        <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
        <p class="mt-2 mb-2">Don't have any account? <a href="register.php">Register</a> Now</p>
        <p class="mt-5 mb-3 text-muted">&copy; 2020–2021</p>
    </form>
</main>


<?php include 'footer.php'; ?>
