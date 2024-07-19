@extends('layout')
@section('content')
        @foreach($data as $el)
            <div class="col-lg-8 col-md-8 mx-auto mt-2">
              <form action="{{ route('imgUpdate', ['id' => $el->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @error('main')
                    <div class="alert">{{ $message }}</div>
                    @enderror
                <div class="form-outline form-white mt-3 mb-4">
                    <h4>Локация</h4><input type="text" id="location" name="location" class="form-control form-control-lg" value="{{$el->location}}"/>
                    @error('name')
                    <div class="alert">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-outline form-white mb-4">
                    <h4>Автор</h4><input type="text" id="author" name="author" class="form-control form-control-lg" value="{{$el->author}}"/>
                    @error('latn')
                    <div class="alert">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-outline form-white mb-4">
                    <h4>Дата</h4><input type="text" id="date" name="date" class="date form-control form-control-lg" value="{{$el->date}}" placeholder="DD.MM.YYYY"/>
                    @error('latn')
                    <div class="alert">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-3 text-center">
                  <button class="btn bg-primary btn-outline-light btn-lg 5" style="max-width: 30%; max-height: 180px; object-fit: cover;" type="submit">Сохранить</button>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    @endforeach

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.date').inputmask('99.99.9999');
        });
    </script>
@endsection