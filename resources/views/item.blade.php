@extends('layout')
@section('content')
    @php
        $i = 0;
    @endphp
    @foreach ($data as $el)
        <div class="img-view" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999; background-color:rgba(0, 0, 0, 0.5); width: 100%; height: 100%; display: none;"> 
            <img src="data:image/jpeg;base64,{{ base64_encode($images[0]->image) }}" alt="..." class="img-view mt-2" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999;">
            <script>
                document.querySelector(".img-view").addEventListener("click", function(e) {
                if (e.target === this) {
                    this.style.display = "none";
                }
                });
            </script>
        </div>
            <div class="col-lg-8 col-md-8 mx-auto mt-2">
                <div class="text-center mt-5">
                    <h1 class="">{{$cat[0]->name}} – {{$cat[0]->latName}}</h1>
                    <h1 class="fw-bold">{{$el->name}} – {{$el->latName}}</h1>
                    <div class="target-form">
                        
                        <img src="data:image/jpeg;base64,{{ base64_encode($images[0]->image) }}" alt="..." class="img-fluid mt-2" style="min-height: auto; max-height: 670px; object-fit: cover;">
                        <div>
                            <p class="text-center fs-4" data-location="{{$images[0]->location}}">{{$images[0]->location}}</p>
                            <p class="text-center fs-4" data-date="{{$images[0]->date}}">{{$images[0]->date}}</p>
                            <p class="text-center fs-4" data-author="{{$images[0]->author}}">{{$images[0]->author}}</p>
                        </div>
                    </div>
                </div>
                <script>
                        document.querySelector("img.img-fluid").addEventListener("click", function() {
                        document.querySelector("div.img-view").style.display = "block";
                        document.querySelector("div.img-view img").setAttribute("src", imageSrc);
                    });
                </script>
                <div class="mt-3 text-center">
                    <div class="item-images">
                    @foreach ($images as $el)
                        <button type="button" onclick="imgUpdateView({{$el->id}})" style="border: none; background: none; font-size: 28px; color: rgb(63, 63, 63); {{Auth::check() ? '' : 'd-none' }}">
                            <i class="fa-regular fa-pen-to-square {{Auth::check() ? '' : 'd-none' }}"></i>
                        </button>
                        <img src="data:image/jpeg;base64,{{ base64_encode($el->image) }}" alt="..." class="img-thumbnail" data-image="{{ base64_encode($el->image) }}" data-location="{{$el->location}}" data-date="{{$el->date}}" data-author="{{$el->author}}">
                        <script>
                            function imgUpdateView(categoryId) {
                                window.location.href = "{{ route('imgUpdateView', ':categoryId') }}".replace(':categoryId', categoryId);
                            }
                        </script>
                    @endforeach
                    </div>
                </div>
                @php
                $el = $data->first();
                @endphp

                <div class="text-justify fs-3 mt-3">
                    <p class="text-justify px-5" style="word-wrap: break-word; white-space: pre-line;" >{{ $el->description }}</p>
                </div>



                @if($documents->isNotEmpty())
                    <div class="fw-bold text-center fs-3 mt-3">
                        <p>Дополнительные материалы</p>
                    </div>
                @endif
                <div class="text-center">
                    <ul>
                    @foreach ($documents as $elDoc)
                        <li>
                            <a href="{{ route('get-pdf', ['id' => $elDoc->id]) }}" class="docs text-decoration-none text-center" download>{{$elDoc->name}}</a>
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
            @php
                $i = $el->id_item;
            @endphp

    @endforeach

    <script>
        var photos = document.querySelectorAll('.img-thumbnail');
        var targetForm = document.querySelector('.target-form');
        var selectedPhotoContainer = document.querySelector('.target-form img');
        var selectedPhotoContainer2 = document.querySelector('.img-view img');
        var locationElement = targetForm.querySelector('p[data-location]');
        var dateElement = targetForm.querySelector('p[data-date]');
        var authorElement = targetForm.querySelector('p[data-author]');
    
        photos.forEach(function(photo) {
            photo.addEventListener('click', function() {
                photos.forEach(function(photo) {
                    photo.classList.remove('selected-photo');
                });
    
                this.classList.add('selected-photo');
    
                var image = this.dataset.image;
                var location = this.dataset.location;
                var date = this.dataset.date;
                var author = this.dataset.author;
    
                selectedPhotoContainer.src = 'data:image/jpeg;base64,' + image;
                selectedPhotoContainer2.src = 'data:image/jpeg;base64,' + image;
                locationElement.textContent = location;
                dateElement.textContent = date;
                authorElement.textContent = author;
            });
        });
    </script>
    <style>
        .docs {
            font-size: 24px;
            color: rgb(0, 0, 0);
            transition: 0.2s ease;
        }
        .docs:hover {
            color: rgb(83, 83, 83);
        }
    </style>
@endsection