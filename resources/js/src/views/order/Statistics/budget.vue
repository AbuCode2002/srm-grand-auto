<template>
    <div v-if="roleUser != null" class="container">
        <div class="row layout-top-spacing">
            <div id="tableFooter" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox panel box box-shadow">

                    <div class="col-md-11 mx-5">
                    </div>
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                                <h4>Бюджет</h4>
                            </div>

                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-checkable table-highlight-head table-responsive">
                            <table role="table" aria-busy="false" aria-colcount="5"
                                   class="table b-table table-striped table-hover table-bordered table-fluid" id="__BVID__368">
                                <thead role="rowgroup" class="">
                                <tr role="row" class="">
                                    <th role="columnheader" scope="col" aria-colindex="1" class="text-success">
                                        <div>Регион</div>
                                    </th>
                                    <th role="columnheader" scope="col" aria-colindex="2" class="text-success">
                                        <div>Бюджет</div>
                                    </th>
                                    <th role="columnheader" scope="col" aria-colindex="3" class="text-success">
                                        <div>Использованная сумма</div>
                                    </th>
                                    <th role="columnheader" scope="col" aria-colindex="4" class="text-success">
                                        <div>Сумма в работе</div>
                                    </th>
                                    <th role="columnheader" scope="col" aria-colindex="5" class="text-success">
                                        <div>Остаток</div>
                                    </th>
                                    <th role="columnheader" scope="col" aria-colindex="6" class="text-success">
                                        <div>Остаток без НДС</div>
                                    </th>
                                    <th role="columnheader" scope="col" aria-colindex="7" class="text-success">
                                        <div>Остаток без НДС и без наценки</div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody role="rowgroup">
                                <tr v-for="item2 in regions" :value="item2" role="row" class="">
                                    <td aria-colindex="1" role="cell" class="">{{ item2.region_name }}</td>
                                    <td aria-colindex="2" role="cell" class="" style="vertical-align: top;">{{ item2.budget }} тг</td>
                                    <td aria-colindex="3" role="cell" class="" style="vertical-align: top;">{{ item2.usedSum }} тг</td>
                                    <td aria-colindex="4" role="cell" class="" style="vertical-align: top;">{{ item2.workSum }} тг</td>
                                    <td aria-colindex="5" role="cell" class="" style="vertical-align: top;">{{ item2.restSum }} тг</td>
                                    <td aria-colindex="6" role="cell" class="" style="vertical-align: top;">{{ item2.restSumNotNDS }} тг</td>
                                    <td aria-colindex="7" role="cell" class="" style="vertical-align: top;">{{ item2.restSumNotNDSNotMarkup }} тг</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>
import {ref, onMounted, watch} from "vue";

import "../../../assets/sass/scrollspyNav.scss";
import "../../../assets/sass/tables/table-basic.scss";

import {useMeta} from "../../../composables/use-meta";
import api from "../../../api";

import {useStore} from 'vuex';

const store = useStore();

import feather from 'feather-icons';

onMounted(() => {
    feather.replace();
});

useMeta({title: "Tables"});

const cars = ref(null);

const getCars = async () => {
    try {
        const response = await api.get('/api/admin/auth/car/name');
        cars.value = response.data;
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
};
onMounted(getCars)

const code_arr = ref([]);
const order = ref([]);

onMounted(() => {
    initTooltip();
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

import {useRouter} from 'vue-router';
import VueMultiselect from "vue-multiselect";

const router = useRouter();

const getRegionId = (regionId, orderId) => {
    router.push({name: 'order-index-station', params: {regionId, orderId}});
};

const pagination = ref({
    "last_page": 1
});
const currentPage = ref(1);

const regions = ref([]);

const getManegers = async () => {
    try {
        const response = await api.get(`/api/admin/auth/region/parent-region`);

        regions.value = response.data.regions
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
};

onMounted(getManegers)

const pageChanged = (pageNum) => {
    getOrders(pageNum);
};

const roleUser = ref(null)

const getRole = async () => {
    try {
        const response = await api.get(`/api/admin/auth/user`);
        roleUser.value = response.data.users[0].role_id
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
}

onMounted(getRole)

const service = ref('Услуга');
const getServiceName = async () => {
    try {
        const response = await api.get(`/api/auth/client/service-name`);
        service.value = response.data.serviceNames;

    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
};
onMounted(getServiceName)

const carMultiselect = ref([]);
const statistic = ref('');

const postCarStatistic = async () => {
    const carName = {
        "carName": carMultiselect.value,
    };

    try {
        const response = await api.post(`/api/admin/auth/statistic/car-statistic`, carName);
        service.value = response.data;
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
};
watch(carMultiselect, (newVal, oldVal) => {
    if (newVal !== oldVal) {
        postCarStatistic();
    }
})

</script>

<style>
.panel-body {
    width: 100%;
}

.layout-top-spacing {
    width: 177%;
}
</style>

<style lang="css" scoped>

.align-top {
    vertical-align: top;
}

.icon-container button {
    background-color: transparent; /* Убираем фон кнопки */
    border: none; /* Убираем границу кнопки */
    padding: 0; /* Убираем внутренние отступы кнопки */
}

.feather-icon .icon-section {
    padding: 30px;
}

.feather-icon .icon-section h4 {
    color: #3b3f5c;
    font-size: 17px;
    font-weight: 600;
    margin: 0;
    margin-bottom: 16px;
}

.feather-icon .icon-content-container {
    padding: 0 16px;
    width: 96%;
    margin: 0 auto;
    border: 1px solid #bfc9d4;
    border-radius: 6px;
}

.feather-icon .icon-section p.fs-text {
    padding-bottom: 30px;
    margin-bottom: 30px;
}

.feather-icon .icon-container {
    cursor: pointer;
}

.feather-icon .icon-container svg {
    color: #3b3f5c;
    margin-right: 6px;
    vertical-align: middle;
    width: 19px;
    height: 19px;
    fill: rgba(0, 23, 55, 0.08);
}

.feather-icon .icon-container:hover svg {
    color: #4361ee;
    fill: rgba(27, 85, 226, 0.23921568627450981);
}

.feather-icon .icon-container span {
    display: none;
}

.feather-icon .icon-container:hover span {
    color: #4361ee;
}

.feather-icon .icon-link {
    color: #4361ee;
    font-weight: 600;
    font-size: 14px;
}

/*FAB*/
.fontawesome .icon-section {
    padding: 30px;
}

.fontawesome .icon-section h4 {
    color: #3b3f5c;
    font-size: 17px;
    font-weight: 600;
    margin: 0;
    margin-bottom: 16px;
}

.fontawesome .icon-content-container {
    padding: 0 16px;
    width: 96%;
    margin: 0 auto;
    border: 1px solid #bfc9d4;
    border-radius: 6px;
}

.fontawesome .icon-section p.fs-text {
    padding-bottom: 30px;
    margin-bottom: 30px;
}

.fontawesome .icon-container {
    cursor: pointer;
    height: 20px;
    width: 20px;
}

.fontawesome .icon-container i {
    font-size: 20px;
    color: #3b3f5c;
    vertical-align: middle;
    margin-right: 10px;
}

.fontawesome .icon-container:hover i {
    color: #4361ee;
}

.fontawesome .icon-container span {
    color: #888ea8;
    display: none;
}

.fontawesome .icon-container:hover span {
    color: #4361ee;
}

.fontawesome .icon-link {
    color: #4361ee;
    font-weight: 600;
    font-size: 14px;
}

.icon-container button {
    width: 30px; /* Задайте нужную ширину */
    height: 30px; /* Задайте нужную высоту */
}

</style>

<style src="../../../../../../node_modules/vue-multiselect/dist/vue-multiselect.css"></style>
