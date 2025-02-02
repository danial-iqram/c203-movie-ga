<?php
$user = $_SESSION["user"];
$isDark = $user["theme"] === "Dark";

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $username = $_POST["username"];
    $email = $_POST["email"];
    $name = $_POST["name"];
    $dob = $_POST["date"];
    $theme = $_POST["theme"];

    $db->updateUser(["username" => $username, "email" => $email, "name" => $name, "dob" => $dob, "theme" => $theme, "id" => $user["id"]]);
    $_SESSION["user"] = $db->getUserByEmailOrUsername($username);
    redirectUrl("settings.php");
    exit();
}
?>

<div>
    <h2 class="text-center pt-3">Settings</h2>
    <form action="settings.php" method="post">
            <div style="margin: 30px auto;width:350px">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= $user["username"]; ?>" required>
            </div>

            <div style="margin: 30px auto;width:350px">
                <label for="email" class="form-label">Email:</label>
                <input type="text" class="form-control" id="email" name="email" value="<?= $user["email"]; ?>" required>
            </div>

            <div style="margin: 30px auto;width:350px">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $user["name"]; ?>" required>
            </div>

            <div style="margin: 30px auto;width:350px">
                <label for="date" class="form-label">Date of Birth:</label>
                <input type="date" class="form-control" id="date" name="date" value="<?= $user["dob"]; ?>" required>
            </div>

            <div style="margin: 30px auto;width:350px">
                <label for="theme" class="form-label">Theme:</label>
                <select class="form-select" id="theme" name="theme" required>
                    <?php if ($isDark) { ?>
                        <option selected>Dark</option>
                        <option>Light</option>
                    <?php } else { ?>
                        <option>Dark</option>
                        <option selected>Light</option>
                    <?php } ?>
                </select>
            </div>
           
            <div class="text-center">
                <input type="submit" class="btn btn-success" value="Update">
            </div>
        </form>
</div>