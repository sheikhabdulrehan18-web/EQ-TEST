<?php
require_once 'db.php';
checkLogin();
 
$user_id = $_SESSION['user_id'];
$last_result = $conn->query("SELECT * FROM results WHERE user_id = $user_id ORDER BY test_date DESC LIMIT 1");
$score_data = $last_result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | EQ Master</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background: #0f172a; color: white; margin: 0; }
        nav { padding: 1.5rem 10%; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.05); }
        .container { padding: 4rem 10%; max-width: 1200px; margin: 0 auto; }
        h1 { font-size: 2.5rem; margin-bottom: 2rem; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; }
        .card { 
            background: rgba(255, 255, 255, 0.03); 
            backdrop-filter: blur(10px); 
            border: 1px solid rgba(255,255,255,0.1); 
            padding: 2.5rem; 
            border-radius: 20px;
            animation: slideUp 0.6s ease-out;
        }
        @keyframes slideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .score-display { font-size: 4rem; font-weight: 600; color: #6366f1; margin: 1rem 0; }
        .btn { display: inline-block; padding: 1rem 2rem; background: linear-gradient(to right, #6366f1, #a855f7); color: white; text-decoration: none; border-radius: 12px; font-weight: 600; margin-top: 1rem; }
        .logout { color: #f87171; text-decoration: none; }
    </style>
</head>
<body>
    <nav>
        <div style="font-size: 1.5rem; font-weight: 600;">EQ Master</div>
        <a href="logout.php" class="logout">Logout</a>
    </nav>
    <div class="container">
        <h1>Welcome, <?php echo $_SESSION['user_name']; ?>!</h1>
        <div class="grid">
            <div class="card">
                <h3>Take Evaluation</h3>
                <p>Ready to measure your emotional intelligence? Our 15-question test takes about 5 minutes.</p>
                <a href="quiz.php" class="btn">Start New Test</a>
            </div>
            <div class="card">
                <h3>Latest Result</h3>
                <?php if($score_data): ?>
                    <p>Your last score (<?php echo date('M d, Y', strtotime($score_data['test_date'])); ?>):</p>
                    <div class="score-display"><?php echo $score_data['total_score']; ?></div>
                    <p>Level: <strong><?php echo $score_data['eq_level']; ?></strong></p>
                    <a href="result.php?id=<?php echo $score_data['id']; ?>" style="color: #6366f1; text-decoration: none;">View Detail</a>
                <?php else: ?>
                    <p>No tests taken yet. Start your journey today!</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
 
