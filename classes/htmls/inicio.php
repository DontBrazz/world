<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página</title>
</head>
<body>
    <?php
        $teste = new Controller();
        $teste->loadNav();
        echo $teste->getProfile();
    ?>
    <h1>Bem-vindo à Página</h1>
    <p>Este é o conteúdo da página.</p>
</body>
</html>