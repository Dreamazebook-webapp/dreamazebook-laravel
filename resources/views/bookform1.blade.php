<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Personalized Books for Kids | Basic Information</title>
    @vite('resources/css/style.css', 'resources/js/app.js')
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#photo").on("change", function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $("#uploaded-preview").attr("src", e.target.result).show();
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
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
                                @if (!empty($child->mname))
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
    <div class="row">
        <!-- Sidebar Navigation -->
        <div class="col-md-3">
            <div class="steps">
                <ul class="list-group">
                    <li class="list-group-item active">Basic information</li>
                    <li class="list-group-item">Character</li>
                    <li class="list-group-item">Cover design</li>
                    <li class="list-group-item">Dedication</li>
                    <li class="list-group-item">Get your book!</li>
                </ul>
            </div>
        </div>

        <!-- Form Content -->
        <div class="col-md-9">
            <div class="form-header">
                @if ($pagepics->isNotEmpty())
                    <img src="{{ asset($pagepics->first()->pagepic) }}" alt="First Image">
                @else
                    <p>No images available</p> <!-- Debugging -->
                @endif
                <p class="text-center">We will redesign the character in your image</p>
            </div>


            <form action="{{ route('personalize.save') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Hidden Inputs for Book ID and Language -->
                <input type="hidden" name="bookid" value="{{ $bookid }}">
                <input type="hidden" name="language" value="{{ $language }}">

                <div class="form-row">
                    <!-- First Name -->
                    <div class="form-group col-md-6">
                        <label for="first_name">First Name (也可以是称呼):</label>
                        <input type="text" id="first_name" name="first_name" class="form-control" maxlength="30" placeholder="please enter..." required>
                    </div>

                    <!-- Last Name -->
                    <div class="form-group col-md-6">
                        <label for="last_name">Last Name:</label>
                        <input type="text" id="last_name" name="last_name" class="form-control" maxlength="30" placeholder="please enter...">
                    </div>
                </div>

                <!-- Gender -->
                <div class="form-group">
                    <label>Gender:</label>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="gender_boy" name="gender" value="1" class="form-check-input" required>
                        <label for="gender_boy" class="form-check-label">Boy</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="gender_girl" name="gender" value="2" class="form-check-input" required>
                        <label for="gender_girl" class="form-check-label">Girl</label>
                    </div>
                </div>

                <!-- Skin Color -->
                <div class="form-group">
                    <label>Skin Color:</label>
                    <div class="skin-colors">
                        <input type="radio" id="skin_light" name="skin_color" value="0" class="form-check-input" required>
                        <label for="skin_light" class="skin-color" style="background-color: #f3d9ca;"> </label>

                        <input type="radio" id="skin_medium" name="skin_color" value="1" class="form-check-input" required>
                        <label for="skin_medium" class="skin-color" style="background-color: #d9a37c;"> </label>

                        <input type="radio" id="skin_dark" name="skin_color" value="2" class="form-check-input" required>
                        <label for="skin_dark" class="skin-color" style="background-color: #6b4a3a;"> </label>
                    </div>
                    <div id="skin-color-error" class="text-danger" style="display: none;">Please select a skin color.</div>
                </div>

                

                <!-- Photo Upload -->
                <div class="form-group">
                    <label for="photo">Photo:</label>
                    <div class="custom-file">
                        <input type="file" id="photo" name="photo" class="custom-file-input" accept="image/*" required>
                        <label class="custom-file-label" for="photo">Drag & drop or browse files</label>
                    </div>
                    <small class="form-text text-muted">
                        - Make sure the subject is facing the camera.<br>
                        - Use a close-up photo.<br>
                        - The higher the quality, the better the result!
                    </small>
                    <img id="uploaded-preview" class="uploaded-photo" style="display: none; max-width: 200px; margin-top: 10px; border: 1px solid #ddd; border-radius: 5px;" />
                </div>

                <!-- Navigation Buttons -->
                <div class="form-group d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary">Back to the product page</button>
                    <button id="submit-button" type="submit" class="btn btn-primary">Next</button>
                </div>
            </form>
        </div>
    </div>
</div>

<footer class="text-center mt-4">
    <p>Footer Content</p>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        const skinColors = document.querySelectorAll('input[name="skin_color"]');
        const photoInput = document.getElementById('photo');
        const skinColorError = document.getElementById('skin-color-error');
        const photoPreview = document.getElementById('uploaded-preview');

        form.addEventListener('submit', function (event) {
            let isSkinSelected = false;
            let isPhotoValid = true;

            // Check if a skin color is selected
            skinColors.forEach((radio) => {
                if (radio.checked) {
                    isSkinSelected = true;
                }
            });

            // Display error if no skin color is selected
            if (!isSkinSelected) {
                skinColorError.style.display = 'block';
                event.preventDefault();
            } else {
                skinColorError.style.display = 'none';
            }

            // Check if the photo is valid
            const file = photoInput.files[0];
            if (!file) {
                alert('Please upload a photo.');
                isPhotoValid = false;
                event.preventDefault();
            } else {
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                const maxFileSize = 2 * 1024 * 1024; // 2MB

                if (!allowedTypes.includes(file.type)) {
                    alert('Please upload a valid image file (JPEG, PNG, or GIF).');
                    isPhotoValid = false;
                    event.preventDefault();
                }

                if (file.size > maxFileSize) {
                    alert('File size exceeds 2MB. Please upload a smaller file.');
                    isPhotoValid = false;
                    event.preventDefault();
                }
            }

            return isSkinSelected && isPhotoValid;
        });

        // Display preview of the uploaded image
        photoInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    photoPreview.src = e.target.result;
                    photoPreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    });

</script>
</body>
</html>
