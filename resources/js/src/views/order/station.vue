<template>
    <div class="container">
        <teleport to="#breadcrumb">
            <ul class="navbar-nav flex-row">
                <li>
                    <div class="page-header">
                        <nav class="breadcrumb-one" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:;">Tables</a></li>
                            </ol>
                        </nav>
                    </div>
                </li>
            </ul>
        </teleport>

        <div class="container">
            <div v-scroll-spy class="row layout-top-spacing">
                <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox panel box box-shadow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xl-8 col-lg-7 col-md-6 col-sm-4 align-self-center">
                                    <h3 class="inv-to text-success">Выберите СТО для ремонта</h3>
                                </div>
                                <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8 align-self-center order-sm-0 order-1 inv--payment-info">
                                    <h6 class="inv-title"></h6>
                                </div>

                                <div class="col-xl-8 col-lg-7 col-md-6 col-sm-4">
                                    <p class="inv-customer-name">Описание:</p>
                                    <h4 class="text-dark">{{ order.problem_description }}</h4>
                                </div>

                                <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8 col-12 order-sm-0 order-1">
                                    <div class="inv--payment-info">
                                        <p v-for="item in region"><span class="inv-subtitle">Регион</span> <span class="text-dark">{{ item.region_name }}</span ></p>
                                        <div v-for="item in car">
                                            <p><span class="inv-subtitle">Brand </span> <span class="text-dark">{{item.brand}}</span></p>
                                            <p><span class="inv-subtitle">Model </span> <span class="text-dark">{{ item.model }}</span></p>
                                            <p><span class="inv-subtitle">Number </span> <span class="text-dark">{{item.number}}</span></p>
                                        </div>
                                        <p><span class="inv-subtitle">Mileage </span> <span class="text-dark">{{order.mileage}}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table role="table" aria-busy="false" aria-colcount="5" class="table table-bordered"
                                       id="__BVID__415">
                                    <thead role="rowgroup">
                                    <tr role="row">
                                        <th role="columnheader" class="text-success" scope="col" aria-colindex="1">
                                            <div>id</div>
                                        </th>
                                        <th role="columnheader" class="text-success" scope="col" aria-colindex="2">
                                            <div>Название</div>
                                        </th>
                                        <th role="columnheader" class="text-success" scope="col" aria-colindex="3">
                                            <div>Адрес</div>
                                        </th>
                                        <th role="columnheader" class="text-success" scope="col" aria-colindex="4">
                                            <div>Телефон</div>
                                        </th>
                                        <th role="columnheader"  scope="col" aria-colindex="5" class="text-center text-success">
                                            <div>BIN</div>
                                        </th>
                                        <th role="columnheader"  scope="col" aria-colindex="6" class="text-center text-success">
                                            <div>BIK</div>
                                        </th>
                                        <th role="columnheader"  scope="col" aria-colindex="7" class="text-center text-success">
                                            <div>IIK</div>
                                        </th>
                                        <th role="columnheader"  scope="col" aria-colindex="8" class="text-center text-success">
                                            <div>Телефон</div>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody role="rowgroup">
                                    <tr v-for="item in station" role="row">
                                        <td aria-colindex="1"  role="cell" class="mb-4">
                                            <button @click.prevent="selectStation(item.id)" class="btn btn-success mb-2 me-1">
                                                {{ item.id }}
                                            </button>
                                        </td>
                                        <td aria-colindex="2" role="cell">{{ item.name }}</td>
                                        <td aria-colindex="3" role="cell">{{ item.address }}</td>
                                        <td aria-colindex="4" role="cell">{{ item.contact_phone }}</td>
                                        <td aria-colindex="5" role="cell">{{ item.bin }}</td>
                                        <td aria-colindex="6" role="cell">{{ item.bik }}</td>
                                        <td aria-colindex="7" role="cell">{{ item.iik }}</td>
                                        <td aria-colindex="8" role="cell">{{ item.fact_address }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {onMounted, ref} from "vue";

import "../../assets/sass/scrollspyNav.scss";
import "../../assets/sass/tables/table-basic.scss";
import highlight from "../../components/plugins/highlight.vue";

import {useMeta} from "../../composables/use-meta";

useMeta({title: "Tables"});

import {useRouter} from 'vue-router';
import api from "../../api";

const station = ref([]);

const route = useRouter();
const orderId = route.currentRoute.value.params.orderId;
const getStation = async () => {
    const regionId = route.currentRoute.value.params.regionId;

    try {
        const response = await api.get(`/api/auth/client/station/${regionId}/${orderId}`);
        station.value = response.data.stations
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
};

onMounted(getStation)

const order = ref([])

const regionId = ref(null)

const carId = ref(null)

const region = ref([])

const car = ref([])

const getRegion = async () => {
    try {
        const responseOrder = await api.get(`/api/auth/client/order/show/${orderId}`);

        order.value = responseOrder.data.orders[0]

        regionId.value = responseOrder.data.orders[0].region_id

        carId.value = responseOrder.data.orders[0].car_id

        const responseRegion = await api.get(`/api/auth/client/region/show/${regionId.value}`);

        region.value = responseRegion.data.regions;

        const responseCar = await api.get(`/api/auth/client/car/${carId.value}`);

        car.value = responseCar.data.cars;

    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
};

onMounted(getRegion)

const router = useRouter();
const selectStation = async (id) => {

    const station = {
        "id": orderId,
        "station_id": id,
        "status": 12,//Статус: Ожидает назначение диагностики от СТО

    }

    await api.post('/api/auth/client/order/edit', station);

    router.push({ name: 'order-index' });
};

</script>
