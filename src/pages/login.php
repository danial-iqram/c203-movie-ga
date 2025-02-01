<?php
// If user is already logged in, redirect to home page
if (isset($_SESSION["user"])) {
    redirectUrl("/");
}

// Handle logging in
if (isset($_POST["username"]) && isset($_POST["password"])) {
    if (!validateCSRFToken($_POST["csrf_token"])) {
        die("Invalid CSRF token.");
    }

    $user = $db->getUserByEmailOrUsername($_POST["username"]);

    if ($user && $db->isValidUserCredentials($user["id"], $_POST["password"])) {
        $_SESSION["user"] = $user;

        redirectUrl("/");
    } else {
        $invalidCredentials = true;
    }
}
?>

<style>
    #loginFormContainer {
        width: 100vw;
        margin-inline: auto;
    }

    #loginForm {
        width: 100%;
    }

    #loginForm > fieldset {
        max-width: 24rem;
    }

    #submitButton {
        width: 100%;
    }
</style>

<div id="loginFormContainer">
    <form action="login.php" method="POST" class="pt-3" id="loginForm">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
        <fieldset class="border rounded-3 p-3 text-center mx-auto">
            <h2 class="pb-2">Login?</h2>

            <div class="form-floating pb-3">
                <input type="username" class="form-control <?php if (isset($invalidCredentials)) { echo "is-invalid"; } ?>" name="username" placeholder="Username / Email" required />
                <label for="username">Username / Email</label>
            </div>
            <div class="form-floating pb-3">
                <input type="password" class="form-control <?php if (isset($invalidCredentials)) { echo "is-invalid"; } ?>" name="password" placeholder="Password" required />
                <label for="password">Password</label>
                <?php if (isset($invalidCredentials)) { ?>
                    <div id="feedback" class="invalid-feedback text-start">
                        Invalid username or password
                    </div>
                <?php } ?>
               
            </div>

            <button class="btn btn-success" type="submit" id="submitButton">Login</button>
            <p class="pt-3">Not a member yet? <a href="register.php">Register</p>
        </fieldset>
    </form>
</div>
