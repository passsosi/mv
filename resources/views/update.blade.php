@extends('layout')
@section('content')
    @php
    $el = $data->first();
    @endphp
            <div class="col-lg-8 col-md-8 mx-auto mt-2">
              <form action="{{ route('itemUpload', ['id_item' => $data->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @error('main')
                    <div class="alert">{{ $message }}</div>
                    @enderror
                <div class="form-outline form-white mt-3 mb-4">
                    <h4>Название</h4><input type="text" id="name" name="name" class="form-control form-control-lg" value="{{$data->name}}"/>
                    @error('name')
                    <div class="alert">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-outline form-white mb-4">
                    <h4>Латинское название</h4><input type="text" id="latName" name="latName" class="form-control form-control-lg" value="{{$data->latName}}"/>
                    @error('latn')
                    <div class="alert">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-outline form-white mb-4">
                    <h4>Описание</h4><textarea type="text" id="desc" name="desc" class="form-control form-control-lg" style="height:350px;">{{$data->description}}</textarea>
                    @error('desc')
                    <div class="alert">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    @foreach ($itemCategory as $elICat)
                    <a class="w-50 dropdown-toggle hidden-arrow btn btn-primary " href="#" id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">Категория<input type="text" id="id_category" name="id_category" class="form-control form-control-dropdown mt-3" readonly placeholder="Категория" value="{{$elICat->name}}" /></a>
                    @endforeach
                    <ul class="col-lg-4 col-md-4 dropdown-menu dropdown-menu-left " aria-labelledby="navbarDropdownMenuLink">
                        <li>
                        <div class="d-flex justify-content-center input-group mt-2 px-2 form-outline">
                          <input type="search" id="form1" class="w-100 form-control-dropdown"/>
                        </div>
                        </li>
                        <li><hr class="dropdown-divider"/></li>
                        @foreach ($category as $elCat)
                        <li>
                          <a class="dropdown-item text-truncate" href="#"><p>{{ $elCat->name }}</p></a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                

                <h4 class="mt-3">Изображения</h4><div class="mt-3 text-center">
                  
                <div>
                  @foreach ($images as $elImg)
                      <div style="position: relative; display: inline-block; width: 24%; height: 180px; overflow: hidden;">
                        <img src="data:image/jpeg;base64, {{ base64_encode($elImg->image) }}" alt="..." class="img-thumbnail" style="width: 100%; height: 100%; object-fit: cover;">
                        <button type="button" onclick="imgDelete({{$elImg->id}})" style="position: absolute; top: 3px; right: 10px; border: none; background: none; font-size: 28px; color: white;">
                          <i class="fa-solid fa-xmark"></i>
                        </button>
                      </div>

                      <script>
                        function imgDelete(categoryId) {
                            window.location.href = "{{ route('imgDel', ':categoryId') }}".replace(':categoryId', categoryId);
                        }
                      </script>
                    @endforeach
                    <input type="file" id="image" multiple name="image[]" class="form-control">
                    @error('image')
                    <div class="alert">{{ $message }}</div>
                    <div class="alert alert-success">
                      {{ Session::get('status') }}
                    </div>
                    @enderror
                    
                  </div>
                </div>

                <h4 class="mt-3">Документы</h4>
                
                <div>
                  @foreach ($documents as $elDoc)
                  <a href="{{ route('get-pdf', ['id' => $elDoc->id]) }}" class="docs text-decoration-none px-2" download>{{ $elDoc->name }}</a>
                  <button type="button" onclick="docsDelete({{$elDoc->id}})" style=" margin-left: -15px; border: none; background: none; font-size: 16px;"><i class="fa-regular fa-circle-xmark"></i></button>
                  <script>
                    function docsDelete(categoryId) {
                        window.location.href = "{{ route('docsDel', ':categoryId') }}".replace(':categoryId', categoryId);
                    }
                  </script>
                  @endforeach
                  <div class="mt-3 text-center">
                    <input type="file" id="file" multiple name="file[]" class="form-control">
                    @error('doc')
                      <div class="alert">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="mt-3 text-center">
                  <button class="btn bg-primary btn-outline-light btn-lg 5" style="max-width: 30%; max-height: 180px; object-fit: cover;" type="submit">Сохранить</button>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>

      <script>
        const searchInputDropdown = document.getElementById('form1');
        const dropdownOptions = document.querySelectorAll('.dropdown-item');
        const selectedItemInput = document.getElementById('id_category');
        const dropdownToggle = document.getElementById('navbarDropdownMenuLink');
        const dropdownMenu = document.querySelector('.dropdown-menu');

        searchInputDropdown.addEventListener('input', () => {
          const filter = searchInputDropdown.value.toLowerCase();
          showOptions();
          const valueExist = !!filter.length;

          if (valueExist) {
            dropdownOptions.forEach((el) => {
              const elText = el.textContent.trim().toLowerCase();
              const isIncluded = elText.includes(filter);
              if (!isIncluded) {
                el.style.display = 'none';
              }
            });
          }
        });

        dropdownOptions.forEach((option) => {
          option.addEventListener('click', (event) => {
            const selectedId = event.target.querySelector('p').textContent;
            selectedItemInput.value = selectedId;
            dropdownMenu.classList.remove('show');
          });
        });

        const showOptions = () => {
          dropdownOptions.forEach((el) => {
            el.style.display = 'block';
          });
        };

        dropdownToggle.addEventListener('click', () => {
          dropdownMenu.classList.toggle('show');
        });

        document.addEventListener('click', (event) => {
          if (!event.target.closest('.dropdown-menu') && !dropdownToggle.contains(event.target)) {
            dropdownMenu.classList.remove('show');
          }
        });
      </script>
@endsection