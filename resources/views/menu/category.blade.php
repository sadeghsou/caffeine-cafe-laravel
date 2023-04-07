<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $category->label }}</title>
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
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .category__product {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 24px 16px 16px;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .category__product__label {
            font-size: 24px;
            font-weight: bold;
        }

        .category__product__description {
            white-space: nowrap;
            text-overflow: ellipsis;
            width: 90%;
            overflow: hidden;
        }

        .category__product__price {
            position: absolute;
            left: 0;
            top: 0;
            background-color: #eee;
            border-radius: 6px 0;
            padding: 4px;
            color: #333;
        }

        .product {
            position: absolute;
            inset: 0;
            background: #0008;
            display: flex;
            align-items: center;
            justify-content: center
        }

        .product__card {
            background-color: white;
            width: 80%;
            height: 80%;
            border-radius: 8px;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            text-align: center;
        }

        .product__card__label {
            font-size: 32px;
            font-weight: bold;
        }

        .product__card__price {
            font-size: 20px;
        }

        .product__card__description {
            padding: 24px;
            color: #888;
        }
    </style>
    <script>
        function openProduct(product) {
            document.querySelector('.product__card__label').innerHTML = product.label;
            document.querySelector('.product__card__price').innerHTML = product.price.toLocaleString();
            document.querySelector('.product__card__description').innerHTML = product.description;
            document.querySelector('.product').style.zIndex = 10;
        };

        function closeProduct(e) {
            if (e.target.classList[0] !== 'product') return;
            document.querySelector('.product__card__label').innerHTML = '';
            document.querySelector('.product__card__price').innerHTML = '';
            document.querySelector('.product__card__description').innerHTML = '';
            document.querySelector('.product').style.zIndex = -1;
        }
    </script>
</head>

<body>
    <div class="toolbar">
        <a href="/menu/categories"><img src="/assets/images/arrow-left.png" alt="" height="100%" /></a>
    </div>
    <div class="category">
        @foreach ($category->products as $index => $product)
            <div class="category__product" onclick="openProduct({{ $index }})">
                <span class="category__product__label">{{ $product->label }}</span>
                <span class="category__product__description">{{ $product->description }}</span>
                <span class="category__product__price">{{ number_format($product->price) }} تومان</span>
            </div>
        @endforeach
    </div>
    <div class="product" style="z-index:-1" onclick="closeProduct(event)">
        <div class="product__card">
            <div>
                <p class="product__card__label"></p>
                <p class="product__card__price"></p>
                <span>تومان</span>
            </div>
            <p class="product__card__description"></p>
        </div>
    </div>
</body>

</html>
