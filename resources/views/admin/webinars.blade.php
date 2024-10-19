@extends('layout.app')

@section('title', 'Вебинары')

@section('content')
    <div id="WebinarPage">
        <!-- Основное контент -->
        <div class="container">
            <div class="row  mt-5">
                <div class="col-8">
                    <h2 class="text-dark">Вебинары</h2>
                </div>
                <div class="col-4  justify-content-around">
                    <button class="btn  btn-dark  col-12" data-bs-toggle="modal" data-bs-target="#AddModal">
                        Новый вебинар
                    </button>
                </div>
            </div>
            <div class="row  mt-5">
                <div class="col-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Название</th>
                            <th scope="col">Дата</th>
                            <th scope="col">Описание</th>
                            <th scope="col">Спикер</th>
                            <th scope="col">Тема</th>
                            <th scope="col">Ссылка</th>
                            <th scope="col" style="text-align: end">Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(webinar, index) in webinars" style="vertical-align: bottom !important;">
                            <th scope="row"> @{{ index+1 }} </th>
                            <td> @{{ webinar.title }} </td>
                            <td> @{{ webinar.date }} </td>
                            <td> @{{ webinar.description }} </td>
                            <td> @{{ webinar.speaker.name }} </td>
                            <td> @{{ webinar.theme.title }} </td>
                            <td>
                                <a :href="webinar.link" class="link-info"> @{{  webinar.link }} </a>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; justify-content: flex-end">
                                    <button type="button" class="btn  btn-success" @click="RenderModalEdit(webinar.id)" data-bs-toggle="modal" data-bs-target="#EditModal"  style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 0.25rem; border: none; margin-right: 5px;">
                                        <iconify-icon icon="mdi:lead-pencil" style="color: white;" width="20" height="20"></iconify-icon>
                                    </button>
                                    <button type="button" class="btn  btn-danger" @click="RenderModalDelete(webinar.id)" data-bs-toggle="modal" data-bs-target="#DeleteModal"  style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 0.25rem; border: none">
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
                        <h5 class="modal-title" id="AddModalLabel">Добавление вебинара</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">
                        <form id="FormAdd" @submit.prevent="Add">
                            <div class="mb-3">
                                <label for="title" class="form-label">Название</label>
                                <input type="text" class="form-control" id="title" name="title" :class="errors.title ? 'is-invalid' : ''">
                                <div :class="errors.title ? 'invalid-feedback' : ''" v-for="error in errors.title">
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
                            <div class="mb-3">
                                <label for="date" class="form-label">Дата</label>
                                <input type="date" class="form-control" id="date" name="date" :class="errors.date ? 'is-invalid' : ''" title="Это поле обязательное">
                                <div :class="errors.date ? 'invalid-feedback' : ''" v-for="error in errors.date">
                                    @{{ error }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="speaker_id" class="form-label">Спикер</label>
                                <select class="form-select" name="speaker_id" id="speaker_id">
                                    <option v-for="speaker in speakers" :value="speaker.id"> @{{speaker.name}} </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="theme_id" class="form-label">Тема</label>
                                <select class="form-select" name="theme_id" id="theme_id">
                                    <option v-for="theme in themes" :value="theme.id"> @{{theme.title}} </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="link" class="form-label">Ссылка</label>
                                <input type="text" class="form-control" id="link" name="link" :class="errors.link ? 'is-invalid' : ''">
                                <div :class="errors.link ? 'invalid-feedback' : ''" v-for="error in errors.link">
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
                        <h5 class="modal-title" id="DeleteModalLabel">Удаление вебинара</h5>
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
                                <label for="EditModalInputTitle" class="form-label">Название</label>
                                <input type="text" class="form-control" id="EditModalInputTitle" name="title" :class="errors.title ? 'is-invalid' : ''">
                                <div :class="errors.title ? 'invalid-feedback' : ''" v-for="error in errors.title">
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
                            <div class="mb-3">
                                <label for="EditModalInputDate" class="form-label">Дата</label>
                                <input type="date" class="form-control" id="EditModalInputDate" name="date" :class="errors.date ? 'is-invalid' : ''" title="Это поле обязательное">
                                <div :class="errors.date ? 'invalid-feedback' : ''" v-for="error in errors.date">
                                    @{{ error }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="EditModalInputSpeaker" class="form-label">Спикер</label>
                                <select class="form-select" name="speaker_id" id="EditModalInputSpeaker">
                                    <option v-for="speaker in speakers" :value="speaker.id"> @{{speaker.name}} </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="EditModalInputTheme" class="form-label">Тема</label>
                                <select class="form-select" name="theme_id" id="EditModalInputTheme">
                                    <option v-for="theme in themes" :value="theme.id"> @{{theme.title}} </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="EditModalInputLink" class="form-label">Ссылка</label>
                                <input type="text" class="form-control" id="EditModalInputLink" name="link" :class="errors.link ? 'is-invalid' : ''">
                                <div :class="errors.link ? 'invalid-feedback' : ''" v-for="error in errors.link">
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
        const WebinarFunctions = {
            data() {
                return {
                    webinars: [],
                    speakers: [],
                    themes: [],
                    errors: [],
                    message: '',
                    active: ''
                }
            },
            methods: {
                //---Получение вебинаров
                async Get() {
                    const response = await fetch('{{route('WebinarGet')}}');
                    const data = await response.json();
                    this.webinars = data.all;
                },
                //---Получение спикеров
                async GetSpeakers() {
                    const response = await fetch('{{route('SpeakerGet')}}');
                    const data = await response.json();
                    this.speakers = data.all;
                },
                //---Получение тем
                async GetThemes() {
                    const response = await fetch('{{route('ThemeGet')}}');
                    const data = await response.json();
                    this.themes = data.all;
                },
                //---Добавление нового вебинара
                async Add() {
                    const form = document.querySelector('#FormAdd');
                    const formData = new FormData(form);
                    const response = await fetch('{{route('WebinarAdd')}}', {
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
                    var title = this.webinars.find(webinar => webinar.id === id).title;
                    document.getElementById('DeleteModalBody').innerText = 'Вы уверены, что хотите удалить вебинара "' + title + '"';
                    this.active = this.webinars.find(webinar => webinar.id === id).id;
                },
                //---Удаление вебинара
                async Delete() {
                    const response = await fetch('{{route('WebinarDelete')}}', {
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
                    var title = this.webinars.find(webinar => webinar.id === id).title;
                    document.getElementById('EditModalLabel').innerText = 'Редактирование вебинара "' + title + '"';
                    document.getElementById('EditModalInputTitle').value = title;
                    document.getElementById('EditModalInputDescription').value = this.webinars.find(webinar => webinar.id === id).description;
                    document.getElementById('EditModalInputDate').value = this.webinars.find(webinar => webinar.id === id).date;
                    document.getElementById('EditModalInputLink').value = this.webinars.find(webinar => webinar.id === id).link;
                    document.getElementById('EditModalInputSpeaker').value = this.webinars.find(webinar => webinar.id === id).speaker_id;
                    document.getElementById('EditModalInputTheme').value = this.webinars.find(webinar => webinar.id === id).theme_id;
                    this.active = this.webinars.find(webinar => webinar.id === id).id;
                    console.log(this.active);
                },
                //---Редактирование вебинара
                async Edit() {
                    const form = document.querySelector('#FormEdit');
                    const formData = new FormData(form);
                    formData.append('id', this.active);
                    const response = await fetch('{{route('WebinarEdit')}}', {
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
                this.GetSpeakers();
                this.GetThemes();
            }
        }
        Vue.createApp(WebinarFunctions).mount('#WebinarPage');
    </script>
@endsection
