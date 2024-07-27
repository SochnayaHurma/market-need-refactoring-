<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not found</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
        .wrap {
            width: 1000px;
            margin: 0 auto;
        }
        .logo {
            width: 430px;
            position: absolute;
            top: 25%;
            left: 35%;
        }
        p, a {
            color: #eee;
            font-size: 13px;
            margin-left: 30px;
            padding: 5px;
            background: #FF3366;
            text-decoration: none;
            -webkit-border-radius: .3em;
            -moz-border-radius: .3em;
            border-radius: .3em;
        }
        p a:hover {
            color: #fff;
        }
        .footer {
            position: absolute;
            bottom: 18px;
            right: 10px;
            font-size: 12px;
            color: #aaa;
        }
        .footer a {
            color: #666;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class=logo>
            <img src="/errors/images/404.png" alt="" />
            <p><a href="<?=PATH;?>">Go back to home</a></p>
        </div>
    </div>
    <div class="footer">
        Design by huesosi ebanie
    </div>
</body>
</html>