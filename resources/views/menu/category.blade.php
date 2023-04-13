<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $category->label }}</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            width: 100vw;
            height: 100vh;
            background-image: url('/assets/images/bg-main.png');
            background-size: 100% 100%;
            overflow: hidden;
            margin: 0;
            padding: 0;
            direction: rtl;
            color: #eee;
        }

        .toolbar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            height: 56px;
            padding-inline: 12px;
        }

        .toolbar a {
            height: 40px;
            display: block;
            width: 32px;
            padding: 8px;
        }

        .category {
            width: 100%;
            height: calc(100% - 56px);
            overflow-y: auto;
            padding: 20px;
        }

        .category__product {
            border: 1px solid #eee;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            position: relative;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .category__product__label {
            font-size: 24px;
            font-weight: bold;
            padding: 20px;
        }

        .category__product__description {
            white-space: nowrap;
            text-overflow: ellipsis;
            width: 90%;
            overflow: hidden;
            padding: 20px;
        }

        .category__product__price {
            border-radius: 0 0 4px 4px;
        }

        .category__product__price p {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 8px;
            margin: 0;
            direction: ltr
        }

        .category__product__price p span:first-child {
            margin-right: 12px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="toolbar">
        <a href="/menu/categories"><img src="/assets/images/arrow-left.png" alt="" height="100%" /></a>
    </div>
    <div class="category">
        @foreach ($category->products as $index => $product)
            <div class="category__product" onclick="openProduct({{ $index }})">
                <span class="category__product__label">{{ $product->label }}</span>
                @if (!is_null($product->description))
                    <span class="category__product__description">{{ $product->description }}</span>
                @endif
                <div class="category__product__price">
                    @foreach (json_decode($product->prices) as $key => $price)
                        <p><span>{{ $key }}: </span><span>{{ number_format($price) }} تومان</span>
                        </p>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</body>

</html>
