@extends('layout')
@section('content')
    <div class="navbar">
        <div class="col-lg-8 col-md-8 mx-auto mt-3">
            <div class="">
                <div class="input-group">
                    <input type="search" id="input-label" class="form-control rounded"
                        placeholder="Начните писать название вида" aria-label="Search" aria-describedby="search-addon" />
                    <div class="search-dropdown">
                        <a class="dropdown-toggle hidden-arrow btn btn-primary" style="min-width: 230px;" href="#"
                            id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                            Категория
                        </a>

                        <ul class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdownMenuLink">
                            <li>
                                <div class="input-group mt-2">
                                    <div class="d-flex justify-content-center input-group mt-2 px-2 form-outline">
                                        <input type="search" class="w-100 form-control-dropdown" />
                                    </div>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            @php
                                $c = -1;
                            @endphp
                            @foreach ($cat as $el)
                                <li data-category-name1="{{ $el->name }}"
                                    data-category-lat-name1="{{ $el->latName }}">
                                    <a class="dropdown-item text-truncate" style="max-width: 300px;" href="{{ isset($el->id_SecondCategory) ? '/list/' : '/list4/' }}{{ $el->id }}">
                                        {{ $el->name }}<br/>
                                        {{ $el->latName }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <script>
                        const input = document.querySelector('.form-control-dropdown');
                        const items = document.querySelectorAll('.dropdown-item');

                        input.addEventListener('input', function() {
                            const searchTerm = input.value.toLowerCase();

                            items.forEach(item => {
                                const text = item.textContent.toLowerCase();

                                if (text.includes(searchTerm)) {
                                    item.style.display = 'block';
                                } else {
                                    item.style.display = 'none';
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#navbarDropdownMenuLink').click(function() {
            $('.dropdown-menu').toggleClass('show');
        });

        // $('.dropdown-item').click(function() {
        //     var categoryName = $(this).data('category-name1');
        //     var categoryLatName = $(this).data('category-lat-name1');
        //     // Действия при выборе категории
        // });
    </script>

    <div id="items-list"></div>
    <div class="album bg-body-tertiary" id="searchResults">
        {{-- Отображение из поиска --}}
    </div>
    <div id="items-list"></div>



    @if (Session::has('status'))
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

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#statusModal').modal('show');
        });
    </script>

    <script>
        $('#closeModal').click(function() {
            $('#statusModal').modal('hide');
        });
    </script>

    <script>
        var itemList = $('#items-list');
        $(document).ready(function() {
            $('#input-label').on('input', function() {
                var searchQuery = $(this).val();
                $.ajax({
                    url: '/search-items',
                    type: 'POST',
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'search': searchQuery
                    },
                    success: function(data) {
                        // Плавное исчезновение
                        itemList.fadeOut('fast', function() {
                            // Обновление содержимого
                            $(this).html(data);
                            // Плавное появление
                            $(this).fadeIn('fast');
                        });
                    }
                });
            });
        });
    </script>
@endsection
