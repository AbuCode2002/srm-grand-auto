<template>
        <div class="container">
            <div class="row layout-top-spacing">
                <div id="tableFooter" class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox panel box box-shadow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>Заявки</h4>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-checkable table-highlight-head table-responsive">
                                <table role="table" aria-busy="false" aria-colcount="5"
                                       class="table b-table table-striped table-hover table-bordered" id="__BVID__368">
                                    <thead role="rowgroup" class="">
                                    <tr role="row" class="">
                                        <th role="columnheader" scope="col" aria-colindex="1" class="text-success">
                                            <div>ID</div>
                                        </th>
                                        <th role="columnheader" scope="col" aria-colindex="2" class="text-success">
                                            <div>Клиент</div>
                                        </th>
                                        <th role="columnheader" scope="col" aria-colindex="3" class="text-success">
                                            <div>Госномер</div>
                                        </th>
                                        <th role="columnheader" scope="col" aria-colindex="4" class="text-success">
                                            <div>Марка</div>
                                        </th>
                                        <th role="columnheader" scope="col" aria-colindex="5" class="text-success">
                                            <div>Модель</div>
                                        </th>
                                        <th role="columnheader" scope="col" aria-colindex="6" class="text-success">
                                            <div>Год производства</div>
                                        </th>
                                        <th role="columnheader" scope="col" aria-colindex="7" class="text-success">
                                            <div>Статус заявки</div>
                                        </th>
                                        <th role="columnheader" scope="col" aria-colindex="8" class="text-success">
                                            <div>Местоположение машины</div>
                                        </th>
                                        <th role="columnheader" scope="col" aria-colindex="9" class="text-success">
                                            <div>Итоговая сумма по ДА</div>
                                        </th>
                                        <th role="columnheader" scope="col" aria-colindex="10" class="text-success">
                                            <div>Тип услуги</div>
                                        </th>
                                        <th role="columnheader" scope="col" aria-colindex="11" class="text-success">
                                            <div>Пробег машины</div>
                                        </th>
                                        <th role="columnheader" scope="col" aria-colindex="12" class="text-success">
                                            <div>Состояние машины</div>
                                        </th>
                                        <th role="columnheader" scope="col" aria-colindex="13" class="text-success">
                                            <div>Дата создания заявки</div>
                                        </th>
                                        <th role="columnheader" scope="col" aria-colindex="14" class="text-success">
                                            <div>Номер договора</div>
                                        </th>
                                        <th role="columnheader" scope="col" aria-colindex="15" class="text-success">
                                            <div>Номер телефона СТО</div>
                                        </th>
                                        <th role="columnheader" scope="col" aria-colindex="16" class="text-success">
                                            <div>Точное местоположение</div>
                                        </th>
                                        <th role="columnheader" scope="col" aria-colindex="17" class="text-success">
                                            <div>Дата подписания</div>
                                        </th>
                                        <th role="columnheader" scope="col" aria-colindex="18" class="text-success">
                                            <div>Дата истечения</div>
                                        </th>
                                        <th role="columnheader" scope="col" aria-colindex="19" class="text-success">
                                            <div>Действие</div>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody role="rowgroup">
                                    <tr v-for="item in order" :value="item" role="row" class="">
                                        <td aria-colindex="1" role="cell" class="mb-4">
                                            <button @click.prevent="getRegionId(item.region.id, item.id)"
                                                    class="btn btn-success mb-2 me-1">
                                                {{ item.id }}
                                            </button>
                                        </td>
                                        <td aria-colindex="2" role="cell" class="">{{ item.users[0].email }}</td>
                                        <td aria-colindex="3" role="cell" class="">{{ item.car.number }}</td>
                                        <td aria-colindex="4" role="cell" class="">{{ item.car.brand }}</td>
                                        <td aria-colindex="5" role="cell" class="">{{ item.car.model }}</td>
                                        <td aria-colindex="6" role="cell" class="">{{ item.car.year }}</td>
                                        <td aria-colindex="7" role="cell" class="">{{ item.status.name }}</td>
                                        <td aria-colindex="8" role="cell" class="">{{ item.region.region_name }}</td>
                                        <td aria-colindex="9" role="cell" class="">
                                            {{
                                                item.defect_acts ? item.defect_acts.defect_parts[0] ? item.defect_acts.defect_parts[0].sum : '-' : '-'
                                            }}
                                        </td>
                                        <td aria-colindex="10" role="cell" class="">{{ item.service_type }}</td>
                                        <td aria-colindex="11" role="cell" class="">{{ item.mileage }}</td>
                                        <td v-if="item.is_broken === 1" aria-colindex="12" role="cell" class="">
                                            Исправна
                                        </td>
                                        <td v-else aria-colindex="12" role="cell" class="">Не исправна</td>
                                        <td aria-colindex="13" role="cell" class="">{{ item.created_at }}</td>
                                        <td aria-colindex="14" role="cell" class="">{{
                                                item.contract.number_of_contract
                                            }}
                                        </td>
                                        <td aria-colindex="15" role="cell" class="">
                                            {{ item.station?.contact_phone ?? 'Нет данных' }}
                                        </td>
                                        <td aria-colindex="16" role="cell" class="">{{ item.region.region_name }}</td>
                                        <td aria-colindex="17" role="cell" class="">{{ item.contract.signed_at }}</td>
                                        <td aria-colindex="18" role="cell" class="">{{ item.contract.expire_at }}</td>
                                        <td aria-colindex="19" role="cell" class="">
                                            <div class="feather-icon">
                                                <div style="display: inline-block;">
                                                    <button class="" @click="removePart(fieldIndex, partIndex)">
                                                        <i class="" data-feather="trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
<!--                                        <td aria-colindex="19" role="cell" class="text-center">-->
<!--                                            <ul class="table-controls">-->
<!--                                                <li>-->
<!--                                                    <a href="javascript:void(0);" data-bs-toggle="tooltip" title="Edit">-->
<!--                                                        <svg-->
<!--                                                            xmlns="http://www.w3.org/2000/svg"-->
<!--                                                            width="24"-->
<!--                                                            height="24"-->
<!--                                                            viewBox="0 0 24 24"-->
<!--                                                            fill="none"-->
<!--                                                            stroke="currentColor"-->
<!--                                                            stroke-width="2"-->
<!--                                                            stroke-linecap="round"-->
<!--                                                            stroke-linejoin="round"-->
<!--                                                            class="feather feather-edit-2 text-success"-->
<!--                                                        >-->
<!--                                                            <path-->
<!--                                                                d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>-->
<!--                                                        </svg>-->
<!--                                                    </a>-->
<!--                                                </li>-->
<!--                                                <li>-->
<!--                                                    <a href="javascript:void(0);" data-bs-toggle="tooltip"-->
<!--                                                       title="Delete">-->
<!--                                                        <svg-->
<!--                                                            xmlns="http://www.w3.org/2000/svg"-->
<!--                                                            width="24"-->
<!--                                                            height="24"-->
<!--                                                            viewBox="0 0 24 24"-->
<!--                                                            fill="none"-->
<!--                                                            stroke="currentColor"-->
<!--                                                            stroke-width="2"-->
<!--                                                            stroke-linecap="round"-->
<!--                                                            stroke-linejoin="round"-->
<!--                                                            class="feather feather-trash-2 text-danger"-->
<!--                                                        >-->
<!--                                                            <polyline points="3 6 5 6 21 6"></polyline>-->
<!--                                                            <path-->
<!--                                                                d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>-->
<!--                                                            <line x1="10" y1="11" x2="10" y2="17"></line>-->
<!--                                                            <line x1="14" y1="11" x2="14" y2="17"></line>-->
<!--                                                        </svg>-->
<!--                                                    </a>-->
<!--                                                </li>-->
<!--                                            </ul>-->
<!--                                        </td>-->
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="panel-body text-center">
                            <div class="paginating-container pagination-solid flex-column align-items-center">
                                <paginate
                                    :page-count="pagination.last_page"
                                    :page-range="3"
                                    :margin-pages="2"
                                    :click-handler="pageChanged"
                                    :prev-text="'Prev'"
                                    :next-text="'Next'"
                                    :container-class="'pagination mb-4 b-pagination'"
                                    :page-class="'page-item'"
                                    :prev-class="'page-item prev'"
                                    :next-class="'page-item next'"
                                    :current-page="currentPage"
                                    :prev-icon="prevIcon"
                                    :next-icon="nextIcon"
                                ></paginate>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

</template>

<script setup>
import {ref, onMounted} from "vue";

import "../../assets/sass/scrollspyNav.scss";
import "../../assets/sass/tables/table-basic.scss";

import {useMeta} from "../../composables/use-meta";
import api from "../../api";
import Paginate from "vuejs-paginate-next";

import {useStore} from 'vuex';

const store = useStore();


useMeta({title: "Tables"});

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


const router = useRouter();

const getRegionId = (regionId, orderId) => {
    router.push({name: 'order-index-station', params: {regionId, orderId}});
};


const pagination = ref({
    "last_page": 1
});
const currentPage = ref(1);

const getOrders = async (page = 1) => {
    try {
        const response = await api.get(`/api/auth/client/order?page=${page}`);
        order.value = response.data.data;
        pagination.value = response.data;
        currentPage.value = page;
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
};

onMounted(getOrders)

const pageChanged = (pageNum) => {
    getOrders(pageNum);
};

import feather from 'feather-icons';

const mountFeatherIcons = () => {
    feather.replace();
};

onMounted(mountFeatherIcons);

const pushToDefectiveAct = () => {
    // Обработка клика на иконке "Edit"
    // Вставьте вашу логику здесь
}
</script>

<style>
.panel-body {
    width: 100%;
}

.layout-top-spacing {
    width: 177%;
}

@import "https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css";

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

