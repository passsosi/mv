@extends('layout')
@section('content')

  <div class="album bg-body-tertiary">

    <div class="container py-5">
      <h1 class="text-center">{{$category[0]->name}} – {{$category[0]->LatName}}</h1>
      <form action="{{ route('3Order') }}" method="post">
        @csrf
      <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 g-3 mt-2">
        @foreach ($data as $el)

        <div class="col">
          <div class="card shadow-sm">
              <a href="#" onclick="redirect({{$el->id}})"><img src="data:image/jpeg;base64,{{ base64_encode($el->image) }}" class="img-fluid w-100 card-img-top" style="max-width: 100%; max-height: 375px; object-fit: cover;" alt="Image"></a>
            <div class="card-body">
              <h2>{{$el->name}}<br/>{{$el->latName}}</h2>
              <div class="d-flex justify-content-between align-items-center mt-3">
                  <button type="button" class="btn btn-md btn-block btn-outline-secondary" 
                  onclick="redirect({{$el->id}})">Подробнее</button>
                  <div class="order {{Auth::check() ? '' : 'd-none' }}">
                      <input type="hidden" name="id[{{$el->id}}]" value="{{$el->id}}">
                      <input type="number" class="btn btn-sm btn-outline-secondary" placeholder="Номер" name="order[{{$el->id}}]" value="{{$el->view_order}}" min="0" max="9999">
                  </div>
                  <div>
                    <button type="button" class="btn btn-md btn-block btn-outline-secondary {{Auth::check() ? '' : 'd-none' }}" 
                    onclick="update({{$el->id}})"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                    <button type="button" class="btn btn-md btn-block btn-outline-secondary {{Auth::check() ? '' : 'd-none' }}" 
                    onclick="categoryDel({{$el->id}})"><i class="fa fa-trash" aria-hidden="true"></i></button>
                  </div>
              </div>
            </div>
          </div>
        </div>

        <script>
          function redirect(categoryId) 
          {
            window.location.href = "{{ route('list', ':categoryId') }}".replace(':categoryId', categoryId);
          }
          function update(categoryId) 
          {
            window.location.href = "{{ route('categoryUpdateView', ':categoryId') }}".replace(':categoryId', categoryId);
          }
          function categoryDel(categoryId) 
          {
            window.location.href = "{{ route('categoryDelete', ':categoryId') }}".replace(':categoryId', categoryId);
          }
        </script>

        @endforeach

        <div class="col">
          <div class="card {{Auth::check() ? '' : 'd-none' }}">
            <button type="button" class="btn btn-md btn-block btn-outline-secondary"  onclick="add({{$category[0]->id}})">Добавить</button>
            <script>
              function add(categoryId) 
              {
                window.location.href = "{{ route('categoryAddView', ':categoryId') }}".replace(':categoryId', categoryId);
              }
            </script>
        </div>
      </div>
      <button type="submit" class="btn btn-sm btn-block btn-outline-secondary {{Auth::check() ? '' : 'd-none' }}">Изменить порядковые номера</button>
      </form>
    </div>
  </div>

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

