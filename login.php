<?php
require_once 'db.php';
$error = '';
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = sanitize($conn, $_POST['email']);
    $password = $_POST['password'];
 
    $stmt = $conn->prepare("SELECT id, full_name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
 
    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['full_name'];
            header("Location: dashboard.php");
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "User not found!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | EQ Master</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background: #0f172a; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; color: white; }
        .glass-card { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.1); padding: 3rem; border-radius: 24px; width: 100%; max-width: 400px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        h2 { margin-bottom: 2rem; text-align: center; font-weight: 600; }
        .form-group { margin-bottom: 1.5rem; }
        input { width: 100%; padding: 12px 20px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; color: white; outline: none; }
        .btn { width: 100%; padding: 12px; border-radius: 12px; border: none; background: linear-gradient(to right, #6366f1, #a855f7); color: white; font-weight: 600; cursor: pointer; }
        .error { color: #f87171; text-align: center; margin-bottom: 1rem; }
        .link { text-align: center; margin-top: 1.5rem; display: block; color: #94a3b8; text-decoration: none; }
    </style>
</head>
<body>
    <div class="glass-card">
        <h2>Welcome Back</h2>
        <?php if($error): ?><div class="error"><?php echo $error; ?></div><?php endif; ?>
        <form method="POST">
            <div class="form-group"><input type="email" name="email" placeholder="Email Address" required></div>
            <div class="form-group"><input type="password" name="password" placeholder="Password" required></div>
            <button type="submit" class="btn">Login</button>
        </form>
        <a href="signup.php" class="link">Don't have an account? Sign Up</a>
    </div>
</body>
</html>
 
