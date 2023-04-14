<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $product->name }}</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        h1 {
            position: absolute;
            top: 100px;
        }

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
            justify-content: center;
            background-color: #eee;
        }

        .product-form {
            width: 80%;
            max-width: 600px;
            background-color: white;
            border-radius: 4px;
            box-shadow: 0 0 4px 0 #0002;
            overflow: hidden;
        }

        .product-fieldset {
            border: none;
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 20px;
        }

        .product-fieldset label {
            display: grid;
            align-items: center;
            justify-content: space-between;
            grid-template-columns: 35% 65%;

        }

        .product-fieldset label span {
            font-size: 16px;
            font-weight: bold;
        }

        .product-fieldset-input {
            width: 100%;
            border-radius: 4px;
            font-size: 16px;
            padding: 8px;
            border: 1px solid transparent;
            background-color: transparent;
        }

        .product-fieldset-input-active {
            border: 1px solid #3f51b5aa;
            box-shadow: 0 0 4px 0 #0002;
            background-color: #efefef40;
        }

        .product-form-actions {
            text-align: left;
            padding: 20px;
        }

        .product-form-actions input[type=button] {
            width: 80px;
            cursor: pointer;
            font-size: 16px;
            border-width: 1px;
            border-style: solid;
            border-radius: 4px;
            background-color: transparent;
            padding: 4px 8px;
            transition: background .3s;
        }

        .product-form-edit {
            border-color: #3f51b5;
            color: #3f51b5;
        }

        input[type=button].product-form-edit:hover {
            background-color: #3f51b530;
        }

        .product-form-edit-cansel {
            border-color: #E53935;
            color: #E53935;
        }

        input[type=button].product-form-edit-cansel:hover {
            background-color: #E5393530;
        }

        .product-form-edit-save {
            display: none;
            border-color: #43A047;
            color: #43A047;
            margin-left: 20px;
        }

        .product-form-edit-save[disabled],
        .product-form-edit-save[disabled]:hover {
            cursor: unset;
            border-color: #aaa;
            color: #aaa;
            background-color: #eee !important;
        }

        input[type=button].product-form-edit-save:hover {
            background-color: #43A04730;
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
        function toggleEdit() {
            const fieldset = document.querySelector('.product-fieldset');
            const editButton = document.querySelector('.product-form-edit');
            const editSaveButton = document.querySelector('.product-form-edit-save');
            editButton.classList.toggle('product-form-edit-cansel');
            if (fieldset.disabled) {
                editButton.value = 'لغو';
                editSaveButton.style.display = 'unset';
            } else {
                editButton.value = 'ویرایش';
                editSaveButton.style.display = 'none';
            };
            fieldset.toggleAttribute('disabled');
            const fields = document.getElementsByClassName('product-fieldset-input');
            for (i = 0; i < fields.length; i++) fields[i].classList.toggle('product-fieldset-input-active');
        }

        async function editProduct() {
            const editSaveButton = document.querySelector('.product-form-edit-save');
            try {
                editSaveButton.toggleAttribute('disabled');
                const formElements = document.querySelector('form').elements;
                const prices = <?php echo $product->prices; ?>;
                const formData = {
                    name: formElements.name.value,
                    label: formElements.label.value,
                    ...prices
                };
                const response = await (await fetch('/api/product/' + {{ $product->id }}, {
                    method: "PUT",
                    credentials: "same-origin",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(formData),
                })).json();

                if (response.meta.status === 200) {
                    toggleEdit();
                    showToast('محصول با موفقیت ذخیره شد');
                } else throw new Error(response.meta.messages);
            } catch (error) {
                console.error(error.message);
                showToast(error.message, false);
            }
            editSaveButton.toggleAttribute('disabled');
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
        <h1>جزئیات محصول</h1>
        <a href="/admin/products" class="product-back">
            > </a>
        <form class="product-form">
            <fieldset class="product-fieldset" disabled>
                <label><span>نام انگلیسی</span>
                    <div><input class="product-fieldset-input" type="text" name="name"
                            value="{{ $product->name }}" /></div>
                </label>
                <label><span>نام فارسی</span>
                    <div><input class="product-fieldset-input" type="text" name="label"
                            value="{{ $product->label }}" /></div>
                </label>
                @foreach (json_decode($product->prices) as $key => $price)
                    <label><span>{{ $key }}</span>
                        <div><input class="product-fieldset-input" type="text" name="price{{ $key }}"
                                value="{{ $price }}" /></div>
                    </label>
                @endforeach
            </fieldset>
            <div class="product-form-actions">
                <input type="button" class="product-form-edit-save" onclick="editProduct()" value="ذخیره" />
                <input type="button" class="product-form-edit" onclick="toggleEdit()" value="ویرایش" />
            </div>
        </form>
        <span id="toast"></span>
    </div>
</body>

</html>
