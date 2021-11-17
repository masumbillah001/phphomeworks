<?php

include 'header.php';

$current_url = sprintf('%s://%s%s', $_SERVER['REQUEST_SCHEME'], $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI']);
$current_url = explode('?', $current_url);
$current_url = isset($current_url[0]) ? $current_url[0] : '';

$conn= empm_get_var('conn');
$table= empm_get_var('db_tbl_users');

$user_id = isset($_GET['id']) ? $_GET['id'] : '';
$action = isset($_GET['action']) ? $_GET['action'] : '';
$current_user = array();





if (!empty($user_id)) {
    $result = $conn->query("SELECT * FROM $table WHERE `id` = $user_id");
    $current_user = $result->fetch_assoc();
}

$first_name = isset($current_user['first_name']) ? $current_user['first_name'] : '';
$last_name = isset($current_user['last_name']) ? $current_user['last_name'] : '';
$user_name = isset($current_user['user_name']) ? $current_user['user_name'] : '';
$email_address = isset($current_user['email_address']) ? $current_user['email_address'] : '';
$phone_number = isset($current_user['phone_number']) ? $current_user['phone_number'] : '';
$street_address = isset($current_user['street_address']) ? $current_user['street_address'] : '';
$city = isset($current_user['city']) ? $current_user['city'] : '';
$zipcode = isset($current_user['zipcode']) ? $current_user['zipcode'] : '';
$country = isset($current_user['country']) ? $current_user['country'] : '';
$gender = isset($current_user['gender']) ? $current_user['gender'] : '';
$religion = isset($current_user['religion']) ? $current_user['religion'] : '';
$row_id = isset($current_user['id']) ? $current_user['id'] : '';
$error = array();

// Form Submission Handling
$form_submitted = isset($_POST['form_submitted']) ? $_POST['form_submitted'] : '';
if ($form_submitted == 'yes') {

    $first_name = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $last_name = isset($_POST['lastName']) ? $_POST['lastName'] : '';
    $user_name = isset($_POST['userName']) ? $_POST['userName'] : '';
    $email_address = isset($_POST['emailAddress']) ? $_POST['emailAddress'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $phone_number = isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : '';
    $street_address = isset($_POST['streetAddress']) ? $_POST['streetAddress'] : '';
    $city = isset($_POST['city']) ? $_POST['city'] : '';
    $zipcode = isset($_POST['zipCode']) ? $_POST['zipCode'] : '';
    $country = isset($_POST['country']) ? $_POST['country'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $religion = isset($_POST['religion']) ? $_POST['religion'] : '';
    $formAction = isset($_POST['form_action']) ? $_POST['form_action'] : '';
    $rowID = isset($_POST['row_id']) ? $_POST['row_id'] : '';

    //form validation
    if (empty($first_name)) {
        $error[] = 'Empty or invalid first name!';
    }

    if (empty($last_name)) {
        $error[] = 'Empty or invalid last name!';
    }

    if (empty($user_name)) {
        $error[] = 'Empty or invalid user name!';
    }

    if (empty($email_address)) {
        $error[] = 'Empty or invalid email address!';
    }

    if (empty($password)) {
        $error[] = 'Empty or invalid password!';
    }

    if (empty($phone_number)) {
        $error[] = 'Empty or invalid phone  number!';
    }

    if (empty($street_address)) {
        $error[] = 'Empty or invalid street address!';
    }

    if (empty($city)) {
        $error[] = 'Empty or invalid city!';
    }

    if (empty($zipcode)) {
        $error[] = 'Empty or invalid zipcode!';
    }

    if (empty($country)) {
        $error[] = 'Empty or invalid country!';
    }

    if (empty($gender)) {
        $error[] = 'Empty or invalid gender!';
    }

    if (empty($religion)) {
        $error[] = 'Empty or invalid religion!';
    }

    $password=md5($password);
    if(empty($error)){
        $sql_update = "UPDATE  $table
                      SET first_name = '$first_name',
                          last_name = '$last_name',
                          user_name = '$user_name',
                          email_address = '$email_address',
                          password = '$password',
                          phone_number = '$phone_number',
                          street_address = '$street_address',
                          city = '$city',
                          zipcode = '$zipcode',
                          country = '$country',
                          gender = '$gender',
                          religion = '$religion'
                     WHERE id = $rowID ";
        if (!$conn->query($sql_update)) {
            echo "Error: {$conn->error}";
        } else {
            header("LOCATION: $current_url");
        }
    }
}

// Delete
if ($action == 'delete') {

    echo "Do you really want to delete {$current_user['user_name']}?<br>";
    echo "<a href='$current_url?id=$row_id&action=confirm_delete'>Yes</a>&nbsp;&nbsp;&nbsp;&nbsp;";
    echo "<a href='$current_url'>No</a>";

    die();
}

//Delete Confirmation
if ($action == 'confirm_delete') {

    if ($conn->query("DELETE FROM $table WHERE `id`=$row_id")) {
        header("LOCATION: $current_url");
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    // Remove cookie data
    setcookie('user_logged_in', '');

    // Redirect to register page
    header('Location: register.php');

    die();
}

?>

    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Employee Management Application</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="?logout=true">Sign out</a>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php">
                                <span data-feather="home"></span>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="users.php">
                                <span data-feather="users"></span>
                                <span>Users</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="bar-chart-2"></span>
                                Reports
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="layers"></span>
                                <span>Settings</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Users</h1>
                </div>
                <div class="container">
                    <div class="row mt-5">
                        <div class="col-lg-5">
                            <h4 class="mb-3 text-underline">
                                <?php if (empm_current_user_id()) : ?>
                                    <span>Edit - <?php echo $user_name ?></span>
                                <?php endif; ?>
                            </h4>
                            <?php if (count($error) > 0) : foreach ($error as $errors) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $errors; ?>
                                </div>
                            <?php endforeach; endif; ?>
                            <form id="loginForm" method="post">
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <label for="firstName" class="firstName">First Name</label>
                                        <input name="firstName" value="<?php echo $first_name; ?>" type="text" class="form-control" id="firstName">
                                        <div id="firstName" class="form-text" aria-autocomplete="none">Enter your first name here.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="lastName" class="form-label">Last Name</label>
                                        <input name="lastName" value="<?php echo $last_name; ?>" type="text" class="form-control" id="lastName">
                                        <div id="lastName" class="form-text" aria-autocomplete="none">Enter last name.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="userName" class="form-label">User Name</label>
                                        <input name="userName" value="<?php echo $user_name; ?>" type="text" class="form-control" id="userName">
                                        <div id="userName" class="form-text" aria-autocomplete="none">Enter your user name.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="emailAddress" class="form-label">Email Address</label>
                                        <input name="emailAddress" value="<?php echo $email_address; ?>" type="email" class="form-control" id="emailAddress">
                                        <div id="emailAddress" class="form-text" aria-autocomplete="none">Enter your email address.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input value="" name="password" type="password" class="form-control" id="password" aria-autocomplete="none">
                                        <div id="password" class="form-text" aria-autocomplete="none">Enter password here.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phoneNumber" class="form-label">Phone Number</label>
                                        <input value="<?php echo $phone_number; ?>" name="phoneNumber" type="text" class="form-control" id="phoneNumber">
                                        <div id="phoneNumber" class="form-text" aria-autocomplete="none">Enter phone number here.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="streetAddress" class="form-label">Street Address</label>
                                        <input value="<?php echo $street_address; ?>" name="streetAddress" type="text" class="form-control" id="streetAddress">
                                        <div id="streetAddress" class="form-text" aria-autocomplete="none">Enter street address here.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="city" class="form-label">City</label>
                                        <input value="<?php echo $city; ?>" name="city" type="text" class="form-control" id="city">
                                        <div id="city" class="form-text" aria-autocomplete="none">Enter city here.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="zipCode" class="form-label">ZIP Code</label>
                                        <input value="<?php echo $zipcode; ?>" name="zipCode" type="text" class="form-control" id="zipCode">
                                        <div id="zipCode" class="form-text" aria-autocomplete="none">Enter Zip code here.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="country" class="form-label">Country</label>
                                        <input value="<?php echo $country; ?>" name="country" type="text" class="form-control" id="country">
                                        <div id="country" class="form-text" aria-autocomplete="none">Enter country here.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">Gender</label>
                                        <input value="<?php echo $gender; ?>" name="gender" type="text" class="form-control" id="gender">
                                        <div id="gender" class="form-text" aria-autocomplete="none">Enter gender here.</div>
                                    </div>
                                    <div>
                                        <label for="religion" class="form-label">Religion</label>
                                        <input value="<?php echo $religion; ?>" name="religion" type="text" class="form-control" id="religion">
                                        <div id="religion" class="form-text" aria-autocomplete="none">Enter religion here.</div>
                                    </div>
                                    <div class="alert alert-danger form-notice" style="display:none;" role="alert"></div>

                                    <div class="mt-3">
                                        <input type="hidden" name="form_submitted" value="yes">
                                        <input type="hidden" name="form_action" value=" <?php echo $action ?>">
                                        <input type="hidden" name="row_id" value=" <?php echo $row_id ?>">
                                        <button type="submit" class="btn btn-primary">
                                            <?php if ( empm_current_user_id()) : ?>
                                                <span>Update</span>
                                            <?php endif; ?>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-7">
                            <h4 class="mb-3 text-underline">Users</h4>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">User Name</th>
                                    <th scope="col">Email Address</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                $conn= empm_get_var('conn');
                                $table = empm_get_var('db_tbl_users');

                                $sql_select = "SELECT * FROM $table";
                                $index = 0;

                                if (!$result = $conn->query($sql_select)) {
                                    echo "Error:$conn->error}";
                                }

                                while ($row = $result->fetch_assoc()) : $index++; ?>
                                    <tr>
                                        <td><?php echo $index; ?></td>
                                        <td><?php echo $row['user_name']; ?></td>
                                        <td><?php echo $row['email_address']; ?></td>
                                        <td>
                                            <a type="button" href="<?php echo sprintf('%s?id=%s&action=edit', $current_url, empm_current_user_id()); ?>" class="btn btn-secondary"><i class="bi bi-pencil-square"></i></a>
                                            <a type="button" href="<?php echo sprintf('%s?id=%s&action=delete', $current_url, empm_current_user_id()); ?>" class="btn btn-danger"><i class="bi bi-archive"></i></a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    <?php
    include 'footer.php';