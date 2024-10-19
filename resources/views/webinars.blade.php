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
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        const WebinarFunctions = {
            data() {
                return {
                    webinars: [],
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
            },
            mounted() {
                this.Get();
            }
        }
        Vue.createApp(WebinarFunctions).mount('#WebinarPage');
    </script>
@endsection
