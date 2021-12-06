<?php
include './questions.php'
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тест</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
    label.form-check-label {
        cursor: pointer;
    }

    body {
        padding: 5rem 6rem;
    }

    p {
        color: #2e30c7;
    }

    h1 {
        text-align: center;
        margin-top: -40px;
        margin-bottom: 40px;
        color: #2e30c7;
    }

    .button {
        background-color: #2e30c7;
        border-radius: 5rem;
    }
    </style>
</head>

<body>
    <!--  Генерируем форму на основании массива questions  -->
    <h1>Тест по инженерной графике</h1>
    <form action="results_page.php" method="POST">
        <?php foreach ($questions as $index => $question) { ?>
        <div>
            <?php if (isset($question['img'])) { ?>
            <img src="<?= $question['img'] ?>" class="border" style="max-width: 400px;"
                 alt="изображение <?= $question['img'] ?> не загрузилось" />
            <?php } ?>

            <p class="mt-4 fw-bold fs-4">Вопрос №<?= $index + 1 ?> - <?= $question['question'] ?></p>
            <div class="answers ps-5">
                <?php foreach ($question['answers'] as $answer => $correct) { ?>
                <div class="form-check form-check-inline">
                    <label class="form-check-label form-control-lg fs-5">
                        <input class="form-check-input" type="radio" value="<?= $answer ?>"
                               name="<?= $question['id'] ?>" checked>
                        <?= $answer ?>
                    </label>
                </div>
                <?php } ?>
            </div>
            <hr>
        </div>
        <?php } ?>
        <div style="text-align: center;">
            <button class="btn btn-primary button px-5 py-2" type="submit">Отправить</button>
        </div>
    </form>
</body>

</html>