<div class="container">
    <div class="row row-cols-1 row-cols-sm-1 row-cols-md-3 g-3 mt-3">
      @php
              $i = 0;
            @endphp
            @foreach ($search_data as $el)

                  <div class="col">
                    <div class="card shadow-sm" data-category-name="{{ $el->name }}" data-category-lat-name="{{ $el->latName }}">
                      @php
                        $firstImageFound = false;
                      @endphp

                      @foreach($images as $img)
                        @if(!$firstImageFound && $img->id_item === $el->id)
                          @php
                            $firstImageFound = true;
                          @endphp
                          <img src="data:image/jpeg;base64,{{ base64_encode($img->image) }}" class="img-fluid w-100 card-img-top" style="max-width: 100%; max-height: 300px; object-fit: cover;" alt="Image">
                        @endif
                      @endforeach
                    
                          <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                              <h5 class="text-truncate">{{$el->name}}<br/>{{$el->latName}}</h5>
                            </div>
                            <button type="button" class="btn btn-md btn-block btn-outline-secondary mt-2" 
                            onclick="redirect({{$el->id}})">Подробнее</button>
                            
                            <button type="button" class="btn btn-md btn-block btn-outline-secondary mt-2 {{Auth::check() ? '' : 'd-none' }}" 
                            onclick="update({{$el->id}})">Редактировать</button>
                            <button type="button" class="btn btn-md btn-block btn-outline-secondary mt-2 {{Auth::check() ? '' : 'd-none' }}" 
                            onclick="itemDel({{$el->id}})">Удалить</button>
                        </div>
                      </div>
                  </div>

                  <script>
                    function redirect(categoryId) {
                        window.location.href = "{{ route('item', ':categoryId') }}".replace(':categoryId', categoryId);
                    }
                    function update(categoryId) {
                        window.location.href = "{{ route('update', ':categoryId') }}".replace(':categoryId', categoryId);
                    }
                    function itemDel(categoryId) {
                        window.location.href = "{{ route('delete', ':categoryId') }}".replace(':categoryId', categoryId);
                    }
                  </script>
                  @php
                    $i = $el->id_item;
                  @endphp

            @endforeach
    </div>
  </div>