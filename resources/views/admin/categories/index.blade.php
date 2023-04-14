<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>دسته بندی ها</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .categories {
            height: 100%;
            background-color: #eee;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 24px;
            padding: 16px 16px 80px;
        }

        .categories-card {
            background-color: white;
            box-shadow: 0 0 4px 0 #0002;
            border-radius: 4px;
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .categories-card-label {
            font-size: 22px;
            font-weight: bold;
        }

        .categories-card-price {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            flex-direction: column;
        }

        .categories-card-price p {
            font-size: 18px;
            direction: ltr
        }

        .categories-card-price p span:first-child {
            font-weight: bold;
            margin-right: 12px;
        }

        .categories-card-actions {
            display: flex;
            gap: 16px;
        }

        .categories-card-actions button {
            flex: 1;
            font-size: 16px;
            border-radius: 4px;
            border-width: 2px;
            border-style: solid;
            box-shadow: 0 0 4px 0 #0002;
            padding-block: 8px;
            background-color: white;
        }

        .categories-card-actions button:first-child {
            border-color: #3f51b5;
            color: #3f51b5;
        }

        .categories-card-actions button:last-child {
            border-color: #E53935;
            color: #E53935;
        }

        .categories-add {
            position: fixed;
            left: 20px;
            bottom: 20px;
            background-color: #3f51b5;
            color: white;
            border-radius: 50%;
            font-size: 50px;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="categories">
        @foreach ($categories as $product)
            <div class="categories-card">
                <p class="categories-card-label">{{ $product->label }}</p>
                {{-- <div class="categories-card-price">
                    @foreach (json_decode($product->prices) as $key => $price)
                        <p><span>{{ $key }}:</span><span>تومان {{ number_format($price) }}</span></p>
                    @endforeach
                </div> --}}
                <div class="categories-card-actions">
                    <button>ویرایش</button>
                    <button>حذف</button>
                </div>
            </div>
        @endforeach
        <a class="categories-add" href="/admin/categories/add">+</a>
    </div>
</body>

</html>
