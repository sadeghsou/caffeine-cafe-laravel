<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>دسته بندی‌ها</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .categories {
            width: 100%;
            height: 100%;
            overflow-y: auto;
            position: relative;
            background-image: url('/assets/images/bg-main.png');
            background-size: 100% 100%;
            display: grid;
            /* grid-template-rows: 100px 1fr 100px; */
            grid-template-rows: 1fr 7fr 2fr;
            padding-bottom: 20px;
        }

        .categories-bg {
            position: absolute;
            right: 0;
            bottom: 0;
            width: 240px;
        }

        .categories-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 20px;
        }

        .categories-top-logo {
            height: 32px;
        }

        .categories-top-arrow {
            height: 24px;
        }

        .categories-top-arrow img {
            height: 100%;
        }

        .categories-section {
            overflow-y: auto;
        }

        .categories-section-content {
            height: 100%;
            display: grid;
            grid-template: repeat(2, 1fr) / repeat(2, 1fr);
            padding-inline: 20px;
        }

        .categories-section-content-category:nth-child(even) {
            align-self: flex-end;
        }

        .categories-section-content-category {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            color: white;
            text-decoration: none;
            text-align: center;
        }

        .categories-section-content-category-img {
            width: 75%;
            max-width: 180px;
        }

        .categories-section-content-category-label {}

        .categories-bottom {
            display: flex;
            justify-content: center;
            z-index: 1;
            padding-block: 20px
        }

        .categories-bottom a {
            height: 24px;
            display: block;
        }

        .categories-bottom a img {
            height: 100%;
        }
    </style>
</head>

<body>
    <div class="categories">
        <img class="categories-bg" src="/assets/images/bg-corner-right.png" alt="">
        <div class="categories-top">
            <img class="categories-top-logo" src="/assets/images/icon.png" alt="" />
            <a class="categories-top-arrow" href="/menu"><img src="/assets/images/arrow-left.png"
                    alt="" /></a>
        </div>
        <div class="categories-section">
            @for ($row = 0; $row < ceil(count($categories) / 4); $row++)
                <div id="section-{{ $row + 1 }}" class="categories-section-content">
                    @for ($i = 0; $i < 4; $i++)
                        <a class="categories-section-content-category"
                            href="/menu/categories/{{ $categories[$row * 4 + $i]->name }}">
                            <img class="categories-section-content-category-img"
                                src="{{ url('') . '/storage\/' . $categories[$row * 4 + $i]->image }}"
                                alt="{{ $categories[$row * 4 + $i]->name }}">
                            <span
                                class="categories-section-content-category-label">{{ $categories[$row * 4 + $i]->label }}</span>
                        </a>
                    @endfor
                </div>
            @endfor
        </div>
        <div class="categories-bottom">
            <a id="next-section-link" onclick="nextSection()" href="#section-2"><img
                    src="/assets/images/arrow-bottom.png" alt=""></a>
        </div>
    </div>
    <script>
        var currentSection = 1;

        function nextSection() {
            var isEnd = currentSection === {{ ceil(count($categories) / 4) }};
            if (isEnd) currentSection = 1;
            else currentSection++;
            document.querySelector('#next-section-link').href = `#section-${currentSection}`;
        }
    </script>
</body>

</html>
