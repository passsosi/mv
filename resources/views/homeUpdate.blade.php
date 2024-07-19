@extends('layout')
@section('content')
    @php
    $el = $data->first();
    @endphp
            <div class="col-lg-8 col-md-8 mx-auto mt-2">
              <form action="{{ route('HomeUpdate', ['id' => $data->id]) }}" method="post" enctype="multipart/form-data">
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

                <h4 class="mt-3">Изображение</h4><div class="mt-3 text-center">
                  
                <div>
                      <div style="position: relative; display: inline-block; width: 90%; height: 680px; overflow: hidden;">
                        <img src="data:image/jpeg;base64, {{ base64_encode($data->image) }}" alt="..." class="img-thumbnail" style="width: 100%; height: 100%; object-fit: cover;">
                      </div>
                    <input type="file" id="image" name="image" class="form-control">
                    @error('image')
                    <div class="alert">{{ $message }}</div>
                    <div class="alert alert-success">
                      {{ Session::get('status') }}
                    </div>
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

@endsection