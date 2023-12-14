<template>
    <div v-if="roleUser != null" class="container">
        <div class="row layout-top-spacing">
            <div id="tableFooter" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox panel box box-shadow" style="position: absolute; !important;left: 23.5% !important;">
                    <div class="panel-heading">
                        <div class="row">
                            <div style="width: 200px;">
                                <h4>Статистика</h4>
                            </div>
                            <div style="width: 300px">
                                <vue-multiselect v-model="valueName" :options="servicePart"
                                                 placeholder="Вид работы">
                                </vue-multiselect>
                            </div>
                            <div v-if="valueName != null" style="width: 400px">
                                <vue-multiselect v-model="carMultiselect" :options="models" :multiple="true"
                                                 placeholder="Машина">
                                </vue-multiselect>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-checkable table-highlight-head table-responsive">
                            <table v-if="valueName === 'Услуга'" role="table" aria-busy="false" aria-colcount="5"
                                   class="table b-table table-striped table-hover table-bordered" id="__BVID__368">
                                <thead role="rowgroup" class="">
                                <tr role="row" class="">
                                    <th role="columnheader" scope="col" aria-colindex="1" class="text-success">
                                        <div>Услуга</div>
                                    </th>
                                    <th v-for="car in carMultiselect" :value="car" role="columnheader" scope="col"
                                        aria-colindex="2" class="text-success">
                                        <div>{{ car }}</div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody role="rowgroup">
                                <tr v-for="item in service" :value="item" role="row" class="">
                                    <td aria-colindex="1" role="cell" class="">{{ item.name }}</td>
                                    <td v-for="car in carMultiselect" :value="car">
                                        <td v-if="Object.keys(percentStatistic.service[car]).includes(item.name)"
                                            aria-colindex="2" role="cell" class="">
                                            {{ (percentStatistic.service[car][item.name] * 100).toFixed(2) + "%" }}
                                        </td>
                                        <td v-else aria-colindex="2" role="cell" class="">
                                            {{ '-' }}
                                        </td>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table v-if="valueName === 'Запчасть'" role="table" aria-busy="false" aria-colcount="5"
                                   class="table b-table table-striped table-hover table-bordered" id="__BVID__368">
                                <thead role="rowgroup" class="">
                                <tr role="row" class="">
                                    <th role="columnheader" scope="col" aria-colindex="1" class="text-success">
                                        <div>Запчасть</div>
                                    </th>
                                    <th v-for="car in carMultiselect" :value="car" role="columnheader" scope="col"
                                        aria-colindex="2" class="text-success">
                                        <div>{{ car }}</div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody role="rowgroup">
                                <tr v-for="item in part" :value="item" role="row" class="">
                                    <td aria-colindex="1" role="cell" class="">{{ item.name }}</td>
                                    <td v-for="car in carMultiselect" :value="car">
                                        <td v-if="Object.keys(percentStatistic.part[car]).includes(item.name)"
                                            aria-colindex="2" role="cell" class="">
                                            {{ (percentStatistic.part[car][item.name] * 100).toFixed(2) + "%" }}
                                        </td>
                                        <td v-else aria-colindex="2" role="cell" class="">
                                            {{ '-' }}
                                        </td>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table v-if="valueName === 'Категорий'" role="table" aria-busy="false" aria-colcount="5"
                                   class="table b-table table-striped table-hover table-bordered" id="__BVID__368">
                                <thead role="rowgroup" class="">
                                <tr role="row" class="">
                                    <th role="columnheader" scope="col" aria-colindex="1" class="text-success">
                                        <div>Запчасть</div>
                                    </th>
                                    <th v-for="car in carMultiselect" :value="car" role="columnheader" scope="col"
                                        aria-colindex="2" class="text-success">
                                        <div>{{ car }}</div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody role="rowgroup">
                                <tr v-for="item in category" :value="item" role="row" class="">
                                    <td aria-colindex="1" role="cell" class="">{{ item.name }}</td>
                                    <td v-for="car in carMultiselect" :value="car">
                                        <td v-if="Object.keys(percentStatistic.category[car]).includes(item.name)"
                                            aria-colindex="2" role="cell" class="">
                                            {{ (percentStatistic.category[car][item.name] * 100).toFixed(2) + "%" }}
                                        </td>
                                        <td v-else aria-colindex="2" role="cell" class="">
                                            {{ '-' }}
                                        </td>
                                    </td>
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

const code_arr = ref([]);
const order = ref([]);

onMounted(() => {
    initTooltip();
});

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

const pagination = ref({
    "last_page": 1
});
const currentPage = ref(1);

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

const carMultiselect = ref([]);
const models = ref([]);

const valueName = ref(null);
const servicePart = ref([
    'Услуга',
    'Запчасть',
    'Категорий',
]);

const percentStatistic = ref();

const getPercentStatistic = async () => {
    try {
        const response = await api.get(`/api/admin/auth/car/statistic`);
        percentStatistic.value = response.data;
        if (valueName.value === 'Услуга') {
            models.value = Object.keys(percentStatistic.value.service);
        }else if (valueName.value === 'Запчасть') {
            models.value = Object.keys(percentStatistic.value.part);
        }else if (valueName.value === 'Категорий') {
            models.value = Object.keys(percentStatistic.value.category);
        }

    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
};

onMounted(getPercentStatistic)

watch(carMultiselect, (newVal, oldVal) => {
    if (newVal !== oldVal) {
        getPercentStatistic();
    }
})

watch(valueName, (newVal, oldVal) => {
    if (newVal !== oldVal) {
        getPercentStatistic();
    }
})

const service = ref([]);

const getServiceName = async () => {
    try {
        const response = await api.get(`/api/auth/client/service-name`);
        service.value = response.data.serviceNames;
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
};

onMounted(getServiceName)

const part = ref([]);

const getPartName = async () => {
    try {
        const response = await api.get(`/api/auth/client/part-name`);
        part.value = response.data.partNames;
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
};

onMounted(getPartName)

const category = ref([]);

const getCategoryName = async () => {
    try {
        const response = await api.get(`/api/admin/auth/category-name`);
        category.value = response.data.categories;
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
};

onMounted(getCategoryName)

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
