<!-- resources/views/categories.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Personalized Books for Kids and Adults | Categories</title>
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

<div class="content-container">
    @if ($pagepics->isNotEmpty())
        <div class="carousel-wrapper">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    @foreach ($pagepics as $index => $pagepic)
                        <li data-target="#carouselExampleIndicators" data-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></li>
                    @endforeach
                </ol>

                <!-- Carousel Items -->
                <div class="carousel-inner">
                    @foreach ($pagepics as $index => $pagepic)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img class="d-block w-100" src="{{ asset($pagepic->pagepic) }}" alt="Page {{ $pagepic->pagenum }}">
                        </div>
                    @endforeach
                </div>

                <!-- Previous and Next Controls -->
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    @else
        <p>No images available for this book.</p>
    @endif


    <!-- 右侧书籍详情 -->
    <div class="book-details">
        <h1>{{ $book->bookname }}</h1>
        <p>Category: {{ $book->pid == 0 ? 'Top Level' : 'Subcategory' }}</p>
        <p>Target Audience: 
            @if ($book->gender == 0)
                Unspecified
            @elseif ($book->gender == 1)
                Boys
            @elseif ($book->gender == 2)
                Girls
            @endif
        </p>
        <p>Language: {{ $book->language }}</p>
        <p>Introduction: {{ $book->intro ?? 'No introduction available.' }}</p>
        <p>Description: {{ $book->description ?? 'No description available.' }}</p>
        <p>Price: {{ $book->pricesymbol }}{{ $book->price }} ({{ $book->currencycode }})</p>
        <p>Rating: {{ $book->rating }}/5</p>

        <div class="form-group">
            <label for="language">Select Language:</label>
            <select id="language" name="language" class="form-control">
                <option value="en" {{ $book->language == 'en' ? 'selected' : '' }}>English</option>
                <!-- Add more languages here -->
            </select>
        </div>

        <!-- Language -->
        <a id="personalize-link" href="/personalize?bookid={{ $book->id }}&language={{ $book->language }}" class="personalize-button">Personalize My Book</a>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const languageDropdown = document.getElementById("language");
                const personalizeLink = document.getElementById("personalize-link");

                languageDropdown.addEventListener("change", function() {
                    const selectedLanguage = languageDropdown.value;
                    personalizeLink.href = `/personalize?bookid={{ $book->id }}&language=` + selectedLanguage;
                });
            });
        </script>
    </div>
</div>




<footer>
    <p>Footer Content</p>
</footer>

</body>
</html>

