<?php require __DIR__."/tests.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tests</title>
    <style>
table, th, td {
  border:1px solid black;
  padding: 5px;
}
</style>

</head>
<body>
    <div>
        <h1 style="font-size:30px;">Массивы</h1>
        <?php interVolgaTests::arrayTest(); ?>   
    </div>

    <hr>
    <div>
        <h2 style="font-size:30px;">Комментарии</h2>
        <p style="font-size:20px;"> <?php interVolgaTests::getComments() ?>  </p> 
    
    <form action="/add-new-comment.php" method="POST">
        <input name="new_comment" type="text" placeholder="Текст...">
        <input name="_token" hidden value="<?php echo $_SESSION['_token'] ?>">
        <button>Отправить</button>
    </form>
    </div>

    <hr>
    <div>
        <h3 style="font-size:30px;">Новость</h3>
        <p style="font-size:20px;"> <?php interVolgaTests::news() ?>  </p> 
    </div>


    <hr>
    <div>
        <h4 style="font-size:30px;">Семья</h4>
        <p style="font-size:20px;"> <?php echo interVolgaTests::family(rand(1,10), rand(1,10)) ?>  </p> 
    </div>
</body>
</html>