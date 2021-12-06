<?php
/**
 * Данные с страницы теста приходят сюда
 * в массиве $_POST в формате массива
 * [
 *      "id вопроса" => "ответ который выбрал студент,
 *      "id вопроса" => "ответ который выбрал студент,
 *      "id вопроса" => "ответ который выбрал студент,
 *      ...
 * ]
 */

/**
 * Подключаем исходные ответы что-бы
 * сравнивать ответ ученика с
 * правильным ответом
 */
include './questions.php';


/**
 * Функция которая принимает в себя массив
 * с вопросами, и ищет в нем вопрос по его id
 */
function findQuestionById(string $questionId, array $questions)
{
    foreach ($questions as $question) {
        if ($question['id'] == $questionId) {
            return $question;
        }
    }
}

/**
 * Всего правильных ответов которые набрал ученик
 */
$totalPoints = 0;

/**
 * В эту переменную будут добавляться
 * ряды с данными для html таблицы
 * сделал это что бы сгенерировать html отдельно
 * и не устраивать кашу php и html
 */
$htmlTableRows = '';

/**
 * Проходим массив данных POST и
 */
foreach ($_POST as $questionId => $studentAnswer) {
    /** Ищем вопрос по его id */
    $question = findQuestionById($questionId, $questions);
    /** получаем корректный ответ на этот вопрос */
    $correctAnswer = array_search(true, $question['answers']);
    /**
     * сравниваем ответ студента и правильный ответ из исходных днных,
     * и результат этого сравнения заносим в эту переменную
     */
    $studentAnswerIsCorrect = $correctAnswer == $studentAnswer;

    /** добавляем очки если ответ студента совпадает с правильным */
    if ($studentAnswerIsCorrect) {
        $totalPoints++;
    }

    /**
     * добавляем к рядам таблицы еще один, это по сути строка,
     * называется HEREDOC, этот синтаксис используется когда надо большие строки делать
     * по итогу мы просто добавляем к переменной еще одну строку в которой html ряд таблицы
     * просто строка обычная, тип string
     */
    $htmlTableRows .= <<<ROW
                    <tr>
                        <td>{$question['question']}</td>
                        <td>{$correctAnswer}</td>
                        <td>{$studentAnswer}</td>
                    <tr/>
                ROW;
}

/** дополнительно посчитал проценты, нет необходдимости, для красоты */
$percents = ($totalPoints / count($questions)) * 100 . '%';
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
    </style>
</head>

<body class="p-5">
<div class="container">
    <!--  Во всей этой таблице нет необходимости, её можно убрать и вместо нее просто вывести $totalPoints, или как-то по своему  -->
    <!-- ======================================================================================================================== -->
    <table class="table table-bordered text-secondary">
        <tbody>
        <tr>
            <th>Вопрос</th>
            <th>Правильный ответ</th>
            <th>Ответ ученика</th>
        </tr>
        <!-- Выводим сюда ряды таблицы которые в php собирали -->
        <?= $htmlTableRows ?>
        <tr class="fw-bold">
            <td colspan="2">Итог</td>
            <td><?= $totalPoints ?> / <?= count($questions) ?> вопросов (<?= $percents ?>)</td>
        </tr>
        </tbody>
    </table>
    <div class="p-4">
        <p class="text-muted"><small>* примите во внимание что не на всех устройствах эта функция работает точно, и даже
                случайный клик за пределы области браузера может привести к её срабатыванию</small></p>
    </div>
    <!-- ======================================================================================================================== -->
</div>
</body>

</html>