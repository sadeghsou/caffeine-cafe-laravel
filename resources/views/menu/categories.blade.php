<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Category</title>
    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            width: 100vw;
            height: 100vh;
            overflow: hidden;
            margin: 0;
            padding: 0;
            direction: rtl;
        }

        .categories {
            width: 100%;
            height: 100%;
            overflow-y: auto;
            position: relative;
            background-image: url('/assets/images/bg-main.png');
            background-size: 100% 100%;
        }

        .categories-bg {
            width: 50%;
            max-width: 300px;
            position: absolute;
            right: 0;
            bottom: 0;
        }

        .categories__content {
            position: absolute;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            column-gap: 40px;
            padding: 20px;
        }

        .categories__content__item {
            height: 200px;
            text-decoration: none;
            color: #eee;
            text-align: center;
            display: flex;
            flex-direction: column;
        }

        .categories__content__item:nth-child(even) {
            padding-top: 80px;
        }

        .categories__content__item--label {}

        .categories__content__item--image {
            width: 100%;
            height: 80%;
            object-fit: contain;
        }
    </style>
</head>

<body>
    <div class="categories">
        <img class="categories-bg" src="/assets/images/bg-corner-right.png" alt="" />
        <div class="categories__content">
            @foreach ($categories as $index => $category)
                <a class="categories__content__item" href="categories/{{ $category->name }}">
                    <img class="categories__content__item--image" src="{{ $category->image }}"
                        alt="{{ $category->name }}" />
                    <span class="categories__content__item--label">{{ $category->label }}</span>
                </a>
            @endforeach
        </div>
    </div>
</body>

</html>
