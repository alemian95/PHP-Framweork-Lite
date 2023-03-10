<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? "Document" ?></title>

    <link rel="stylesheet" href="<?= mix('/css/main.css') ?>">
    <script src="<?= mix('/js/main.js') ?>"></script>
</head>
<body>
    <?php require_once __DIR__ . "/../$content.php"; ?>
</body>
</html>