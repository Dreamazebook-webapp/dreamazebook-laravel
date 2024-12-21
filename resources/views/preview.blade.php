<!-- resources/views/preview.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Preview Book</title>
    @vite('resources/css/style.css', 'resources/js/app.js')
    <!-- 引入 Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- 引入 Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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

<div class="container">
    <h1>{{ $childBook->bookname }}</h1>
    <p>{{ $childBook->intro }}</p>
    <p>{{ $childBook->description }}</p>

    <!-- Carousel for Page Pictures -->
    @if ($pagepics->isNotEmpty())
        <div id="bookCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @foreach ($pagepics as $index => $pagepic)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ asset($pagepic->pagepic) }}" class="d-block w-100" alt="Page {{ $pagepic->pagenum }}">
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#bookCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#bookCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    @else
        <p>No pages available for this book.</p>
    @endif
</div>




<footer>
    <p>Footer Content</p>
</footer>

</body>
</html>

