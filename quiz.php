<?php
require_once 'db.php';
checkLogin();
 
$questions = $conn->query("SELECT * FROM questions ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EQ Assessment | EQ Master</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background: #0f172a; color: white; display: flex; flex-direction: column; min-height: 100vh; margin: 0; }
        .progress-container { position: fixed; top: 0; left: 0; width: 100%; height: 6px; background: rgba(255,255,255,0.05); z-index: 100; }
        .progress-bar { height: 100%; width: 0%; background: linear-gradient(to right, #6366f1, #a855f7); transition: width 0.4s ease; }
        .container { flex: 1; display: flex; align-items: center; justify-content: center; padding: 2rem; }
        .quiz-card { 
            background: rgba(255, 255, 255, 0.03); 
            backdrop-filter: blur(15px); 
            border: 1px solid rgba(255, 255, 255, 0.1); 
            padding: 3rem; 
            border-radius: 24px; 
            width: 100%; 
            max-width: 600px; 
            display: none;
            text-align: center;
        }
        .quiz-card.active { display: block; animation: fadeIn 0.5s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        h2 { font-size: 1.5rem; margin-bottom: 2rem; line-height: 1.4; }
        .options { display: grid; gap: 1rem; }
        .option-btn { 
            padding: 1rem; 
            background: rgba(255,255,255,0.05); 
            border: 1px solid rgba(255,255,255,0.1); 
            border-radius: 12px; 
            color: white; 
            cursor: pointer; 
            transition: 0.3s;
            text-align: center;
        }
        .option-btn:hover { background: rgba(99, 102, 241, 0.2); border-color: #6366f1; }
        .option-btn.selected { background: #6366f1; border-color: #6366f1; box-shadow: 0 0 15px rgba(99, 102, 241, 0.4); }
        .controls { margin-top: 2rem; display: flex; justify-content: space-between; }
        .btn-nav { padding: 0.8rem 1.5rem; border-radius: 10px; border: none; background: rgba(255,255,255,0.1); color: white; cursor: pointer; }
        .btn-submit { background: linear-gradient(to right, #6366f1, #a855f7); display: none; padding: 0.8rem 1.5rem; border-radius: 10px; border: none; color: white; cursor: pointer; font-weight: 600; }
    </style>
</head>
<body>
    <div class="progress-container"><div class="progress-bar" id="progress"></div></div>
    <div class="container">
        <form id="quizForm" action="submit_quiz.php" method="POST">
            <?php 
            $q_count = 1;
            $total_qs = $questions->num_rows;
            while($q = $questions->fetch_assoc()): 
                $q_id = $q['id'];
                $options = $conn->query("SELECT * FROM options WHERE question_id = $q_id");
            ?>
            <div class="quiz-card <?php echo $q_count == 1 ? 'active' : ''; ?>" data-step="<?php echo $q_count; ?>">
                <h3>Question <?php echo $q_count; ?> of <?php echo $total_qs; ?></h3>
                <h2><?php echo $q['question_text']; ?></h2>
                <div class="options">
                    <?php while($o = $options->fetch_assoc()): ?>
                        <div class="option-btn" onclick="selectOption(this, <?php echo $q_id; ?>, <?php echo $o['score_value']; ?>)">
                            <?php echo $o['option_text']; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
                <input type="hidden" name="answers[<?php echo $q_id; ?>]" id="q_<?php echo $q_id; ?>" required>
 
                <div class="controls">
                    <?php if($q_count > 1): ?>
                        <button type="button" class="btn-nav" onclick="prevStep()">Previous</button>
                    <?php else: ?><div></div><?php endif; ?>
 
                    <?php if($q_count < $total_qs): ?>
                        <button type="button" class="btn-nav" onclick="nextStep()" id="nextBtn_<?php echo $q_count; ?>">Next</button>
                    <?php else: ?>
                        <button type="submit" class="btn-submit" id="submitBtn">Generate Result</button>
                    <?php endif; ?>
                </div>
            </div>
            <?php $q_count++; endwhile; ?>
        </form>
    </div>
 
    <script>
        let currentStep = 1;
        const totalSteps = <?php echo $total_qs; ?>;
 
        function updateProgress() {
            document.getElementById('progress').style.width = ((currentStep / totalSteps) * 100) + '%';
        }
 
        function selectOption(el, qId, score) {
            const card = el.closest('.quiz-card');
            card.querySelectorAll('.option-btn').forEach(btn => btn.classList.remove('selected'));
            el.classList.add('selected');
            document.getElementById('q_' + qId).value = score;
        }
 
        function nextStep() {
            const currentCard = document.querySelector(`.quiz-card[data-step="${currentStep}"]`);
            const input = currentCard.querySelector('input[type="hidden"]');
 
            if (!input.value) {
                alert('Please choose an answer to continue.');
                return;
            }
 
            currentCard.classList.remove('active');
            currentStep++;
            document.querySelector(`.quiz-card[data-step="${currentStep}"]`).classList.add('active');
            if (currentStep === totalSteps) {
                const submitBtn = document.getElementById('submitBtn');
                if(submitBtn) submitBtn.style.display = 'block';
            }
            updateProgress();
        }
 
        function prevStep() {
            document.querySelector(`.quiz-card[data-step="${currentStep}"]`).classList.remove('active');
            currentStep--;
            document.querySelector(`.quiz-card[data-step="${currentStep}"]`).classList.add('active');
            updateProgress();
        }
 
        updateProgress();
    </script>
</body>
</html>
 
