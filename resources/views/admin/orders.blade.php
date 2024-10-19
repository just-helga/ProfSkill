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
                            <th scope="col">ФИО заказчика</th>
                            <th scope="col">Курс</th>
                            <th scope="col">Дата создания</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(order, index) in orders" style="vertical-align: bottom !important;">
                            <th scope="row"> @{{ index+1 }} </th>
                            <td> @{{ order.user.name }} @{{ order.user.surname }} @{{ order.user.patronymic }} </td>
                            <td> @{{ order.course.title }} ₽</td>
                            <td> @{{ order.created_at }} </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        const CategoryFunctions = {
            data() {
                return {
                    orders: [],
                    status: 0
                }
            },
            methods: {
                //---Получение заказов
                async GetOrders() {
                    const response = await fetch('{{route('OrderGet')}}');
                    const data = await response.json();
                    this.orders = data.orders_all;
                    console.log(this.orders);
                },
            },
            mounted() {
                this.GetOrders();
            }
        }
        Vue.createApp(CategoryFunctions).mount('#CategoryPage');
    </script>
@endsection
