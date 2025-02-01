<?php
// If user is already logged in, redirect to home page
if (isset($_SESSION["user"])) {
    redirectUrl("index.php");
}

$invalidCredentials = [];

$username = "";
$email = "";
$date = "";
$name = "";

// Handle registering
if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["email"]) && isset($_POST["name"]) && isset($_POST["date"]) && isset($_POST["password_confirmation"])) {
    if (!validateCSRFToken($_POST["csrf_token"])) {
        die("Invalid CSRF token.");
    }

    $username = $_POST["username"];
    $email = $_POST["email"];
    $date = $_POST["date"];
    $name = $_POST["name"];

    $userByUsername = $db->getUserByEmailOrUsername($username);
    $userByEmail = $db->getUserByEmailOrUsername($email);

    if ($userByUsername) {
        $invalidCredentials["username"] = true;
    }

    if ($userByEmail) {
        $invalidCredentials["email"] = true;
    }

    if ($_POST["password"] !== $_POST["password_confirmation"]) {
        $invalidCredentials["password_confirmation"] = true;
    }

    if (count($invalidCredentials) === 0) {
        $db->addUser([ 
            "username" => $username, 
            "password" => password_hash($_POST["password"], PASSWORD_DEFAULT), 
            "name" => $name, 
            "dob" => $date,
            "email" => $email 
        ]);
        $_SESSION["user"] = $db->getUserByEmailOrUsername($username);
        redirectUrl("index.php");
    }
}
?>

<style>
    #registerFormContainer {
        width: 100vw;
        margin-inline: auto;
    }

    #registerForm {
        width: 100%;
    }

    #registerForm > fieldset {
        max-width: 24rem;
    }

    #submitButton {
        width: 100%;
    }
</style>

<div id="registerFormContainer">
    <form action="register.php" method="POST" class="pt-3" id="registerForm">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <fieldset class="border rounded-3 p-3 text-center mx-auto">
            <h2 class="pb-2">Register?</h2>

            <div class="form-floating pb-3">
                <input type="username" class="form-control <?php if (isset($invalidCredentials["username"])) { echo "is-invalid"; } ?>" value="<?php echo $username ?>" name="username" placeholder="Username" required />
                <label for="username">Username</label>
                <?php if (isset($invalidCredentials["username"])) { ?>
                    <div id="feedback" class="invalid-feedback text-start">
                        Username already exists
                    </div>
                <?php } ?>
            </div>

            <div class="form-floating pb-3">
                <input type="email" class="form-control <?php if (isset($invalidCredentials["email"])) { echo "is-invalid"; } ?>" value="<?php echo $email ?>" name="email" placeholder="Email" required />
                <label for="email">Email</label>
                <?php if (isset($invalidCredentials["email"])) { ?>
                    <div id="feedback" class="invalid-feedback text-start">
                        Email already exists
                    </div>
                <?php } ?>
            </div>

            <div class="form-floating pb-3">
                <input type="text" class="form-control" name="name" placeholder="name" value="<?php echo $name ?>" required />
                <label for="name">Name</label>
            </div>

            <div class="form-floating pb-3">
                <input type="date" class="form-control" name="date" placeholder="date" value="<?php echo $date ?>" required />
                <label for="date">Date of Birth</label>
                
            </div>

            <div class="form-floating pb-3">
                <input type="password" class="form-control <?php if (isset($invalidCredentials["password_confirmation"])) { echo "is-invalid"; } ?>" name="password" placeholder="Password" required />
                <label for="password">Password</label>
            </div>

            <div class="form-floating pb-3">
                <input type="password" class="form-control <?php if (isset($invalidCredentials["password_confirmation"])) { echo "is-invalid"; } ?>" name="password_confirmation" placeholder="Confirm Password" required />
                <label for="password_confirmation">Confirm Password</label>
                <?php if (isset($invalidCredentials["password_confirmation"])) { ?>
                    <div id="feedback" class="invalid-feedback text-start">
                        Passwords do not match
                    </div>
                <?php } ?>
            </div>

            <button class="btn btn-primary" type="submit" id="submitButton">Register</button>
            <p class="pt-3">Have an account? <a href="login.php">Login</p>
        </fieldset>
    </form>
</div>
