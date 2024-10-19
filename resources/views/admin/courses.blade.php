@extends('layout.app')

@section('title', 'Курсы')

@section('content')
    <div id="CategoryPage">
        <!-- Основное контент -->
        <div class="container">
            <div class="row  mt-5">
                <div class="col-8">
                    <h2 class="text-dark">Курсы</h2>
                </div>
                <div class="col-4  justify-content-around">
                    <button class="btn  btn-dark  col-12" data-bs-toggle="modal" data-bs-target="#AddModal">
                        Новый курс
                    </button>
                </div>
            </div>
            <div class="row  mt-5">
                <div class="col-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Превью</th>
                            <th scope="col">Название</th>
                            <th scope="col">Цена</th>
                            <th scope="col">Категория</th>
                            <th scope="col">Тема</th>
                            <th scope="col" style="text-align: end">Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(course, index) in courses" style="vertical-align: top !important;">
                            <th scope="row"> @{{ index+1 }} </th>
                            <td>
                                <div style="width: 300px; height: 150px; overflow: hidden">
                                    <img :src="course.preview" :alt="course.title" style="width: 100%; height: auto; object-fit: cover">
                                </div>
                            </td>
                            <td> @{{ course.title }} </td>
                            <td> @{{ course.price }} ₽</td>
                            <td> @{{ course.category.title }} </td>
                            <td> @{{ course.theme.title }} </td>
                            <td>
                                <div style="display: flex; align-items: center; justify-content: flex-end">
                                    <button type="button" class="btn  btn-warning" @click="RenderModalFiles(course.id)" data-bs-toggle="modal" data-bs-target="#FilesModal"  style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 0.25rem; border: none; margin-right: 5px;">
                                        <iconify-icon icon="ic:round-insert-drive-file" style="color: white;" width="20"></iconify-icon>
                                    </button>
                                    <button type="button" class="btn  btn-success" @click="RenderModalEdit(course.id)" data-bs-toggle="modal" data-bs-target="#EditModal"  style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 0.25rem; border: none; margin-right: 5px;">
                                        <iconify-icon icon="mdi:lead-pencil" style="color: white;" width="20" height="20"></iconify-icon>
                                    </button>
                                    <button type="button" class="btn  btn-danger" @click="RenderModalDelete(course.id)" data-bs-toggle="modal" data-bs-target="#DeleteModal"  style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 0.25rem; border: none">
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
                        <h5 class="modal-title" id="AddModalLabel">Добавление курса</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">
                        <form id="FormAdd" @submit.prevent="Add" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="title" class="form-label">Название</label>
                                <input type="text" class="form-control" id="title" name="title" :class="errors.title ? 'is-invalid' : ''">
                                <div :class="errors.title ? 'invalid-feedback' : ''" v-for="error in errors.title">
                                    @{{ error }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="preview" class="form-label">Превью</label>
                                <input type="file" class="form-control" id="preview" name="preview" :class="errors.preview ? 'is-invalid' : ''">
                                <div :class="errors.preview ? 'invalid-feedback' : ''" v-for="error in errors.preview">
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
                                <label for="price" class="form-label">Цена</label>
                                <input type="text" class="form-control" id="price" name="price" :class="errors.price ? 'is-invalid' : ''">
                                <div :class="errors.price ? 'invalid-feedback' : ''" v-for="error in errors.price">
                                    @{{ error }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Категория</label>
                                <select class="form-select" name="category_id" id="category_id">
                                    <option v-for="category in categories" :value="category.id"> @{{category.title}} </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="theme_id" class="form-label">Тема</label>
                                <select class="form-select" name="theme_id" id="theme_id">
                                    <option v-for="theme in themes" :value="theme.id"> @{{theme.title}} </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Файлы</label>
                                <input type="file" class="form-control" id="content" name="content[]" multiple :class="errors.content ? 'is-invalid' : ''">
                                <div :class="errors.content ? 'invalid-feedback' : ''" v-for="error in errors.content">
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
                        <h5 class="modal-title" id="DeleteModalLabel">Удаление курса</h5>
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
                        <form id="FormEdit" @submit.prevent="Edit" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="EditModalInputTitle" class="form-label">Название</label>
                                <input type="text" class="form-control" id="EditModalInputTitle" name="title" :class="errors.title ? 'is-invalid' : ''">
                                <div :class="errors.title ? 'invalid-feedback' : ''" v-for="error in errors.title">
                                    @{{ error }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="EditModalInputPreview" class="form-label">Превью</label>
                                <input type="file" class="form-control" id="EditModalInputPreview" name="preview" :class="errors.preview ? 'is-invalid' : ''">
                                <div :class="errors.preview ? 'invalid-feedback' : ''" v-for="error in errors.preview">
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
                                <label for="EditModalInputPrice" class="form-label">Цена</label>
                                <input type="text" class="form-control" id="EditModalInputPrice" name="price" :class="errors.price ? 'is-invalid' : ''">
                                <div :class="errors.price ? 'invalid-feedback' : ''" v-for="error in errors.price">
                                    @{{ error }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="EditModalInputCategory" class="form-label">Категория</label>
                                <select class="form-select" name="category_id" id="EditModalInputCategory">
                                    <option v-for="category in categories" :value="category.id"> @{{category.title}} </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="EditModalInputTheme" class="form-label">Тема</label>
                                <select class="form-select" name="theme_id" id="EditModalInputTheme">
                                    <option v-for="theme in themes" :value="theme.id"> @{{theme.title}} </option>
                                </select>
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

        <!-- Модальное окно файлов курса -->
        <div class="modal  fade" id="FilesModal" tabindex="-1" aria-labelledby="FilesModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="FilesModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body" id="FilesModalBody">
                        <div class="row">
                                <div class="col-12">
                                    <table class="table">
                                        <tbody>
                                        <tr v-for="(file, index) in files_course" style="vertical-align: bottom !important;">
                                            <td>Файл @{{ index + 1 }}</td>
                                            <td style="display: flex; align-items: center; justify-content: end; flex-direction: row">
                                                <a :href="file.way" :download="file.way" target="_blank" class="btn  btn-dark" style="margin-right: 10px;width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 0.25rem; border: none">
                                                    <iconify-icon icon="material-symbols:sim-card-download-rounded" style="color: white;" width="20"></iconify-icon>
                                                </a>
                                                <button type="button" class="btn  btn-danger" @click="DeleteFile(file.id)" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 0.25rem; border: none">
                                                    <iconify-icon icon="material-symbols:delete" style="color: white;" width="20"></iconify-icon>
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            <div  id="DivDownload" class="col-12" style="display: flex; flex-direction: column">
                                {{--                                <div  v-for="(file, index) in files_course">--}}
{{--                                    <button @click.prevent="DownloadFile(file.id)" class="btn  btn-dark" id="BtnDownload" style="width: 100%; margin-top: 10px;"> Файл @{{ index+1 }} </button>--}}
{{--                                <a id="DownloadLink" :download="file.way">скачать</a>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                        <div class="row">
                            <form id="FormFiles" @submit.prevent="AddFile()" class="mt-2" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="new" class="form-label">Добавить файлы</label>
                                    <input type="file" class="form-control" id="new" name="new[]" multiple :class="errors.new ? 'is-invalid' : ''">
                                    <div :class="errors.new ? 'invalid-feedback' : ''" v-for="error in errors.new">
                                        @{{ error }}
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" form="FormFiles" class="btn  btn-dark">Добавить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const CategoryFunctions = {
            data() {
                return {
                    courses: [],
                    files: [],
                    files_course: [],
                    categories: [],
                    themes: [],
                    errors: [],
                    message: '',
                    active: ''
                }
            },
            methods: {
                //---Получение курсов
                async GetCourse() {
                    const response = await fetch('{{route('CourseGet')}}');
                    const data = await response.json();
                    this.courses = data.all;
                },
                //---Получение файлов
                async GetFiles() {
                    const response = await fetch('{{route('FilesGet')}}');
                    const data = await response.json();
                    this.files = data.all;
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
                //---Добавление курса
                async Add() {
                    const form = document.querySelector('#FormAdd');
                    const formData = new FormData(form);
                    const response = await fetch('{{route('CourseAdd')}}', {
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
                    var title = this.courses.find(course => course.id === id).title;
                    document.getElementById('DeleteModalBody').innerText = 'Вы уверены, что хотите удалить курс "' + title + '"';
                    this.active = this.courses.find(course => course.id === id).id;
                },
                //---Удаление курса
                async Delete() {
                    const response = await fetch('{{route('CourseDelete')}}', {
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
                    var title = this.courses.find(course => course.id === id).title;
                    document.getElementById('EditModalLabel').innerText = 'Редактирование курса "' + title + '"';
                    document.getElementById('EditModalInputTitle').value = title;
                    document.getElementById('EditModalInputDescription').value = this.courses.find(course => course.id === id).description;
                    document.getElementById('EditModalInputPrice').value = this.courses.find(course => course.id === id).price;
                    document.getElementById('EditModalInputCategory').value = this.courses.find(course => course.id === id).category_id;
                    document.getElementById('EditModalInputTheme').value = this.courses.find(course => course.id === id).theme_id;
                    this.active = this.courses.find(course => course.id === id).id;
                },
                //---Редактирование категории
                async Edit() {
                    const form = document.querySelector('#FormEdit');
                    const formData = new FormData(form);
                    formData.append('id', this.active);
                    const response = await fetch('{{route('CourseEdit')}}', {
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
                },
                //---Отрисовка модального окна файлов курса
                RenderModalFiles(id) {
                    this.files_course = (this.files).filter(file => {
                        return file.course_id == id;
                    });

                    var title = this.courses.find(course => course.id === id).title;
                    document.getElementById('FilesModalLabel').innerText = 'Файлы курса "' + title + '"';

                    this.active = this.courses.find(course => course.id === id).id;
                },
                //---Удаление файла
                async DeleteFile(id) {
                    const response = await fetch('{{route('FileDelete')}}', {
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
                //---Добавление файла
                async AddFile() {
                    const form = document.querySelector('#FormFiles');
                    const formData = new FormData(form);
                    formData.append('id', this.active);
                    const response = await fetch('{{route('FileAdd')}}', {
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
                {{--async DownloadFile(id) {--}}
                {{--    const response = await fetch('{{route('FileDownload')}}', {--}}
                {{--        method: 'post',--}}
                {{--        headers: {--}}
                {{--            'X-CSRF-TOKEN': '{{csrf_token()}}',--}}
                {{--            'Content-Type': 'application/pdf'--}}
                {{--        },--}}
                {{--        body: JSON.stringify({id:id}),--}}
                {{--        responseType: {'blob': 'json'}--}}
                {{--    });--}}
                {{--    if (response.status === 200) {--}}
                {{--        var link = document.getElementById('DownloadLink');--}}
                {{--        link.href = window.URL.createObjectURL(new Blob([response.data]));--}}
                {{--    };--}}
                {{--},--}}
            },
            mounted() {
                this.GetCategories();
                this.GetThemes();
                this.GetCourse();
                this.GetFiles();
            }
        }
        Vue.createApp(CategoryFunctions).mount('#CategoryPage');
    </script>
@endsection
