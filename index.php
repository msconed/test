<?php require __DIR__."/tests.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tests</title>
</head>
<body>
    <div>
        <h5 style="font-size:30px;">Массивы</h5>
        <p style="font-size:20px;"> <?php interVolgaTests::arrayTest() ?>  </p> 
    </div>

    <hr>
    <div>
        <h5 style="font-size:30px;">Комментарии</h5>
        <p style="font-size:20px;"> <?php interVolgaTests::getComments() ?>  </p> 
    </div>
    <form action="/add-new-comment.php" method="POST">
        <input name="new_comment" type="text" placeholder="Текст...">
        <input name="_token" hidden value="<?php echo $_SESSION['_token'] ?>">
        <button>Отправить</button>
    </form>


    <hr>
    <div>
        <h5 style="font-size:30px;">Новость</h5>
        <p style="font-size:20px;"> <?php interVolgaTests::news() ?>  </p> 
    </div>


    <hr>
    <div>
        <h5 style="font-size:30px;">Семья</h5>
        <p style="font-size:20px;"> <?php echo interVolgaTests::family(rand(1,10), rand(1,10)) ?>  </p> 
    </div>
</body>
</html>