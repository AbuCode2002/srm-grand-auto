<template>
    <div class="layout-px-spacing">
        <div class="statbox panel box box-shadow">
            <div class="panel-body">
                <table role="table" aria-busy="false" aria-colcount="6"
                       class="table b-table table-bordered" id="__BVID__368">

                    <thead role="rowgroup" class="">
                    <tr role="row" class="table table-sm">
                        <th role="columnheader" scope="col" aria-colindex="1" class="text-success">
                            <div>Название</div>
                        </th>
                        <th role="columnheader" scope="col" aria-colindex="2" class="text-success">
                            <div>Количество</div>
                        </th>
                        <th role="columnheader" scope="col" aria-colindex="3" class="text-success">
                            <div>Единица измерения</div>
                        </th>
                        <th role="columnheader" scope="col" aria-colindex="4" class="text-success">
                            <div>Цена</div>
                        </th>
                        <th role="columnheader" scope="col" aria-colindex="5" class="text-success">
                            <div>Процент скидки</div>
                        </th>
                    </tr>
                    </thead>
                    <tbody role="rowgroup" v-for="(field, fieldIndex) in fields">

                    <tr role="row" class="" :key="fieldIndex">

                        <td aria-colindex="1" role="cell" class="">
                            <div class="text-success">{{
                                field.serviceNameModel ? field.serviceNameModel.name : ''

                              }}
                            </div>
                        </td>

                        <td aria-colindex="2" role="cell" class="">
                            <div class="text-success">{{ field.count }}</div>
                        </td>

                        <td aria-colindex="3" role="cell" class="">
                            <div class="text-success">{{
                                    field.unitNameModel ? field.unitNameModel.unitName : ''
                                }}
                            </div>
                        </td>

                        <td aria-colindex="4" role="cell" class="">
                            <div class="text-success">{{ field.price }}</div>
                        </td>

                        <td aria-colindex="5" role="cell" class="">
                            <div class="text-success">{{ field.procentSale }}</div>
                        </td>

                    </tr>

                    <tr v-for="(part, partIndex) in field.parts" :key="partIndex">

                        <td aria-colindex="1" role="cell" class="">
                            <div style="color: #2c7be5">{{ part.partNameModel ? part.partNameModel.name : '' }}</div>
                        </td>

                        <td aria-colindex="2" role="cell" class="">
                            <div style="color: #2c7be5">{{ part.partCount }}</div>
                        </td>
                        <td aria-colindex="3" role="cell" class="">
                            <div style="color: #2c7be5">{{
                                    part.partUnitNameModel ? part.partUnitNameModel.unitName : ''
                                }}
                            </div>
                        </td>
                        <td aria-colindex="4" role="cell" class="">
                            <div style="color: #2c7be5">{{ part.partPrice }}</div>
                        </td>

                        <td aria-colindex="5" role="cell" class="">
                            <div style="color: #2c7be5">{{ part.partProcentSale }}</div>
                        </td>
                    </tr>
                    <td colspan="6" class="spacer-row" style="background: #4dcf8f;"></td>

                    </tbody>
                </table>
                <div class="account-settings-container">

                    <div class="row">
                        <div class="col-6">
                            <div class="as-footer-container">
                                <button type="button" class="btn btn-success"
                                        @click.prevent="acceptOrRejectDefectact(accepted)">Принять
                                </button>
                            </div>
                        </div>

                        <div class="col-6 text-end">
                            <div class="as-footer-container">
                                <button type="button" class="btn btn-danger"
                                        @click.prevent="acceptOrRejectDefectact(rejected)">Отклонить
                                </button>
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
import "../../../assets/sass/scrollspyNav.scss";
import "../../../assets/sass/users/account-setting.scss";
import {useMeta} from "../../../composables/use-meta";
import api from "../../../api";

useMeta({title: "Дефектный акт"});

const service = ref('Услуга');
const count = ref(null);
const price = ref(null);
const unit = ref('Ед. измерения');

const fields = ref([
    {
        id: null,
        serviceNameModel: null,
        count: null,
        unitNameModel: null,
        price: null,
        procentSale: null,
        parts: [
            {
                partId: null,
                partNameModel: null,
                partCount: null,
                partUnitNameModel: null,
                partPrice: null,
                partProcentSale: null,
            }
        ]
    }
]);

const getServiceName = async () => {
    try {
        const response = await api.get(`/api/auth/client/service-name`);
        service.value = response.data.serviceNames;
        unit.value = [
            {unitName: "Штук"},
            {unitName: "Литр"},
            {unitName: "Комплект"},
            {unitName: "Грамм"},
            {unitName: "Метр"},
        ];
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
};

onMounted(getServiceName);

import {useRouter} from "vue-router";

const route = useRouter();

const orderId = route.currentRoute.value.params.orderId;

const accepted = ref('ДА на согласовании в отделе по работе с клиентами');

const rejected = ref('ДА акт не принят');

const acceptOrRejectDefectact = async (status) => {

    const order = {
        "id": orderId,
        "statusName": status,
    };

    try {
        await api.post('/api/manager/auth/order/edit', order);

        route.push({name: 'status'});

        if (status === accepted.value) {
            new window.Swal({
                title: "ДА передан клиенту на проверку",
                padding: "2em",
            });
        } else {
            new window.Swal({
                title: "ДА отклонен",
                padding: "2em",
            });
        }
    } catch (error) {
        new window.Swal({
            icon: "warning",
            title: "Ошибка",
            text: "Что то пошло не так!",
            padding: "2em"
        });
        console.error('Ошибка при получении данных:', error);
    }
}

import feather from 'feather-icons';

const mountFeatherIcons = () => {
    feather.replace();
};

onMounted(mountFeatherIcons);

const defectiveAct = ref([]);
const getDefectiveAct = async () => {
    try {
        const response = await api.get(`/api/station/auth/defective-act/show/${orderId}`);
        defectiveAct.value = response.data.defectiveActs;

        if (defectiveAct.value) {
            defectiveAct.value.map(item => {
                fields.value = item.service.map(item => {
                    return {
                        id: item.id,
                        serviceNameModel: {name: item.serviceName},
                        count: item.count,
                        unitNameModel: {unitName: item.unit},
                        price: item.price,
                        procentSale: item.sale_percent,
                        parts: item.sparePart.map(part => {
                            return {
                                partId: part.id,
                                partNameModel: {name: part.partNames.name},
                                partCount: part.count,
                                partUnitNameModel: {unitName: part.unit},
                                partPrice: part.price,
                                partProcentSale: part.sale_percent,
                            };
                        }),
                    }
                });
            })
            setTimeout(feather.replace, 0);
        }

    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
};

onMounted(getDefectiveAct);

</script>

<style src="../../../../../../node_modules/vue-multiselect/dist/vue-multiselect.css">
.spacer-row {
    height: 2px;
}
</style>

<style lang="css" scoped>

.custom-multiselect-field :deep(.multiselect__tags) {
    border-color: #4dcf8f;
}

.custom-multiselect-part :deep(.multiselect__tags) {
    border-color: #2c7be5;
}

.table th[aria-colindex] {
    border-top: 2px solid #4dcf8f !important;
}

</style>

<style scoped>

.icon-container button {
    background-color: transparent;
    border: none;
    padding: 0;
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
    width: 30px;
    height: 30px;
}

</style>
