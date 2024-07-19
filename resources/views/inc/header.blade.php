@section('header')

    <header class="navbar navbar-expand-md" style="background-color: rgb(0,90,140);">
        <a href="#" onclick="history.back();" class="text-white m-3 text-decoration-none"><h2>Назад</h2></a>
        <div class="container">
            <div class="row">
                <div class="col-md-1">
                    <a href="\">
                    <img height="103" src="/images/iconA.png">
                    </a>
                </div>
                <div class="col-md-5 py-3">
                    <ul class="list-unstyled text-small">
                        <li>
                            <div class="text-white ">Федеральное государственное бюджетное учреждение науки Институт
                                природных ресурсов, экологии и криологии Сибирского отделения Российской академии наук</div>
                        </li>
                    </ul>
                </div>

                <div class="col-md-2 py-4">
                    <ul class="list-unstyled text-small">
                        <li>
                            <div class=" text-decoration-none  text-white ">Email:</div>
                        </li>
                        <li>
                            <div class=" text-decoration-none  text-white ">inrec.sbras@mail.ru</div>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3 py-5">
                    <a class="text-decoration-none" style="color: rgb(0,90,140);" href="https://www.youtube.com/@user-pz3bq5pg9z" target="_blank"><i class="fa-brands fa-youtube bbg"></i></a>
                    <a class="text-decoration-none" style="color: rgb(0,90,140);" href="https://vk.com/club148508426" target="_blank"><i class="fa-brands fa-vk bbg"></i></a>
                </div>
                <div class="col-md-1 py-5">
                    <a class="link-secondary text-decoration-none  text-white" href="{{ route('search') }}">ПОИСК <i class="fa-solid fa-magnifying-glass text-white"></i></a>
                </div>
            </div>
        </div>
    </header>
