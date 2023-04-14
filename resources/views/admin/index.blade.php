<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>داشبورد</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .admin {
            height: 100vh;
            background-color: #eee;
            display: flex;
            align-items: center;
            flex-direction: column;
            justify-content: space-around;
        }

        .admin a {

            text-decoration: none;
            box-shadow: 0 0 4px 0 #0002;
            border-radius: 4px;
        }

        .admin-links {}

        .admin-links a {
            background-color: white;
            color: #3f51b5;
            border: 1px solid #3f51b5;
            font-size: 20px;
            padding: 20px 32px;
        }

        .admin-links-products {}

        .admin-logout {
            color: white;
            background-color: #E53935;
            font-size: 16px;
            padding: 8px 16px;
        }
    </style>
</head>

<body>
    <div class="admin">
        <div class="admin-links">
            <a class="admin-links-products" href="/admin/products">محصولات</a>
        </div>
        <a class="admin-logout" href="/logout">خروج</a>
    </div>
</body>

</html>
