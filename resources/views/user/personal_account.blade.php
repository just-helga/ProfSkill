@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layout.app')

@section('title', 'Личный кабинет')

@section('content')
    <div id="PersonalAcc">
        <!-- Основное контент -->
        <div class="container">
            <div class="row  mt-5 "><h2 class="text-dark  text-center">Личный кабинет</h2></div>
            <div class="mt-5" style="display: flex; justify-content: space-between; align-items: center; width: 100%">
                <div style="display: flex; align-items: center; justify-content: start; flex-direction: row">
                    <div class="user_img" style="width: 200px; height: 200px; border-radius: 100px; border: 1px solid #212529; overflow: hidden">
                        @if(Auth::user() && Auth::user()->img == null)
                            <img src="public/img/no_img.png" alt=""
                                 style="width: 100%; height: 100%; object-fit: cover; opacity: 85%">
                        @else
                            <img src="{{Auth::user()->img}}" alt="" style="width: 100%; height: auto; object-fit: cover">
                        @endif
                            <div class="user_img-hover" data-bs-toggle="modal" data-bs-target="#AddModalImg" style="color: white">Изменить</div>
                    </div>
                    <div style="margin-left: 20px; display: flex; flex-direction: column; align-items: start; justify-content: start">
                        <h4 class="text-dark"> {{Auth::user()->name}} {{Auth::user()->surname}} {{Auth::user()->patronymic}} </h4>
                        <h4 class="text-dark"> ({{Auth::user()->email}}) </h4>
                    </div>
                </div>
                <button class="btn  btn-dark  col-3" data-bs-toggle="modal" data-bs-target="#AddModalCard">Добавить карту</button>
            </div>
            @if(count($cards) !== 0)
            <div class="row  mt-5">
                <div class="col-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Номер карты</th>
                            <th scope="col">ФИО</th>
                            <th scope="col">Дата</th>
                            <th scope="col" style="text-align: end">Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cards as $card)
                        <tr style="vertical-align: bottom !important;">
                            <td> {{ $card->number }}</td>
                            <td> {{ $card->name }}</td>
                            <td> {{ $card->date }}</td>
                            <td>
                                <div style="display: flex; align-items: center; justify-content: flex-end">
                                    <button type="button" class="btn  btn-danger" @click="CardDelete({{$card->id}})" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 0.25rem; border: none">
                                        <iconify-icon icon="material-symbols:delete" style="color: white;" width="20"></iconify-icon>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

        <!-- Модальное окно изменения фото-->
        <div class="modal  fade" id="AddModalImg" tabindex="-1" aria-labelledby="AddModalImgLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="AddModalImgLabel">Изменение фото профиля</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">
                        <form id="FormAddImg" @submit.prevent="ImgAdd" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="img" class="form-label">Фото</label>
                                <input type="file" class="form-control" id="img" name="img" :class="errors.img ? 'is-invalid' : ''">
                                <div :class="errors.img ? 'invalid-feedback' : ''" v-for="error in errors.img">
                                    @{{ error }}
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer" style="width: 100%">
                        <button type="button" class="btn  btn-danger" style="width: 27%" @click="ImgDelete">Удалить фото</button>
                        <button type="submit" form="FormAddImg" class="btn  btn-dark" style="width: 27%">Сохранить</button>
                        <button type="button" class="btn  btn-secondary" style="width: 27%" data-bs-dismiss="modal">Отмена</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Модальное окно добавления карты -->
        <div class="modal  fade" id="AddModalCard" tabindex="-1" aria-labelledby="AddModalCardLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="AddModalCardLabel">Добавление карты</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">
                        <form id="FormAddCard" @submit.prevent="CardAdd">
                            <div class="mb-3">
                                <label for="number" class="form-label">Номер</label>
                                <input type="text" class="form-control" maxlength="16" id="number" name="number" :class="errors.number ? 'is-invalid' : ''">
                                <div :class="errors.number ? 'invalid-feedback' : ''" v-for="error in errors.number">
                                    @{{ error }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">ФИО</label>
                                <input type="text" class="form-control" id="name" name="name" :class="errors.name ? 'is-invalid' : ''">
                                <div :class="errors.name ? 'invalid-feedback' : ''" v-for="error in errors.name">
                                    @{{ error }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Дата</label>
                                <input type="date" class="form-control" id="date" name="date" :class="errors.date ? 'is-invalid' : ''">
                                <div :class="errors.date ? 'invalid-feedback' : ''" v-for="error in errors.date">
                                    @{{ error }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="cvv" class="form-label">CVV-код</label>
                                <input type="password" class="form-control" maxlength="3" id="cvv" name="cvv" :class="errors.cvv ? 'is-invalid' : ''">
                                <div :class="errors.cvv ? 'invalid-feedback' : ''" v-for="error in errors.cvv">
                                    @{{ error }}
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" form="FormAddCard" class="btn  btn-dark">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .user_img {
            position: relative;
        }
        .user_img-hover {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            border: none;
            border-radius: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            cursor: pointer;
            transition: .3s;
        }
        .user_img:hover .user_img-hover {
            opacity: 100%;
        }
    </style>

    <script>
        const PersonalAccFunctions = {
            data() {
                return {
                    errors: [],
                    message: '',
                    active: ''
                }
            },
            methods: {
                //---Добавление карты
                async CardAdd() {
                    const form = document.querySelector('#FormAddCard');
                    const formData = new FormData(form);
                    const response = await fetch('{{route('CardAdd')}}', {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        },
                        body: formData
                    });
                    if (response.status === 400) {
                        this.errors = await response.json();
                        setTimeout(()=>{
                            this.errors = []
                        }, 5000);
                    };
                    if (response.status === 200) {
                        window.location = response.url;
                    };
                },
                //---Удаление карты
                async CardDelete(id) {
                    const response = await fetch('{{route('CardDelete')}}', {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({id:id})
                    });
                    if (response.status === 200) {
                        window.location = response.url;
                    };
                },
                //---Изменение фото профиля
                async ImgAdd() {
                    const form = document.querySelector('#FormAddImg');
                    const formData = new FormData(form);
                    const response = await fetch('{{route('ImgAdd')}}', {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        },
                        body: formData
                    });
                    if (response.status === 400) {
                        this.errors = await response.json();
                        setTimeout(()=>{
                            this.errors = []
                        }, 5000);
                    };
                    if (response.status === 200) {
                        window.location = response.url;
                    };
                },
                //---Удаление  фото профиля
                async ImgDelete() {
                    console.log('gdjgner');
                    const response = await fetch('{{route('ImgDelete')}}', {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                        }
                    });
                    if (response.status === 200) {
                        window.location = response.url;
                    };
                },
            }
        }
        Vue.createApp(PersonalAccFunctions).mount('#PersonalAcc');
    </script>
@endsection
