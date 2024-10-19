@php use Illuminate\Support\Facades\Auth; @endphp
<div id="Navbar">
    <nav class="navbar navbar-expand-lg  bg-body-tertiary  bg-dark  navbar-dark  text-white">
        <div class="container-fluid  container">
            <a class="navbar-brand" href="{{route('MainPage')}}">ProfSkill</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('MainPage')}}">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('CoursesPageCommon')}}">Курсы</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('WebinarsPageCommon')}}">Вебинары</a>
                    </li>
                    @auth()
                        @if(Auth::user() && Auth::user()->role === 'admin')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                   aria-expanded="false">Админ-панель</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{route('CategoryPage')}}">Категории</a></li>
                                    <li><a class="dropdown-item" href="{{route('ThemePage')}}">Тематика</a></li>
                                    <li><a class="dropdown-item" href="{{route('SpeakerPage')}}">Спикеры</a></li>
                                    <li><a class="dropdown-item" href="{{route('CoursePage')}}">Курсы</a></li>
                                    <li><a class="dropdown-item" href="{{route('WebinarsPage')}}">Вебинары</a></li>
                                    <li><a class="dropdown-item" href="{{route('OrdersPage')}}">Заказы</a></li>
                                </ul>
                            </li>
                        @endif
                    @endauth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                 fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                <path fill-rule="evenodd"
                                      d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                            </svg>
                        </a>
                        <ul class="dropdown-menu">
                            @guest()
                                <li><a class="dropdown-item" href="{{route('RegistrationPage')}}">Регистрация</a></li>
                                <li><a class="dropdown-item" href="{{route('login')}}">Авторизация</a></li>
                            @endguest
                            @auth()
                                    <li><a class="dropdown-item" href="{{route('PersonalAccountPage')}}">Личный кабинет</a></li>
                                    <li><a class="dropdown-item" href="{{route('MyOrderPage')}}">Мои заказы</a></li>
                                <li><a class="dropdown-item" href="{{route('Exit')}}">Выход</a></li>
                            @endauth
                        </ul>
                    </li>
                </ul>
{{--                <form class="d-flex" @submit.prevent="ShowResults()">--}}
{{--                    <input class="form-control me-2" type="text" placeholder="Введите текст запроса" id="search"--}}
{{--                           name="search">--}}
{{--                    <button class="btn btn-outline-primary" type="submit">Найти</button>--}}
{{--                </form>--}}
            </div>
        </div>
    </nav>
</div>

{{--<script>--}}
{{--    const NavFunctions = {--}}
{{--        data() {--}}
{{--            return {--}}
{{--                search: ''--}}
{{--            }--}}
{{--        },--}}
{{--        methods: {--}}
{{--            ShowResults() {--}}
{{--                sessionStorage.setItem('search', document.getElementById('search').value);--}}
{{--                if (sessionStorage.getItem('search') == '') {--}}
{{--                    this.RedirectCatalog();--}}
{{--                } else {--}}
{{--                    this.RedirectResults();--}}
{{--                }--}}
{{--            },--}}
{{--            async RedirectResults() {--}}
{{--                const response = await fetch('{{route('ResultsPage')}}');--}}
{{--                window.location = response.url;--}}
{{--            },--}}
{{--            async RedirectCatalog() {--}}
{{--                const response = await fetch('{{route('CatalogPage')}}');--}}
{{--                window.location = response.url;--}}
{{--            }--}}
{{--        },--}}
{{--        mounted() {--}}
{{--            var page = document.location.href;--}}

{{--            if (page == 'http://jewelry/results') {--}}
{{--                document.getElementById('search').value = sessionStorage.getItem('search');--}}
{{--            }--}}
{{--        }--}}
{{--    }--}}
{{--    Vue.createApp(NavFunctions).mount('#Navbar');--}}
</script>
