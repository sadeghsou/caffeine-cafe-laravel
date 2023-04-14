<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100vw;
            height: 100vh;
            text-align: center;
            background-color: #efefef;
        }

        h1 {
            position: absolute;
            top: 40px;
            color: #3F51B5;
        }

        form {
            width: 80%;
            height: 250px;
            max-width: 400px;
            background-color: white;
            display: flex;
            flex-direction: column;
            padding: 20px;
            align-items: center;
            justify-content: space-evenly;
            border-radius: 8px;
        }

        form input {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #3F51B5;
            height: 40px;
            box-shadow: 0 0 4px 0 #0002;
        }

        button {
            width: 100%;
            padding: 8px 16px;
            font-size: 16px;
            background-color: #3F51B5;
            border: none;
            border-radius: 4px;
            color: #efefef;
        }
    </style>
</head>

<body>
    <h1>ورود به پنل</h1>
    <form method="POST" action="/login">
        @csrf
        <input type="text" name="username" placeholder="نام یا موبایل">
        <input type="text" name="password" placeholder="رمزعبور">
        <button type="submit">ورود</button>
    </form>
</body>

</html>
