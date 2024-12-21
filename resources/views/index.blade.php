<!-- resources/views/index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Personalized Books for Kids and Adults | Home</title>
    @vite('resources/css/style.css', 'resources/js/app.js')
</head>
<body>

<?php
    // 指定文件路径
    $file = "./international/index.txt";

    // 初始化语言映射数组，用于将语言代码映射为数组下标
    $language = [
        'en' => 0,  // 英文对应下标 0
        'zh' => 1   // 中文对应下标 1
    ];

    // 声明一个静态数组 $label 用于存储翻译内容
    static $label = array();

    // 逐行读取文件内容，并按逗号分隔
    $lines = file($file);
    foreach ($lines as $line) {
        // 去除行尾的换行符
        $line = trim($line);

        // 将每行内容按逗号分隔成数组
        $parts = explode(",", $line);

        // 将第一个元素作为键，后续元素作为值存入 $label 字典
        if (count($parts) > 1) {
            $key = $parts[0]; // 取出第一个单词作为键
            $label[$key] = array_slice($parts, 1); // 将后续元素存为值数组
        }
    }

    // 从 Cookie 中获取语言代码，如果不存在则默认使用 'en'
    $langCode = $_COOKIE['baseLang'] ?? 'en';
?>

<nav class="navbar">
    <ul class="nav-categories">
        @foreach ($menus as $menu)
            <li class="nav-item">
                <a href="{{ $menu->mlink }}">{{ $menu->mname }}</a>
                @if (!empty($menu->children))
                    <div class="megamenu">
                        @foreach ($menu->children as $child)
                            <div class="menu-column">
                                @if (!empty($child->mname)) <!-- 检查是否有标题 -->
                                    <h4>{{ $child->mname }}</h4>
                                @endif
                                @if (!empty($child->children))
                                    @foreach ($child->children as $subChild)
                                        <a href="{{ $subChild->mlink }}">{{ $subChild->mname }}</a>
                                    @endforeach
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </li>
        @endforeach
    </ul>
</nav>


<!-- 主内容 -->
<div class="content">
    <h1>Welcome to the Bookstore</h1>
    <p>Select a category from the menu to explore our collection of books.</p>
    
    <div class="categories-container">
        <h1>Categories</h1>
        <div class="categories-grid">
            @foreach ($categories as $category)
                <div class="category-card">
                    <img src="{{ $category->image ?? '/images/default.jpg' }}" alt="{{ $category->bcname }}" class="category-image">
                    <h3 class="category-name">{{ $category->bcname }}</h3>
                    <a href="{{ url('/categories?bcid=' . $category->id) }}" class="category-link">Discover More</a>
                </div>
            @endforeach
        </div>
    </div>
</div>





<footer>
    <p>Footer Content</p>
</footer>

</body>
</html>