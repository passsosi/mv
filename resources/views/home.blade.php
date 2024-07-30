@extends('layout')
@section('content')


<?php 
  $imageData = $content->Image; // Байтовая строка с изображением
  $imageType = "image/png"; // Замените на тип вашего изображения
  // Преобразуем байтовую строку в base64
  $base64Image = 'data:' . $imageType . ';base64,' . base64_encode($imageData);
?>
  <div class="row" width="100%" style="background-image: url(<?php echo $base64Image; ?>); background-size: cover; background-repeat: no-repeat; height: 500px;">
    <div class="col-lg-8 col-md-8 mx-auto py-4">
      <div>
          <h2 class="fw-light text-center mt-5 fw-bold text-light">Виртуальный атлас</h2>
          <h2 class="fw-light text-center fw-bold text-light pb-5">«Природа Забайкалья»</h2> 
      </div>

      <form action="{{ route('HomeIMGUpdate', ['id' => $content->id]) }}" method="post" enctype="multipart/form-data" >
        @csrf
        <div  class="text-center mt-5 pt-5 {{Auth::check() ? '' : 'd-none' }}">
          <button type="submit" class="mt-5 btn btn-md btn-block btn-outline-light fw-bold">Сменить картинку</button>
          <div>
          <input type="file" id="image"  name="image" class="form-control mt-3" style="max-width: 100%;">
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="album bg-body-tertiary">
    <div class="container py-5">
      <form action="{{ route('HomeDescUpdate', ['id' => $content->id]) }}" method="post" enctype="multipart/form-data" >
        @csrf
        <textarea type="text" id="desc" name="desc" class="mb-3 form-control form-control-lg {{Auth::check() ? '' : 'd-none' }}" rows="1">{{$content->Description}}</textarea>
        <button type="submit" class="mb-3 btn btn-md btn-block btn-outline-secondary {{Auth::check() ? '' : 'd-none' }}">Обновить текст</button>
      </form>

      <p class="lead fw-bold text-center px-3"> 
        {{$content->Description}}
      </p>
      <form action="{{ route('HomeOrder') }}" method="post">
        @csrf
      <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 g-3 mt-5">
        @foreach ($data as $el)

        <div class="col">
          <div class="card shadow-sm">
              <a href="#" onclick="redirect({{$el->id}})"><img src="data:image/jpeg;base64,{{ base64_encode($el->image) }}" class="img-fluid w-100 card-img-top" style="max-width: 100%; min-height: auto; max-height: 400px; object-fit: cover;" alt="Image"></a>
            <div class="card-body">
              <h2>{{$el->name}}</h2>
              <div class="d-flex justify-content-between align-items-center mt-3">
                  <button type="button" class="btn btn-md btn-block btn-outline-secondary" 
                  onclick="redirect({{$el->id}})">Подробнее</button>
                  
                  <div class="order {{Auth::check() ? '' : 'd-none' }}">
                      <input type="hidden" name="id[{{$el->id}}]" value="{{$el->id}}">
                      <input type="number" class="btn btn-sm btn-outline-secondary" placeholder="Порядковый номер" name="order[{{$el->id}}]" value="{{$el->view_order}}" min="0" max="9999">
                  </div>
                  <div>
                    <button type="button" class="editBtn btn btn-md btn-block btn-outline-secondary {{Auth::check() ? '' : 'd-none' }}" 
                    onclick="update({{$el->id}})"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                    <button type="button" class="delBtn btn btn-md btn-block btn-outline-secondary {{Auth::check() ? '' : 'd-none' }}" 
                    onclick="categoryDel({{$el->id}})"><i class="fa fa-trash" aria-hidden="true"></i></button>
                  </div>
              </div>
            </div>
          </div>
        </div>

        <script>
          function redirect(categoryId) {
              window.location.href = "{{ route('2c', ':categoryId') }}".replace(':categoryId', categoryId);
          }
          function update(categoryId) 
          {
            window.location.href = "{{ route('HomeUpdateView', ':categoryId') }}".replace(':categoryId', categoryId);
          }
          function categoryDel(categoryId) 
          {
            window.location.href = "{{ route('HomeDelete', ':categoryId') }}".replace(':categoryId', categoryId);
          }
        </script>

        @endforeach

        <div class="col">
          <div class="card {{Auth::check() ? '' : 'd-none' }}">
            <button type="button" class="btn btn-md btn-block btn-outline-secondary"  onclick="add()">Добавить</button>
            
            <script>
              function add() 
              {
                window.location.href = "{{ route('HomeAddView') }}" ;
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

