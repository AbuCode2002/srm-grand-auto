<template>
  <div class="layout-px-spacing">

    <div class="statbox panel box box-shadow">
      <div class="panel-body">
        <table role="table" aria-busy="false" aria-colcount="5"
               class="table b-table table-striped table-hover table-bordered" id="__BVID__368">

          <thead role="rowgroup" class="">
          <tr role="row" class="">
            <th role="columnheader" scope="col" aria-colindex="1" class="text-success">
              <div>Название</div>
            </th>
            <th role="columnheader" scope="col" aria-colindex="2" class="text-success">
              <div>Колличество</div>
            </th>
            <th role="columnheader" scope="col" aria-colindex="3" class="text-success">
              <div>Единица измерения</div>
            </th>
            <th role="columnheader" scope="col" aria-colindex="4" class="text-success">
              <div>Цена</div>
            </th>
            <th role="columnheader" scope="col" aria-colindex="5" class="text-success">
              <button @click="addNewField" class="btn btn-secondary">Еще</button>
            </th>
          </tr>
          </thead>

          <tbody role="rowgroup">
          <tr role="row" class="" v-for="(field, index) in fields" :key="index">

            <td aria-colindex="1" role="cell" class="">
              <div class="row">
                <div class="col-md-auto">
                  <vue-multiselect v-model="field.serviceNameModel" :options="service"
                                   :custom-label="serviceNames"
                                   placeholder="Запчасть">
                  </vue-multiselect>
                </div>
              </div>
            </td>

            <td aria-colindex="2" role="cell" class="">
              <div class="row">
                <div class="col-md-auto">
                  <input type="number" v-model.number="field.count" placeholder="Колличество"
                         class="form-control success"
                         style="height: 50px">
                </div>
              </div>
            </td>

            <td aria-colindex="3" role="cell" class="">
              <div class="row">
                <div class="col-md-auto">
                  <vue-multiselect v-model="field.unitNameModel" :options="unit"
                                   :custom-label="unitNames"
                                   placeholder="Ед. измерения">
                  </vue-multiselect>
                </div>
              </div>
            </td>

            <td aria-colindex="4" role="cell" class="">
              <div class="row">
                <div class="col-md-auto">
                  <input type="number" v-model.number="field.price" placeholder="Цена"
                         class="form-control success"
                         style="height: 50px">
                </div>
              </div>
            </td>

            <td aria-colindex="5" role="cell" class="">
              <div class="row">
                <div class="col-md-auto">
                  <button @click="removeField(index)" class="btn btn-danger">Удалить</button>
                </div>
              </div>
            </td>

          </tr>

          <tr v-for="(part, partIndex) in fields.parts" :key="partIndex">
            <td aria-colindex="1" role="cell" class="">
              <!-- Ваши поля для выбора запчасти -->
              <div class="row">
                <div class="col-md-auto">
                  <vue-multiselect v-model="part.serviceNameModel" :options="service"
                                   :custom-label="serviceNames"
                                   placeholder="Запчасть">
                  </vue-multiselect>
                </div>
              </div>
            </td>
            <td aria-colindex="2" role="cell" class="">
              <!-- Ваше поле для количества запчасти -->
              <div class="row">
                <div class="col-md-auto">
                  <input type="number" v-model.number="part.count" placeholder="Колличество"
                         class="form-control success"
                         style="height: 50px">
                </div>
              </div>
            </td>
            <td aria-colindex="3" role="cell" class="">
              <!-- Ваши поля для единицы измерения запчасти -->
              <div class="row">
                <div class="col-md-auto">
                  <vue-multiselect v-model="part.unitNameModel" :options="unit"
                                   :custom-label="unitNames"
                                   placeholder="Ед. измерения">
                  </vue-multiselect>
                </div>
              </div>
            </td>
            <td aria-colindex="4" role="cell" class="">
              <!-- Ваше поле для цены запчасти -->
              <div class="row">
                <div class="col-md-auto">
                  <input type="number" v-model.number="part.price" placeholder="Цена"
                         class="form-control success"
                         style="height: 50px">
                </div>
              </div>
            </td>
            <td aria-colindex="5" role="cell" class="">
              <button @click="addNewPart(index)" class="btn btn-secondary">Добавить запчасть</button>
            </td>
            <td aria-colindex="5" role="cell" class="">
              <button @click="removePart(index, partIndex)" class="btn btn-danger">Удалить</button>
            </td>
          </tr>
          </tbody>
        </table>
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

const serviceNameModel = ref({name: 'Услуга'});

const unitNameModel = ref({unitName: 'Ед. измерения'});

const service = ref('Услуга')
const count = ref(null)
const price = ref(null)
const unit = ref('Ед. измерения')

const getServiceName = async () => {
  try {
    const response = await api.get(`/api/auth/client/service-name`);
    service.value = response.data.serviceNames;

    unit.value = [
      {unitName:"Штук"},
      {unitName:"Литр"},
      {unitName:"Комплект"},
      {unitName:"Грамм"},
    ];
  } catch (error) {
    console.error('Ошибка при получении данных:', error);
  }
}

onMounted(getServiceName)

const serviceNames = ({name}) => {
  return `${name}`;
};
const unitNames = ({unitName}) => {
  return `${unitName}`;
};

const fields = ref([
  {
    serviceNameModel: null,
    count: null,
    unitNameModel: null,
    price: null,
    parts: [ // Массив для запчастей
      {
        partNameModel: null,
        partCount: null,
        partUnitNameModel: null,
        partPrice: null
      }
    ]
  }
]);

const addNewField = () => {
  fields.value.push({
    serviceNameModel: null,
    count: null,
    unitNameModel: null,
    price: null,
    parts: [] // Создаем пустой массив для запчастей
  });
};

const removeField = (index) => {
  fields.value.splice(index, 1);
};

const removePart = (fieldIndex, partIndex) => {
  fields.value[fieldIndex].parts.splice(partIndex, 1);
};

const addNewPart = (fieldIndex) => {
  fields.value[fieldIndex].parts.push({
    partNameModel: null,
    partCount: null,
    partUnitNameModel: null,
    partPrice: null
  });
};

</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>
