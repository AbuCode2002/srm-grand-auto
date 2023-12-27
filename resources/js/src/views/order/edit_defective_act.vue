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
                        <th role="columnheader" scope="col" aria-colindex="6" class="text-success">
                            <div>
                                <div class="feather-icon">
                                    <div style="display: inline-block;">
                                        <button class="custom-button" @click="addNewField">
                                            <i class="custom-field" data-feather="plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </th>
                    </tr>
                    </thead>

                    <tbody role="rowgroup" v-for="(field, fieldIndex) in fields">

                    <tr role="row" class="" :key="fieldIndex">
                        <td aria-colindex="1" role="cell" class="">
                            <div class="row">
                                <div class="col-md-auto">
                                    <vue-multiselect v-model="field.serviceNameModel" :options="service"
                                                     :custom-label="serviceNames"
                                                     placeholder="Услуга" class="custom-multiselect-field">
                                    </vue-multiselect>
                                </div>
                            </div>
                        </td>

                        <td aria-colindex="2" role="cell" class="">
                            <div class="row">
                                <div class="col-md-auto">
                                    <input type="number" v-model.number="field.count" placeholder="Количество"
                                           class="form-control success custom-input-field"
                                           style="height: 30px">
                                </div>
                            </div>
                        </td>

                        <td aria-colindex="3" role="cell" class="">
                            <div class="row">
                                <div class="col-md-auto">
                                    <vue-multiselect v-model="field.unitNameModel" :options="unit"
                                                     :custom-label="unitNames"
                                                     placeholder="Ед. измер." class="custom-multiselect-field">
                                    </vue-multiselect>
                                </div>
                            </div>
                        </td>

                        <td aria-colindex="4" role="cell" class="">
                            <div class="row">
                                <div class="col-md-auto">
                                    <input type="number" v-model.number="field.price" placeholder="Цена"
                                           class="form-control success custom-input-field"
                                           style="height: 30px">
                                </div>
                            </div>
                        </td>

                        <td aria-colindex="5" role="cell" class="">
                            <div class="row">
                                <div class="col-md-auto">
                                    <input type="number" v-model.number="field.procentSale" placeholder="Процент"
                                           class="form-control success custom-input-field"
                                           style="height: 30px"
                                    >
                                </div>
                            </div>
                        </td>

                        <td aria-colindex="6" role="cell" class="">
                            <div class="row">
                                <div class="feather-icon">
                                    <div style="display: inline-block;">
                                        <button class="custom-button" @click="removeField(fieldIndex)">
                                            <i class="custom-field" data-feather="trash"></i>
                                        </button>
                                    </div>
                                    <div style="display: inline-block;">
                                        <button class="custom-button" @click="addNewPart(fieldIndex)">
                                            <i class="custom-part" data-feather="plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </td>

                    </tr>

                    <tr v-for="(part, partIndex) in field.parts" :key="partIndex">

                        <td aria-colindex="1" role="cell" class="">
                            <div class="row">
                                <div class="col-md-auto">
                                    <vue-multiselect v-model="part.partNameModel" :options="parts"
                                                     :custom-label="serviceNames" placeholder="Запчасть"
                                                     class="custom-multiselect-part">
                                    </vue-multiselect>
                                </div>
                            </div>
                        </td>

                        <td aria-colindex="2" role="cell" class="">
                            <!-- Ваше поле для количества запчасти -->
                            <div class="row">
                                <div class="col-md-auto">
                                    <input type="number" v-model.number="part.partCount" placeholder="Количество"
                                           class="form-control success custom-input-part"
                                           style="height: 20px">
                                </div>
                            </div>
                        </td>
                        <td aria-colindex="3" role="cell" class="">
                            <!-- Ваши поля для единицы измерения запчасти -->
                            <div class="row">
                                <div class="col-md-auto">
                                    <vue-multiselect v-model="part.partUnitNameModel" :options="unit"
                                                     :custom-label="unitNames"
                                                     placeholder="Ед. измер." class="custom-multiselect-part">
                                    </vue-multiselect>
                                </div>
                            </div>
                        </td>
                        <td aria-colindex="4" role="cell" class="">
                            <!-- Ваше поле для цены запчасти -->
                            <div class="row">
                                <div class="col-md-auto">
                                    <input type="number" v-model.number="part.partPrice" placeholder="Цена"
                                           class="form-control success custom-input-part"
                                           style="height: 20px">
                                </div>
                            </div>
                        </td>

                        <td aria-colindex="5" role="cell" class="">
                            <!-- Ваше поле для цены запчасти -->
                            <div class="row">
                                <div class="col-md-auto">
                                    <input type="number" v-model.number="part.partProcentSale" placeholder="Процент"
                                           class="form-control success custom-input-part"
                                           style="height: 20px">
                                </div>
                            </div>
                        </td>
                        <td aria-colindex="6" role="cell" class="">
                            <div class="feather-icon">
                                <div style="display: inline-block;">
                                    <button class="custom-button" @click="removePart(fieldIndex, partIndex)">
                                        <i class="custom-part" data-feather="trash"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <td colspan="6" class="spacer-row" style="background: #4dcf8f;"></td>

                    </tbody>
                </table>
                <div class="account-settings-container">
                    <div class="as-footer-container">
                        <button type="button" class="btn btn-success" @click.prevent="postDefectiveAct()">Сохранить
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {onMounted, ref} from "vue";
import "../../assets/sass/scrollspyNav.scss";
import "../../assets/sass/users/account-setting.scss";
import {useMeta} from "../../composables/use-meta";
import api from "../../api";
import VueMultiselect from "vue-multiselect";

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

const parts = ref('Запчасть');

const getPartName = async () => {
    try {
        const response = await api.get(`/api/auth/client/part-name`);
        parts.value = response.data.partNames;
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

onMounted(getPartName);

const serviceNames = ({name}) => {
    return `${name}`;
};
const unitNames = ({unitName}) => {
    return `${unitName}`;
};

const removePart = (fieldIndex, partIndex) => {
    fields.value[fieldIndex].parts.splice(partIndex, 1);
};

const removeField = (fieldIndex) => {
    fields.value.splice(fieldIndex, 1);
};

const addNewField = () => {
    const newField = {
        serviceNameModel: null,
        count: null,
        unitNameModel: null,
        price: null,
        procentSale: null,
        parts: [
            {
                partNameModel: null,
                partCount: null,
                partUnitNameModel: null,
                partPrice: null,
                partProcentSale: null,
            },
        ],
    };

    fields.value.push(newField);

    setTimeout(feather.replace, 0);
};

const addNewPart = (fieldIndex) => {
    fields.value[fieldIndex].parts.push({
        partNameModel: null,
        partCount: null,
        partUnitNameModel: null,
        partPrice: null,
        partProcentSale: null,
    });

    setTimeout(feather.replace, 0);
};

import {useRouter} from "vue-router";

const route = useRouter();

const orderId = route.currentRoute.value.params.orderId;

const postDefectiveAct = async () => {

    const totalPrice = fields.value.reduce((total, field) => {
        return total + (field.price * field.count || 0);
    }, 0);

    const totalPartPrice = fields.value.reduce((total, field) => {
        const partPrice = field.parts.reduce((partTotal, part) => {
            return partTotal + (part.partPrice * part.partCount || 0);
        }, 0);

        return total + partPrice;
    }, 0);

    const totalProcent = fields.value.reduce((total, field) => {
        return total + (field.procentSale || 0);
    }, 0);

    const totalPartProcent = fields.value.reduce((total, field) => {
        const partPrice = field.parts.reduce((partTotal, part) => {
            return partTotal + (part.partProcentSale || 0);
        }, 0);

        return total + partPrice;
    }, 0);


    const defectiveAct = {
        "total": totalPrice + totalPartPrice,
        "total_procent": totalProcent + totalPartProcent,
        "service": [],
        "spare_parts": [],
    }

    fields.value.forEach((field, index) => {
        defectiveAct.service.push({
            "id": field.id || null,
            "name": field.serviceNameModel || null,//{'nullName':  {'id': 0, 'name': 'nullName'}},
            "count": field.count || null,//0,
            "unit": field.unitNameModel || null,//'nullName',
            "price": field.price || null,//0,
            "sale_percent": field.procentSale || null,//0,
        });

        const parts = field.parts;

        const partsData = parts.map(part => ({
            "id": part.partId || null,
            "name": part.partNameModel || null,
            "count": part.partCount || null,
            "unit": part.partUnitNameModel || null,
            "price": part.partPrice || null,
            "sale_percent": part.partProcentSale || null,
        }));

        defectiveAct.spare_parts.push(partsData);
    });

    try {
        await api.post(`/api/station/auth/defective-act/${orderId}`, defectiveAct);

        // route.push({name: 'status'});
        //
        // new window.Swal({
        //     title: "Saved succesfully",
        //     padding: "2em",
        // });

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
                        serviceNameModel: {name: item.serviceName && item.serviceName.name},
                        count: item.count,
                        unitNameModel: {unitName: item.unit},
                        price: item.price,
                        procentSale: item.sale_percent,
                        parts: item.sparePart.map(part => {
                            return {
                                partId: part.id,
                                partNameModel: {name: part.partNames && part.partNames.name},
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

<style src="vue-multiselect/dist/vue-multiselect.css">
.spacer-row {
    height: 2px;
}
</style>

<style lang="css" scoped>

.custom-button {
    background: rgba(0, 0, 0, 0.0);
}

.custom-field {
    color: #4dcf8f !important;
}

.custom-field:hover {
    color: #f09819 !important;
}

.custom-part {
    color: #2c7be5 !important;
}

.custom-part:hover {
    color: #f09819 !important;
}

.custom-input-field {
    border-color: #4dcf8f !important;
}

.custom-input-part {
    border-color: #2c7be5 !important;
}

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
