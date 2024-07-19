@extends('layout')
@section('content')
    <div class="col-lg-8 col-md-8 mx-auto mt-2">
        <form action="{{ route('HomeAdd') }}" method="post" enctype="multipart/form-data">
          <div>
            @csrf
            @error('main')
                <div class="alert">{{ $message }}</div>
            @enderror
            <div class="form-outline form-white mt-3 mb-4">
                <h4>Название</h4><input type="text" id="name" name="name" class="form-control form-control-lg"/>
                @error('name')
                    <div class="alert">{{ $message }}</div>
                @enderror
            </div>

            <h4>Изображение</h4>
            <div>
                <input type="file" id="image" name="image" class="form-control">
                @error('image')
                    <div>{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-4 text-center">
                <button class="btn bg-primary btn-outline-light btn-lg 5"
                    style="max-width: 30%; max-height: 180px; object-fit: cover;" type="submit">Сохранить</button>
            </div>
          </div>
        </form>
    </div>
@endsection
