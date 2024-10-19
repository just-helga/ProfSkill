@extends('layout.app')
@section('title')
    Курсы
@endsection
@section('content')
    <div id="CoursesFunctions">
        <!-- Основное контент -->
        <div class="container">
            <div class="row  mt-5  col-12  text-center"><h2>Курсы</h2></div>
            <div class="row  mt-5">
                <div class="mb-5  col-12  col-md-4  col-xl-3">
                    <label for="sorted">Сортировать</label>
                    <div class="col-12  mb-2">
                        <select class="form-select" name="" id="sorted" v-model="sorted">
                            <option value="created_at">Сначала новые</option>
                            <option value="cheap">Сначала дешевые</option>
                            <option value="expensive">Сначала дорогие</option>
                            <option value="title">По названию</option>
                        </select>
                    </div>
                    <label for="">Выбрать фильтры</label>
                    <div class="col-12  mb-2">
                        <select class="form-select" name="" id="" v-model="category_id">
                            <option value="0">Все категории</option>
                            <option v-for="category in categories" :value="category.id"> @{{ category.title }} </option>
                        </select>
                    </div>
                    <div class="col-12  mb-2">
                        <select class="form-select" name="" id="" v-model="theme_id">
                            <option value="0">Все темы</option>
                            <option v-for="theme in themes" :value="theme.id"> @{{ theme.title }} </option>
                        </select>
                    </div>
                    <div class="col-12" style="display: flex; align-items: center; justify-content: space-between; flex-direction: row">
                        <input type="number" class="form-control" placeholder="от" style="width: 47%" id='price_min' v-model="price_min">
                        <input type="number" class="form-control" placeholder="до" style="width: 47%" id='price_max' v-model="price_max">
                    </div>
                </div>
                <div class="col-12  col-md-8  col-xl-9">
                    <div v-if="FilterCourses.length > 0">
                        <div class="row">
                            <div v-for="course in FilterCourses" class="col-12  col-sm-6  col-md-6  col-xl-6">
                                <div class="card  product-card" @click="RenderModalShow(course.id)" data-bs-toggle="modal" data-bs-target="#ShowModal" style="margin-bottom: 24px;">
                                    <div style="height: 200px; overflow: hidden">
                                        <img :src="course.preview" class="card-img-top  product-card__img" :alt="course.title" style="height: 100%; object-fit: cover">
                                    </div>
                                    <div class="card-body" style="display: flex; align-items: flex-start; justify-content: space-between; flex-direction: column">
                                        <h5 class="card-title" style="width: 100%; min-height: 48px; margin-bottom: 8px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; text-align: start"> @{{course.title}} </h5>
                                        @auth()
                                            <div style="width: 100%; display: flex; align-items: center; justify-content: space-between; flex-direction: row">
                                                <p class="card-text" style="font-weight: bold; margin: 0; margin-right: 20px;"> @{{course.price}} ₽ </p>
                                                <button type="submit" class="btn  btn-primary" @click="Buy(course.id)" style="width: 50%; z-index: 100">Купить</button>
                                            </div>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p v-else style="font-size: 24px">К сожалению, подходящих курсов не найдено</p>
                </div>
            </div>
        </div>

        <!-- Модальное окно просмотра -->
        <div class="modal  fade" id="ShowModal" tabindex="-1" aria-labelledby="ShowModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ShowModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body" id="ShowModalBody" style="display: flex; flex-direction: column; justify-content: start; align-items: center">
                        <div class="col-12" :class="message ? 'mb-3  alert  alert-secondary  text-center' : ''">@{{ message }}</div>
                        <div style="display: flex; flex-direction: column; align-items: start; justify-content: space-between; width: 100%;">
                            <div id="ShowModalImg" style="width: 100%"></div>
                            <div style="width: 100%">
                                <p style="display: flex; align-items: flex-start; justify-content: space-between; border-bottom: 1px solid #dee2e6"><span>Категория</span><span id="ShowModalCategory"></span></p>
                                <p style="display: flex; align-items: flex-start; justify-content: space-between; border-bottom: 1px solid #dee2e6; margin-top: 10px"><span>Тема</span><span id="ShowModalTheme"></span></p>
                            </div>
                        </div>
                        <div style="width: 100%;">
                            <p style="font-size: 18px; font-weight: bold">Описание</p>
                            <p id="ShowModalDescription"></p>
                            <p style="display: flex; align-items: flex-start; justify-content: start; margin-top: 10px; font-weight: bold; font-size: 18px">Цена: &nbsp;<span id="ShowModalPrice" style=""></span></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .product-card {
            cursor: pointer;
        }
        .product-card__img {
            transition: .3s;
        }
        .product-card:hover .product-card__img {
            transform: scale(1.03);
        }
    </style>

    <script>
        function equalHeight(group) {
            var tallest = 0;
            group.each(function() {
                thisHeight = $(this).height();
                if(thisHeight > tallest) {
                    tallest = thisHeight;
                }
            });
            group.height(tallest);
        }
        $(document).ready(function(){
            equalHeight($(".card"));
        });
    </script>

    <script>
        const CoursesFunctions = {
            data() {
                return {
                    courses: [],
                    categories: [],
                    themes: [],

                    category_id: 0,
                    theme_id: 0,


                    sorted: 'created_at',

                    price_min: 0,
                    price_max: 0,

                    message: ''
                }
            },
            methods: {
                //---Получение курсов
                async GetCourse() {
                    const response = await fetch('{{route('CourseGet')}}');
                    const data = await response.json();
                    this.courses = data.all;
                    this.GetMaxAndMinPrice();
                },
                //---Получение категорий
                async GetCategories() {
                    const response = await fetch('{{route('CategoryGet')}}');
                    const data = await response.json();
                    this.categories = data.all;
                },
                //---Получение тем
                async GetThemes() {
                    const response = await fetch('{{route('ThemeGet')}}');
                    const data = await response.json();
                    this.themes = data.all;
                },
                //---Отрисовка модального окна просмотра
                RenderModalShow(id) {
                    var title = this.courses.find(course => course.id === id).title;
                    document.getElementById('ShowModalLabel').innerText = title;
                    var img = this.courses.find(course => course.id === id).preview;
                    document.getElementById('ShowModalImg').innerHTML = "<img src='" + img + "' alt='" + title + "' style='width: 100%; height: auto; object-fit: cover'>";
                    document.getElementById('ShowModalCategory').innerText = this.categories.find(category => category.id === (this.courses.find(course => course.id === id).category_id)).title;
                    document.getElementById('ShowModalPrice').innerText = this.courses.find(course => course.id === id).price + ' ₽';
                    document.getElementById('ShowModalDescription').innerText = this.courses.find(course => course.id === id).description;
                    document.getElementById('ShowModalTheme').innerText = this.themes.find(theme => theme.id === (this.courses.find(course => course.id === id).theme_id)).title;
                },
                //---Добавление товара в корзину
                async Buy(id) {
                    const response = await fetch('{{route('Buy')}}', {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id:id
                        })
                    });
                    if (response.status === 200) {
                        this.message = await response.json();
                        setTimeout(()=>{this.message = null}, 20000);
                    }
                    if (response.status === 400) {
                        this.message = await response.json();
                        setTimeout(()=>{this.message = null}, 20000);
                    }
                },
                //---Получение максимальной и минимальной цены
                GetMaxAndMinPrice() {
                    let reserve = [];
                    for (course of this.courses) {
                        reserve.push(Number(course.price));
                    }
                    this.price_max = Math.max.apply(null, reserve);
                    this.price_min = Math.min.apply(null, reserve);
                    reserve = [];
                }
            },
            computed: {
                FilterCourses() {
                    return this.courses
                        .filter(course => {
                            return this.category_id == 0 || course.category_id == this.category_id;
                        })
                        .filter(course => {
                            return this.theme_id == 0 || course.theme_id == this.theme_id;
                        })
                        .filter(course => {
                            return Number(course.price) >= this.price_min && Number(course.price) <= this.price_max;
                        })
                        .sort((a, b) => {
                            if (this.sorted === 'expensive') {
                                if (a['price'] > b['price']) return -1
                                if (a['price'] < b['price']) return 1
                                if (a['price'] = b['price']) return 0
                            }
                            if (this.sorted === 'cheap') {
                                if (a['price'] > b['price']) return 1
                                if (a['price'] < b['price']) return -1
                                if (a['price'] = b['price']) return 0
                            }
                            if (this.sorted === 'title') {
                                if (a['title'] > b['title']) return 1
                                if (a['title'] < b['title']) return -1
                                if (a['title'] = b['title']) return 0
                            }
                        })
                }
            },
            mounted() {
                this.GetCategories();
                this.GetThemes();
                this.GetCourse();
            }
        }
        Vue.createApp(CoursesFunctions).mount('#CoursesFunctions');
    </script>
@endsection

