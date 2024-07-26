@extends('layout')
@section('content')

  <div class="navbar">
    <div class="col-lg-8 col-md-8 mx-auto mt-3">
        <div class="input-group">
          <input type="search" class="form-control rounded" placeholder="Поиск" aria-label="Search" aria-describedby="search-addon" />
        </div>
    </div>
  </div>

<div class="album bg-body-tertiary">
    
    <div class="container">
      <h1 class="text-center pt-3 mt-1">{{$category[0]->name}} – {{$category[0]->latName}}</h1>
      <div class="row row-cols-1 row-cols-sm-1 row-cols-md-3 g-3 mt-2">
        @php
          $i = 0;
        @endphp
        @foreach ($data as $el)
              <div class="col">
                <div class="card shadow-sm">
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
                        <h5 class="text-truncate">{{$el->name}}<br/>{{$el->latName}}</h5>
                          <div class="d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-md btn-block btn-outline-secondary mt-2" 
                            onclick="redirect({{$el->id}})">Подробнее</button>
                            <div>
                              <button type="button" class="btn btn-md btn-block btn-outline-secondary mt-2 {{Auth::check() ? '' : 'd-none' }}" 
                              onclick="update({{$el->id}})"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                              <button type="button" class="btn btn-md btn-block btn-outline-secondary mt-2 {{Auth::check() ? '' : 'd-none' }}" 
                              onclick="itemDel({{$el->id}})"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            </div> 
                          </div>
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
        
        <div class="">
          <div class="card {{Auth::check() ? '' : 'd-none' }}">
            <button type="button" class="btn btn-md btn-block btn-outline-secondary"  onclick="add({{$category[0]->id}})">Добавить</button>
            
            <script>
              function add(categoryId) {
                  window.location.href = "{{ route('add', ':categoryId') }}".replace(':categoryId', categoryId);
              }
            </script>
        </div>

    </div>
</div>

<script>
  var searchInput = document.querySelector('input[aria-label="Search"]');
  var cards = document.querySelectorAll('.col');

  searchInput.addEventListener('input', () => {
    var filter = searchInput.value.toLowerCase();

    cards.forEach((card) => {
      var name = card.querySelector('h5.text-truncate').textContent.toLowerCase();
      var latName = card.querySelector('h5.text-truncate:last-of-type').textContent.toLowerCase();

      if (name.includes(filter) || latName.includes(filter)) {
        card.hidden = false;
        console.log(name);
      } else {
        card.hidden = true;
        console.log(latName);
      }
    });
  });
</script>

@if(Session::has('status'))

    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Ошибка</h5>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        {{ Session::get('status') }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
  @endif

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    $(document).ready(function() {
        $('#statusModal').modal('show');
    });
  </script>
  <script>
    $('#closeModal').click(function () {
        $('#statusModal').modal('hide');
    });
  </script>
  
@endsection