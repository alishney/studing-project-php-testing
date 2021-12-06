<?php

include './questions.php';

function findQuestionById(string $questionId, array $questions)
{
    foreach ($questions as $question) {
        if ($question['id'] == $questionId) {
            return $question;
        }
    }
}

$totalPoints = 0;

foreach ($_POST as $questionId => $studentAnswer) {
 
    $question = findQuestionById($questionId, $questions);
   
    $correctAnswer = array_search(true, $question['answers']);
    
    $studentAnswerIsCorrect = $correctAnswer == $studentAnswer;

    if ($studentAnswerIsCorrect) {
        $totalPoints++;
    }

   
}

$mark = 0;

$percents = round(($totalPoints / count($questions)) * 100) . '%';

 if ($percents < 50){
    $mark = 2;
 }
 else if  ($percents < 71){
$mark = 3;
 }
  else if  ($percents < 91){
 $mark = 4;
  }
 
  else {$mark = 5;}
  ?>


<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результаты</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
    table tr>*:not(:first-child) {
        white-space: nowrap;
    }
    </style>
</head>

<body class="p-5">
    <div class="container">

        <p style="font-size: 40px;" colspan="2">Результат:</p>
        <p style="font-size: 20px;"><?= $totalPoints ?> из <?= count($questions) ?> вопросов (<?= $percents ?>)</p>
        <p style="font-size: 20px;">Оценка: <?=$mark?></p>

    </div>
</body>

</html>