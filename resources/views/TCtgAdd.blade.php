@extends('layout')
@section('content')

            <div class="col-lg-8 col-md-8 mx-auto mt-2">
              <form action="{{ route('categoryAdd') }}" method="post" enctype="multipart/form-data">
                @csrf
                @error('main')
                    <div class="alert">{{ $message }}</div>
                    @enderror
                <div class="form-outline form-white mt-3 mb-4">
                    <h4>Название</h4><input type="text" id="name" name="name" class="form-control form-control-lg" />
                    @error('name')
                    <div class="alert">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-outline form-white mb-4">
                    <h4>Латинское название</h4><input type="text" id="latName" name="latName" class="form-control form-control-lg" />
                    @error('latn')
                    <div class="alert">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <a class="w-50 dropdown-toggle hidden-arrow btn btn-primary " href="#" id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">Категория<input type="text" id="id_category" name="id_category" class="form-control form-control-dropdown mt-3" readonly placeholder="id категории"/></a>
                    
                    <ul class="col-lg-4 col-md-4 dropdown-menu dropdown-menu-left " aria-labelledby="navbarDropdownMenuLink">
                        <li>
                        <div class="d-flex justify-content-center input-group mt-2 px-2 form-outline">
                            <input type="search" id="form1" class="w-100 form-control-dropdown" />
                        </div>
                        </li>
                        <li><hr class="dropdown-divider"/></li>
                        @foreach ($category as $elCat)
                        <li>
                          <a class="dropdown-item text-truncate" href="#">{{ $elCat->name }}<p>{{ $elCat->id  }}</p></a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="pt-3">
                  <h4 class="mt-3">Имеет подкатегорию?
                  <input type="checkbox" class="form-check-input" id="h4c" name="h4c">
                  </h4>
                </div>

                <h4 class="mt-4">Изображение</h4><div class="mt-3 text-center">
                <div>
                    <input type="file" id="image"  name="image" class="form-control">
                    @error('image')
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