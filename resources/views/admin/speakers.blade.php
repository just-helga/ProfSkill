@extends('layout.app')

@section('title', 'Спикеры')

@section('content')
    <div id="SpeakerPage">
        <!-- Основное контент -->
        <div class="container">
            <div class="row  mt-5">
                <div class="col-8">
                    <h2 class="text-dark">Спикеры</h2>
                </div>
                <div class="col-4  justify-content-around">
                    <button class="btn  btn-dark  col-12" data-bs-toggle="modal" data-bs-target="#AddModal">
                        Новый спикер
                    </button>
                </div>
            </div>
            <div class="row  mt-5">
                <div class="col-12">
                    <table class="table">
                        <tbody>
                        <tr v-for="(speaker, index) in speakers" style="vertical-align: bottom !important;">
                            <th scope="row"> @{{ index+1 }} </th>
                            <td> @{{ speaker.name }} </td>
                            <td> @{{ speaker.description }} </td>
                            <td>
                                <div style="display: flex; align-items: center; justify-content: flex-end">
                                    <button type="button" class="btn  btn-success" @click="RenderModalEdit(speaker.id)" data-bs-toggle="modal" data-bs-target="#EditModal"  style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 0.25rem; border: none; margin-right: 5px;">
                                        <iconify-icon icon="mdi:lead-pencil" style="color: white;" width="20" height="20"></iconify-icon>
                                    </button>
                                    <button type="button" class="btn  btn-danger" @click="RenderModalDelete(speaker.id)" data-bs-toggle="modal" data-bs-target="#DeleteModal"  style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 0.25rem; border: none">
                                        <iconify-icon icon="material-symbols:delete" style="color: white;" width="20"></iconify-icon>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Модальное окно добавления -->
        <div class="modal  fade" id="AddModal" tabindex="-1" aria-labelledby="AddModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="AddModalLabel">Добавление спикера</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">
                        <form id="FormAdd" @submit.prevent="Add">
                            <div class="mb-3">
                                <label for="name" class="form-label">Имя</label>
                                <input type="text" class="form-control" id="name" name="name" :class="errors.name ? 'is-invalid' : ''">
                                <div :class="errors.name ? 'invalid-feedback' : ''" v-for="error in errors.name">
                                    @{{ error }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Описание</label>
                                <textarea class="form-control" id="description" name="description" :class="errors.description ? 'is-invalid' : ''" style="max-height: 300px"></textarea>
                                <div :class="errors.description ? 'invalid-feedback' : ''" v-for="error in errors.description">
                                    @{{ error }}
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" form="FormAdd" class="btn  btn-dark">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Модальное окно удаления -->
        <div class="modal  fade" id="DeleteModal" tabindex="-1" aria-labelledby="DeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="DeleteModalLabel">Удаление спикера</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body" id="DeleteModalBody"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button @click="Delete" class="btn  btn-dark">Удалить</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Модальное окно редактирования -->
        <div class="modal  fade" id="EditModal" tabindex="-1" aria-labelledby="EditModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="EditModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">
                        <span></span>
                        <form id="FormEdit" @submit.prevent="Edit">
                            <div class="mb-3">
                                <label for="EditModalInputName" class="form-label">Название</label>
                                <input type="text" class="form-control" id="EditModalInputName" name="name" :class="errors.name ? 'is-invalid' : ''">
                                <div :class="errors.name ? 'invalid-feedback' : ''" v-for="error in errors.name">
                                    @{{ error }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="EditModalInputDescription" class="form-label">Описание</label>
                                <textarea class="form-control" id="EditModalInputDescription" name="description" :class="errors.description ? 'is-invalid' : ''" style="max-height: 300px"></textarea>
                                <div :class="errors.description ? 'invalid-feedback' : ''" v-for="error in errors.description">
                                    @{{ error }}
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" form="FormEdit" class="btn  btn-dark">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const SpeakerFunctions = {
            data() {
                return {
                    speakers: [],
                    errors: [],
                    message: '',
                    active: ''
                }
            },
            methods: {
                //---Получение спикеров
                async Get() {
                    const response = await fetch('{{route('SpeakerGet')}}');
                    const data = await response.json();
                    this.speakers = data.all;
                },
                //---Добавление нового спикера
                async Add() {
                    const form = document.querySelector('#FormAdd');
                    const formData = new FormData(form);
                    const response = await fetch('{{route('SpeakerAdd')}}', {
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
                //---Отрисовка модального окна удаления
                RenderModalDelete(id) {
                    var name = this.speakers.find(speaker => speaker.id === id).name;
                    document.getElementById('DeleteModalBody').innerText = 'Вы уверены, что хотите удалить спикера "' + name + '"';
                    this.active = this.speakers.find(speaker => speaker.id === id).id;
                },
                //---Удаление спикера
                async Delete() {
                    const response = await fetch('{{route('SpeakerDelete')}}', {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({id:this.active})
                    });
                    if (response.status === 200) {
                        window.location = response.url;
                    };
                },
                //---Отрисовка модального окна редактирования
                RenderModalEdit(id) {
                    var name = this.speakers.find(speaker => speaker.id === id).name;
                    document.getElementById('EditModalLabel').innerText = 'Редактирование спикера "' + name + '"';
                    document.getElementById('EditModalInputName').value = name;
                    document.getElementById('EditModalInputDescription').value = this.speakers.find(speaker => speaker.id === id).description;
                    this.active = this.speakers.find(speaker => speaker.id === id).id;
                },
                //---Редактирование спикера
                async Edit() {
                    const form = document.querySelector('#FormEdit');
                    const formData = new FormData(form);
                    formData.append('id', this.active);
                    const response = await fetch('{{route('SpeakerEdit')}}', {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                        },
                        body: formData
                    });
                    if (response.status === 400) {
                        this.errors = await response.json();
                        setTimeout(()=>{
                            this.errors = []
                        }, 5000);
                    }
                    if (response.status === 200) {
                        window.location = response.url;
                    }
                }
            },
            mounted() {
                this.Get();
            }
        }
        Vue.createApp(SpeakerFunctions).mount('#SpeakerPage');
    </script>
@endsection
