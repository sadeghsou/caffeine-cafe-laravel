<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Menu</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .menu {
            width: 100%;
            height: 100%;
            background-image: url('/assets/images/bg-1.png');
            background-size: 100% 100%;
        }

        .menu-bg-cover {
            width: 100%;
            height: 100%;
            position: absolute;
            z-index: 1;
        }

        .menu-bg {
            width: 100%;
            height: 100%;
            position: absolute;
            z-index: 2;
        }

        .menu__content {
            width: 100%;
            max-width: 300px;
            position: absolute;
            z-index: 3;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .menu__content-img {
            width: 100%;
            margin-bottom: 80px;
        }

        .menu__content-link {
            color: white;
            font-size: 24px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="menu">
        <img class="menu-bg-cover" src="/assets/images/bg-cover.png" alt="">
        <img class="menu-bg" src="/assets/images/bg-corners.png" alt="">
        <div class="menu__content">
            <img class="menu__content-img" src="/assets/images/menu-img.png" alt="Caffeine Cafe">
            <a class="menu__content-link" href="/menu/categories">مشاهده منو</a>
        </div>
    </div>
</body>

</html>
