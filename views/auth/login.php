<?php
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/Database.php');
include($_SERVER['DOCUMENT_ROOT'] . '/ENSAHify/views/auth/session.php');

if (isset($_REQUEST['email']) && !empty($_REQUEST['email']) && isset($_REQUEST['password']) && !empty($_REQUEST['password'])) {
    $email = mysqli_real_escape_string($conn, $_REQUEST['email']);
    $password = mysqli_real_escape_string($conn, $_REQUEST['password']);
    $qr = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' AND password = '".md5($password)."'");

    if (mysqli_num_rows($qr) > 0) {
        $data = mysqli_fetch_assoc($qr);
        $user_id = $data['id'];
        $role_id = $data['role'];
        $dep_id = $data['id_dep'];
        $fil_nom = $data['nom_filiere'];
        $niveau = $data['niveau'];
        $cne = $data['CNE'];
        $role_query = mysqli_query($conn, "SELECT role FROM roles WHERE id = '$role_id'");
        $role_data = mysqli_fetch_assoc($role_query);
        $data['role_name'] = $role_data['role'];

        $_SESSION['user_data'] = $data;
        $_SESSION['dep_id'] = $dep_id;
        $_SESSION['fil_nom'] = $fil_nom;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['niveau'] = $niveau;
        $_SESSION['cne'] = $cne;
        $_SESSION['role_name'] = $data['role_name'];

        if (isset($_REQUEST['remember']) && $_REQUEST['remember'] === 'checked') {
            $selector = bin2hex(random_bytes(12));
            $validator = random_bytes(32);
            $hashed_validator = hash('sha256', $validator);
            $expiry = date('Y-m-d H:i:s', strtotime('+30 days'));

            $stmt = $conn->prepare("INSERT INTO user_tokens (selector, hashed_validator, user_id, expiry) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssis", $selector, $hashed_validator, $user_id, $expiry);
            $stmt->execute();
            $stmt->close();

            setcookie('remember', $selector.':'.bin2hex($validator), time() + (86400 * 30), "/", "", false, true);
        }

        switch ($data['role']) {
            case 1:
                header("Location: /ENSAHify/views/chef_dep/home.php");
                break;
            case 2:
                header("Location: /ENSAHify/views/coordinateur/home.php");
                break;
            case 3:
                header("Location: /ENSAHify/views/professeur/home.php");
                break;
            case 4:
                header("Location: /ENSAHify/views/student/home.php");
                break;
        }
        exit();
    } else {
        $_SESSION['error'][] = "Invalid login details";
        header("Location:/ENSAHify/index.php");
        exit();
    }
} else {
    $_SESSION['error'][] = "Please enter your login credentials";
    header("Location:/ENSAHify/index.php");
    exit();
}
?>
