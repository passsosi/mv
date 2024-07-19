@extends('layout')
@section('content')

<section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card bg-light" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">
              <div class="mb-md-5 mt-md-4 pb-5">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <h2 class="fw-bold mb-2 text-uppercase">Вход</h2>
                    <p class="text-white-50 mb-5">Введите данные</p>

                    <div class="form-outline form-white mb-4">
                        <input type="email" id="email" name="email" class="form-control form-control-lg" />
                        <label class="form-label" for="email">Логин</label>
                        @error('email')
                            <div class="alert">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="form-outline form-white mb-4">
                        <input type="password" id="password" name="password" class="form-control form-control-lg" />
                        <label class="form-label" for="password">Пароль</label>
                        @error('password')
                        <div class="alert">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <button class="btn bg-primary btn-outline-light btn-lg px-5" type="submit">Вход</button>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection