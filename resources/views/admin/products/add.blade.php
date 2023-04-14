<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>افزودن محصول جدید</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .product-back {
            position: absolute;
            left: 20px;
            top: 20px;
            text-decoration: none;
            color: #333;
            font-size: 32px;
            border: 1px solid #333;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: space-around;
            background-color: #eee;
            flex-direction: column;
        }

        .product-form {
            width: 80%;
            max-width: 600px;
            background-color: white;
            border-radius: 4px;
            box-shadow: 0 0 4px 0 #0002;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 20px;
        }

        .product-form label {
            display: flex;
            align-items: center;
            justify-content: space-between;

        }

        .product-form label span {
            font-size: 18px;
            font-weight: bold;
        }

        .product-form-input {
            border-radius: 4px;
            font-size: 16px;
            padding: 8px;
            border: none;
            background-color: #efefef40;
            border: 1px solid #3f51b5aa;
            box-shadow: 0 0 4px 0 #0002;
        }


        .product-form-actions {
            text-align: left;
            padding: 20px;
        }

        .product-form-add {
            width: 80px;
            cursor: pointer;
            font-size: 16px;
            border: 1px solid #43A047;
            color: #43A047;
            border-width: 1px;
            border-style: solid;
            border-radius: 4px;
            background-color: transparent;
            padding: 4px 8px;
            transition: background .3s;
            align-self: flex-end;
        }

        .product-form-add:hover {
            background-color: #43A04730;
        }

        .product-form-add[disabled],
        .product-form-add[disabled]:hover {
            cursor: unset;
            border-color: #aaa;
            color: #aaa;
            background-color: #eee !important;
        }

        #toast {
            opacity: 0;
            position: absolute;
            top: 20px;
            padding: 4px 32px;
            color: white;
            border-radius: 4px;
            transition: opacity .2s;
        }

        .toast-success {
            background-color: #43A047;
        }

        .toast-error {
            background-color: #E53935;
        }
    </style>
    <script>
        async function createProduct() {
            const button = document.querySelector('.product-form-add');
            try {
                button.toggleAttribute('disabled');
                const formElements = document.querySelector('form').elements;
                const prices = {
                    "70/30": formElements['70/30'].value,
                    "spiecial": formElements.spiecial.value
                };
                if (Object.values(prices).some(price => !price)) {
                    showToast('قیمت‌ها را بدرستی وارد نمایید', false);
                    button.toggleAttribute('disabled');
                    return;
                }
                const formData = {
                    name: formElements.name.value,
                    label: formElements.label.value,
                    category: formElements.category.value,
                    prices: JSON.stringify(prices)
                };
                const response = await (await fetch('/api/product/', {
                    method: "POST",
                    credentials: "same-origin",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(formData),
                })).json();

                if (response.meta.status === 201) {
                    showToast('محصول با موفقیت ذخیره شد');
                    location.replace('/admin/products');

                } else throw new Error(typeof response.meta.messages === 'object' ? 'مقادیر را بدرستی وارد نمایید' :
                    response.meta.messages);

            } catch (error) {
                console.error(error.message);
                showToast(error.message, false);
            }
            button.toggleAttribute('disabled');
        }

        function showToast(message, success = true) {
            const toast = document.getElementById('toast');
            toast.innerHTML = message;
            toast.className = `toast-${success?'success':'error'}`;
            toast.style.opacity = 1;
            setTimeout(() => {
                toast.style.opacity = 0;
            }, 3000);
        }
    </script>
</head>

<body>
    <div class="product">
        <h1>افزودن محصول</h1>
        <a href="/admin/products" class="product-back">
            > </a>
        <form class="product-form">
            <label><span>نام انگلیسی</span><input class="product-form-input" type="text" name="name" /></label>
            <label><span>نام فارسی</span><input class="product-form-input" type="text" name="label" /></label>
            <select class="product-form-input" name="category" value="">
                <option value="" disabled selected>دسته بندی</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">
                        <span>{{ $category->label }}</span>
                    </option>
                @endforeach
            </select>
            <hr>
            <legend>قیمت‌ها</legend>
            <label><span>70/30</span><input class="product-form-input" type="text" name="70/30" /></label>
            <label><span>spiecial</span><input class="product-form-input" type="text" name="spiecial" /></label>
            <hr>
            <button type="button" onclick="createProduct()" class="product-form-add">ذخیره</button>
        </form>
    </div>
    <span id="toast"></span>
</body>

</html>
