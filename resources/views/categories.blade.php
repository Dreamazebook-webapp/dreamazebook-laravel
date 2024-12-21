<!-- resources/views/categories.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Personalized Books for Kids and Adults | Categories</title>
    @vite('resources/css/style.css', 'resources/js/app.js')
</head>
<body>

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

<div class="category-container">
    <h1 class="category-title">Books in Category</h1>

    @if (count($booklist) > 0)
        <div class="book-grid">
            @foreach ($booklist as $book)
                <!-- 包裹 book-card 的链接 -->
                <a href="{{ route('books.show', ['id' => $book->id]) }}">             
                    <div class="book-card">
                        <div class="book-image" style="background-image: url('/imgs/web/baby.png');"></div>
                        <div class="book-details">
                            <h2 class="book-name">{{ $book->pname }}</h2>
                            <p class="book-category">{{ $book->bcname }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <p class="no-books-message">No books found in this category.</p>
    @endif
</div>


<footer>
    <p>Footer Content</p>
</footer>

</body>
</html>

