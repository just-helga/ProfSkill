@extends('layout.app')

@section('title', 'Заказы')

@section('content')
    <div id="CategoryPage">
        <!-- Основное контент -->
        <div class="container">
            <div class="row  mt-5">
                <div class="col-8">
                    <h2 class="text-primary">Заказы</h2>
                </div>
            </div>
            <div class="row  mt-5">
                <div class="col-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Курс</th>
                            <th scope="col">Дата создания</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(order, index) in orders" style="vertical-align: bottom !important;">
                            <th scope="row"> @{{ index+1 }} </th>
                            <td> @{{ order.course.title }} ₽</td>
                            <td> @{{ order.created_at }} </td>
                            <td><button type="button" class="btn  btn-warning" @click="RenderModalFiles(order.course_id)" data-bs-toggle="modal" data-bs-target="#FilesModal"  style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 0.25rem; border: none; margin-right: 5px;">
                                    <iconify-icon icon="ic:round-insert-drive-file" style="color: white;" width="20"></iconify-icon>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
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
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const CategoryFunctions = {
            data() {
                return {
                    orders: [],
                    files: [],
                    files_course: [],
                    status: 0
                }
            },
            methods: {
                //---Получение заказов
                async GetOrders() {
                    const response = await fetch('{{route('OrderGet')}}');
                    const data = await response.json();
                    this.orders = data.orders_user;
                    console.log(this.orders);
                },
                //---Получение файлов
                async GetFiles() {
                    const response = await fetch('{{route('FilesGet')}}');
                    const data = await response.json();
                    this.files = data.all;
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
            },
            mounted() {
                this.GetOrders();
                this.GetFiles()
            }
        }
        Vue.createApp(CategoryFunctions).mount('#CategoryPage');
    </script>
@endsection
