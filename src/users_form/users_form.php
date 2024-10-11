<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/cinema/config_session.php';
require_once $_SERVER["DOCUMENT_ROOT"] . "/cinema/src/authorization/checkAuthorization.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/cinema/src/authorization/rolesValidation.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/cinema/src/authorization/roleQueries.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/cinema/src/authorization/authorizationQueries.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/cinema/src/authorization/authorizationValidation.php";

if (checkAuthorization() != false) header("Location: /cinema/src/authorization/authorization-page.php");
$roleName = getRoleName($_SESSION["role_id"]);
if (!isAdmin($roleName)) exit();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'user') {
    $login = $_POST["login"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role_id = $_POST["role_id"];

    if (($result = validateRegistration($login, $email, $password)) != false) {
        $error_message = "<p style='color: red;'>" . nl2br($result) . "</p>";
    } else if (login_verify($login)) {
        setUser($login, password_hash($password, PASSWORD_BCRYPT), $email, $role_id);
    } else $error_message = "<p style='color: red;'>" . "Указанный логин уже занят" . "</p>";
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.min.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="/cinema/css/main.css" />
    <title>Form</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="">Navbar</a>
        <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="/cinema/index.php">Home <span class="sr-only">(current)</span></a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="/cinema/src/authorization/authorization-page.php">Authorization</a>
                </li>

                <li class="nav-item dropdown">
                    <a
                        class="nav-link dropdown-toggle"
                        href="#"
                        id="navbarDropdownMenuLink"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                        Tables Forms
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a
                            class="dropdown-item"
                            href="/cinema/src/movies_form/movies_form.php">Movies form</a>
                        <a
                            class="dropdown-item"
                            href="/cinema/src/sessions_form/sessions_form.php">Sessions form</a>
                        <a
                            class="dropdown-item"
                            href="/cinema/src/users_form/users_form.php">Users form</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <h1>Users Form</h1>

    <main>
        <form action="users_form.php" method="post">
            <label for="login">Login</label>
            <input id="login" type="text" name="login" placeholder="Login..." />

            <label for="email">Email</label>
            <input id="email" type="email" name="email" placeholder="Email..." />

            <label for="password">Password</label>
            <input type="text" id="password" name="password" placeholder="Password..." />

            <label for="role_id">Role</label>

            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Select role
                </button>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <?php
                    require_once $_SERVER['DOCUMENT_ROOT'] . "/cinema/src/authorization/roleQueries.php";
                    $usersArray = getRoles();
                    ?>

                    <?php foreach ($usersArray as $row): ?>
                        <button class="dropdown-item" type="button" onclick="selectUser('<?php echo htmlspecialchars($row['id']); ?>', '<?php echo htmlspecialchars($row['role_name']); ?>')">
                            <?php echo htmlspecialchars($row['role_name']); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
            <script>
                function selectUser(id, role) {
                    document.getElementById('role_id').value = id;
                    document.getElementById('dropdownMenuButton').innerText = role;
                }
            </script>

            <input id="role_id" type="text" name="role_id" placeholder="Role..." readonly />

            <input type="hidden" name="action" value="user" />
            <button type="submit">Submit</button>
        </form>

        <?php
        if (isset($error_message)) {
            echo $error_message;
        }
        ?>

        <!-- Таблица user-ов -->

        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . "/cinema/src/authorization/roleQueries.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/cinema/src/authorization/authorizationQueries.php";

        $usersArray = getUsers();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['filterUsers'])) {
                $login = $_POST['login'];
                $email = $_POST['email'];

                // Фильтрация массива
                $usersArray = array_filter($usersArray, function ($user) use ($login, $email) {
                    $matchLogin = empty($login) || $user['login'] == $login;
                    $matchEmail = empty($email) || $user['email'] == $email;
                    return $matchLogin && $matchEmail;
                });
            } elseif (isset($_POST['resetUsers'])) {
                $usersArray = getUsers();
            }
        }

        ?>

        <div class="container">
            <h2 class="mb-5">Users Table</h2>

            <form method="post">
                <input type="text" name="login" placeholder="Login" value="<?php echo isset($_POST['login']) ? htmlspecialchars($_POST['login']) : ''; ?>">
                <input type="text" name="email" placeholder="Email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                <button type="submit" name="filterUsers">Фильтровать</button>
                <button type="submit" name="resetUsers">Сбросить фильтры</button>
            </form>

            <div class="table-responsive">
                <form method="POST" id="deleteMoviesForm">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Id</th>
                                <th scope="col">Login</th>
                                <th scope="col">Email</th>
                                <th scope="col">Password</th>
                                <th scope="col">Role Id</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usersArray as $row): ?>
                                <tr>
                                    <th scope="row">
                                        <label class="control control--checkbox">
                                            <input type="checkbox" name="delete_ids[]" value="<?php echo $row['id']; ?>" />
                                            <div class="control__indicator"></div>
                                        </label>
                                    </th>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo htmlspecialchars($row['login']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['password']); ?></td>
                                    <td><?php echo htmlspecialchars($row['role_id']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button type="button" onclick="confirmUsersDeletion()" class="btn btn-danger">Delete Selected</button>
                </form>

                <script>
                    function confirmUsersDeletion() {
                        const selectedIds = document.querySelectorAll('input[name="delete_ids[]"]:checked');
                        if (selectedIds.length === 0) {
                            alert("Please select at least one user to delete.");
                            return;
                        }
                    }
                </script>
            </div>
        </div>

    </main>

    <script
        src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>

</html>