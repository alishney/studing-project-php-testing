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

$totalPoints   = 0;
$htmlTableRows = '';

foreach ($_POST as $questionId => $studentAnswer) {
    $question = findQuestionById($questionId, $questions);
    if ( ! $question) {
        continue;
    }
    $correctAnswer        = array_search(true, $question['answers']);
    $studentAnswerCorrect = $correctAnswer == $studentAnswer;

    if ($studentAnswerCorrect) {
        $totalPoints++;
    }

    $rowColor = $studentAnswerCorrect ? 'table-success' : 'table-danger';

    $htmlTableRows .= <<<ROW
                    <tr>
                        <td>{$question['question']}</td>
                        <td>{$correctAnswer}</td>
                        <td class="{$rowColor}">{$studentAnswer}</td>
                    <tr/>
                ROW;
}

$percents   = ($totalPoints / count($questions)) * 100 . '%';
$qrCodeData = urlencode('Результат ученика: ' . $percents);
$dataUrl    = 'data:image/jpg;base64,' . base64_encode(
        file_get_contents(
            "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={$qrCodeData}"
        )
    );
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
        table tr > *:not(:first-child) {
            white-space: nowrap;
        }

        .qr-code {
            opacity: .7;
            border: 1px solid lightgray;
            padding: .8rem;
        }
    </style>
</head>

<body class="p-5">
<div class="container">
    <div>
        <img class="float-end mb-4 qr-code" src="<?= $dataUrl ?>" alt='Ошибка генерации QR кода проверки'/>
    </div>
    <table class="table table-bordered text-secondary">
        <tbody>
        <tr>
            <th>Вопрос</th>
            <th>Правильный ответ</th>
            <th>Ответ ученика</th>
        </tr>
        <?= $htmlTableRows ?>
        <tr class="fw-bold">
            <td colspan="2">Итог</td>
            <td><?= $totalPoints ?> / <?= count($questions) ?> вопросов (<?= $percents ?>)</td>
        </tr>
        <tr class="fw-bold">
            <td colspan="2">Сколько раз пользователь покидал страницу *</td>
            <td><?= $_POST['pageLeavesCount'] ?></td>
        </tr>
        </tbody>
    </table>
    <div class="p-4">
        <p class="text-muted"><small>* примите во внимание что не на всех устройствах эта функция работает точно, и даже
                случайный клик за пределы области браузера может привести к её срабатыванию</small></p>
    </div>
</div>
</body>

</html>