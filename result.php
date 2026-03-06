<?php
require_once 'db.php';
checkLogin();
 
$result_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $conn->prepare("SELECT * FROM results WHERE id = ? AND user_id = ?");
$user_id = $_SESSION['user_id'];
$stmt->bind_param("ii", $result_id, $user_id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
 
if (!$data) { header("Location: dashboard.php"); exit(); }
 
$score = $data['total_score'];
$level = $data['eq_level'];
$max_score = 75; // 15 questions * 5 points
$percentage = ($score / $max_score) * 100;
 
$tips = [
    'Low EQ' => [
        'Practice naming your emotions as they happen.',
        'Wait 10 seconds before reacting to stressful situations.',
        'Try mirror-listening during conversations.'
    ],
    'Average EQ' => [
        'Focus on empathetic listening in difficult conversations.',
        'Journal your emotional triggers twice a week.',
        'Ask friends for feedback on your social interactions.'
    ],
    'High EQ' => [
        'Use your influence to mentor others in emotional regulation.',
        'Practice advanced mindfulness to fine-tune your intuition.',
        'Explore sub-nuances of complex social group dynamics.'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your EQ Results | EQ Master</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background: #0f172a; color: white; margin: 0; }
        .container { padding: 4rem 10%; max-width: 900px; margin: 0 auto; text-align: center; }
        .glass-card { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.1); padding: 4rem; border-radius: 30px; }
 
        .circular-progress {
            width: 200px; height: 200px; border-radius: 50%;
            background: conic-gradient(#6366f1 <?php echo $percentage; ?>%, rgba(255,255,255,0.05) 0);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 2rem; position: relative;
        }
        .circular-progress::before {
            content: ''; position: absolute; width: 170px; height: 170px;
            background: #0f172a; border-radius: 50%;
        }
        .score-num { position: relative; font-size: 3.5rem; font-weight: 600; color: white; }
 
        h1 { font-size: 2.5rem; margin-bottom: 0.5rem; }
        .level-badge { display: inline-block; padding: 0.5rem 1.5rem; background: #6366f1; border-radius: 50px; font-weight: 600; margin-bottom: 2rem; }
 
        .tips-section { text-align: left; margin-top: 3rem; background: rgba(255,255,255,0.02); padding: 2rem; border-radius: 20px; }
        .tips-section h3 { margin-bottom: 1rem; color: #a855f7; }
        ul { list-style: none; padding: 0; }
        li { margin-bottom: 1rem; padding-left: 1.5rem; position: relative; line-height: 1.5; }
        li::before { content: '→'; position: absolute; left: 0; color: #6366f1; }
 
        .btn { display: inline-block; padding: 1rem 2.5rem; background: linear-gradient(to right, #6366f1, #a855f7); color: white; text-decoration: none; border-radius: 50px; font-weight: 600; margin-top: 2rem; }
    </style>
</head>
<body>
    <div class="container">
        <div class="glass-card">
            <div class="circular-progress">
                <span class="score-num"><?php echo $score; ?></span>
            </div>
            <h1>Evaluation Complete</h1>
            <div class="level-badge"><?php echo $level; ?></div>
 
            <p>You scored <?php echo $score; ?> out of <?php echo $max_score; ?>. This indicates that you have a <strong><?php echo strtolower($level); ?></strong> profile compared to global benchmarks.</p>
 
            <div class="tips-section">
                <h3>Personalized Improvement Tips:</h3>
                <ul>
                    <?php foreach($tips[$level] as $tip): ?>
                        <li><?php echo $tip; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
 
            <a href="dashboard.php" class="btn">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
 
