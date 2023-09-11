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
                                    <h4 class="text-dark">{{    order.problem_description}}</h4>
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
<!--                                        <td aria-colindex="1" role="cell">{{ item.id }}</td>-->
                                        <td aria-colindex="1"  role="cell" class="mb-4">
                                            <button @click.prevent="getOrder(item.id)" class="btn btn-success mb-2 me-1">
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

                            <div class="code-section-container show-code">
                                <div v-if="code_arr.includes('code1')" class="code-section text-start">
                                    <highlight>
                                        <div v-pre>
                                            <pre>
&lt;div class=&quot;table-responsive&quot;&gt;
    &lt;table role=&quot;table&quot; aria-busy=&quot;false&quot; aria-colcount=&quot;5&quot; class=&quot;table table-bordered&quot; id=&quot;__BVID__415&quot;&gt;
        &lt;thead role=&quot;rowgroup&quot;&gt;
            &lt;tr role=&quot;row&quot;&gt;
                &lt;th role=&quot;columnheader&quot; scope=&quot;col&quot; aria-colindex=&quot;1&quot;&gt;&lt;div&gt;Name&lt;/div&gt;&lt;/th&gt;
                &lt;th role=&quot;columnheader&quot; scope=&quot;col&quot; aria-colindex=&quot;2&quot;&gt;&lt;div&gt;Date&lt;/div&gt;&lt;/th&gt;
                &lt;th role=&quot;columnheader&quot; scope=&quot;col&quot; aria-colindex=&quot;3&quot;&gt;&lt;div&gt;Sale&lt;/div&gt;&lt;/th&gt;
                &lt;th role=&quot;columnheader&quot; scope=&quot;col&quot; aria-colindex=&quot;4&quot; class=&quot;text-center&quot;&gt;&lt;div&gt;status&lt;/div&gt;&lt;/th&gt;
                &lt;th role=&quot;columnheader&quot; scope=&quot;col&quot; aria-colindex=&quot;5&quot; aria-label=&quot;Action&quot; class=&quot;text-center&quot;&gt;&lt;div&gt;&lt;/div&gt;&lt;/th&gt;
            &lt;/tr&gt;
        &lt;/thead&gt;
        &lt;tbody role=&quot;rowgroup&quot;&gt;
            &lt;tr v-for=&quot;item in table_1&quot; :key=&quot;item.name&quot; role=&quot;row&quot;&gt;
                &lt;td aria-colindex=&quot;1&quot; role=&quot;cell&quot;&gt;{{ item.name }}&lt;/td&gt;
                &lt;td aria-colindex=&quot;2&quot; role=&quot;cell&quot;&gt;{{ item.date }}&lt;/td&gt;
                &lt;td aria-colindex=&quot;3&quot; role=&quot;cell&quot;&gt;{{ item.sale }}&lt;/td&gt;
                &lt;td aria-colindex=&quot;4&quot; role=&quot;cell&quot; class=&quot;text-center&quot;&gt;
                    &lt;span :class=&quot;`text-${item.status_class}`&quot;&gt; {{ item.status }} &lt;/span&gt;
                &lt;/td&gt;
                &lt;td aria-colindex=&quot;5&quot; role=&quot;cell&quot; class=&quot;text-center&quot;&gt;
                    &lt;svg
                        xmlns=&quot;http://www.w3.org/2000/svg&quot;
                        width=&quot;24&quot;
                        height=&quot;24&quot;
                        viewBox=&quot;0 0 24 24&quot;
                        fill=&quot;none&quot;
                        stroke=&quot;currentColor&quot;
                        stroke-width=&quot;2&quot;
                        stroke-linecap=&quot;round&quot;
                        stroke-linejoin=&quot;round&quot;
                        class=&quot;feather feather-trash-2 icon&quot;
                    &gt;
                        &lt;polyline points=&quot;3 6 5 6 21 6&quot;&gt;&lt;/polyline&gt;
                        &lt;path d=&quot;M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2&quot;&gt;&lt;/path&gt;
                        &lt;line x1=&quot;10&quot; y1=&quot;11&quot; x2=&quot;10&quot; y2=&quot;17&quot;&gt;&lt;/line&gt;
                        &lt;line x1=&quot;14&quot; y1=&quot;11&quot; x2=&quot;14&quot; y2=&quot;17&quot;&gt;&lt;/line&gt;
                    &lt;/svg&gt;
                &lt;/td&gt;
            &lt;/tr&gt;
        &lt;/tbody&gt;
    &lt;/table&gt;
&lt;/div&gt;
</pre
>
                                        </div>
                                    </highlight>
                                </div>
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

const code_arr = ref([]);
const table_1 = ref([]);
const table_2 = ref([]);

onMounted(() => {
    initTooltip();
    init_tables();
});

const toggleCode = (name) => {
    if (code_arr.value.includes(name)) {
        code_arr.value = code_arr.value.filter((d) => d != name);
    } else {
        code_arr.value.push(name);
    }
};

const initTooltip = () => {
    setTimeout(() => {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map((tooltipTriggerEl) => {
            return new window.bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
};

const init_tables = () => {
    table_1.value = [
        {
            thumb: "boy.png",
            name: "Shaun Park",
            "first name": "John",
            "last name": "Doe",
            email: "johndoe@yahoo.com",
            date: "10/08/2020",
            sale: "320",
            sales: "29.56",
            status: "Complete",
            status_class: "success",
            register: "5 min ago",
            position: "Developer",
            office: "London",
        },
        {
            thumb: "girl-1.png",
            name: "Alma Clarke",
            "first name": "Andy",
            "last name": "King",
            email: "andyking@gmail.com",
            date: "11/08/2020",
            sale: "420",
            sales: "19.15",
            status: "Pending",
            status_class: "secondary",
            register: "10 min ago",
            position: "Designer",
            office: "New York",
        },
        {
            thumb: "girl-2.png",
            name: "Xavier",
            "first name": "Lisa",
            "last name": "Doe",
            email: "lisadoe@yahoo.com",
            date: "12/08/2020",
            sale: "130",
            sales: "39.00",
            status: "In progress",
            status_class: "info",
            register: "1 hour ago",
            position: "Accountant",
            office: "Amazon",
        },
        {
            thumb: "boy-2.png",
            name: "Vincent Carpenter",
            "first name": "Vincent",
            "last name": "Carpenter",
            email: "vinnyc@yahoo.com",
            date: "13/08/2020",
            sale: "260",
            sales: "88.03",
            status: "Canceled",
            status_class: "danger",
            register: "1 day ago",
            position: "Data Scientist",
            office: "Canada",
        },
    ];

    table_2.value = [
        {
            thumb: "boy.png",
            name: "Amy Diaz",
            "first name": "Amy",
            "last name": "Diaz",
            email: "amydiaz@yahoo.com",
            date: "10/08/2020",
            sale: "320",
            sales: "29.56",
            status: "Complete",
            status_class: "success",
            register: "5 min ago",
        },
        {
            thumb: "girl-1.png",
            name: "Nia Hillyer",
            "first name": "Nia",
            "last name": "Hillyer",
            email: "niahill@gmail.com",
            date: "11/08/2020",
            sale: "420",
            sales: "19.15",
            status: "Pending",
            status_class: "secondary",
            register: "10 min ago",
        },
        {
            thumb: "girl-2.png",
            name: "Marry",
            "first name": "Marry",
            "last name": "McDonald",
            email: "marryMcD@yahoo.com",
            date: "12/08/2020",
            sale: "130",
            sales: "39.00",
            status: "In progress",
            status_class: "info",
            register: "1 hour ago",
        },
        {
            thumb: "boy-2.png",
            name: "Shaun Park",
            "first name": "Shaun",
            "last name": "Park",
            email: "park@yahoo.com",
            date: "13/08/2020",
            sale: "260",
            sales: "88.03",
            status: "Canceled",
            status_class: "danger",
            register: "1 day ago",
        },
    ];
    table_2.value = table_1.value.concat(table_2.value);
};

const random_class = (index) => {
    if (index == 0) {
        return "default";
    } else if (index == 1) {
        return "primary";
    } else if (index == 2) {
        return "secondary";
    } else if (index == 3) {
        return "success";
    } else if (index == 4) {
        return "dark";
    } else if (index == 5) {
        return "danger";
    } else if (index == 6) {
        return "info";
    } else if (index == 7) {
        return "warning";
    }
    return "dark";
};

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
const getOrder = (id) => {
    const station = {
        "id": orderId,
        "station_id": id,

    }

    const response = await api.post('/api/auth/client/order', station);

    router.push({ name: 'order-index' });
};

onMounted(getOrder)
</script>
