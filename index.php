<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EQ Test Platform | Master Your Emotions</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --secondary: #a855f7;
            --bg: #0f172a;
            --glass: rgba(255, 255, 255, 0.05);
            --text: #f8fafc;
        }
 
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at top left, #1e1b4b, #0f172a);
            color: var(--text);
            overflow-x: hidden;
            min-height: 100vh;
        }
 
        .animated-bg {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1;
            background: linear-gradient(45deg, #1e1b4b, #312e81, #1e1b4b);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }
 
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
 
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2rem 10%;
            backdrop-filter: blur(10px);
        }
 
        .logo { font-size: 1.8rem; font-weight: 600; color: var(--primary); }
 
        .hero {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            height: calc(100vh - 150px);
            padding: 0 10%;
        }
 
        h1 {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(to right, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: fadeIn 1s ease-out;
        }
 
        p {
            font-size: 1.2rem;
            color: #94a3b8;
            max-width: 600px;
            margin-bottom: 2.5rem;
            line-height: 1.6;
        }
 
        .cta-group { display: flex; gap: 1.5rem; }
 
        .btn {
            padding: 1rem 2.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }
 
        .btn-primary {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
        }
 
        .btn-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.6);
        }
 
        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }
 
        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }
 
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
 
        @media (max-width: 768px) {
            h1 { font-size: 2.5rem; }
            .cta-group { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="animated-bg"></div>
    <nav>
        <div class="logo">EQ Master</div>
        <div class="auth-links">
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="dashboard.php" class="btn btn-outline">Dashboard</a>
            <?php else: ?>
                <a href="login.php" style="color: white; text-decoration: none; margin-right: 20px;">Login</a>
                <a href="signup.php" class="btn btn-primary">Sign Up</a>
            <?php endif; ?>
        </div>
    </nav>
 
    <div class="hero">
        <h1>Discover Your Emotional Intelligence</h1>
        <p>Unlock deeper self-awareness and stronger relationships through our professionally designed EQ evaluation tool.</p>
        <div class="cta-group">
            <a href="signup.php" class="btn btn-primary">Start My Evaluation</a>
            <a href="#about" class="btn btn-outline">Learn More</a>
        </div>
    </div>
</body>
</html>
 
