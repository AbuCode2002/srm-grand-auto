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
                            <div>Количество</div>
                        </th>
                        <th role="columnheader" scope="col" aria-colindex="3" class="text-success">
                            <div>Единица измерения</div>
                        </th>
                        <th role="columnheader" scope="col" aria-colindex="4" class="text-success">
                            <div>Цена</div>
                        </th>
                        <th role="columnheader" scope="col" aria-colindex="5" class="text-success">
                            <div>
                              <button @click="addNewField" class="btn btn-success btn-sm">Добавить услугу</button>
                            </div>
                        </th>
                        <th role="columnheader" scope="col" aria-colindex="6" class="text-success"></th>

                    </tr>
                    </thead>

                    <tbody role="rowgroup" v-for="(field, fieldIndex) in fields">
                    <tr role="row" class="" :key="fieldIndex">
                        <td aria-colindex="1" role="cell" class="">
                            <div class="row">
                                <div class="col-md-auto">
                                    <vue-multiselect v-model="field.serviceNameModel" :options="service"
                                                     :custom-label="serviceNames"
                                                     placeholder="Услуга">
                                    </vue-multiselect>
                                </div>
                            </div>
                        </td>

                        <td aria-colindex="2" role="cell" class="">
                            <div class="row">
                                <div class="col-md-auto">
                                    <input type="number" v-model.number="field.count" placeholder="Количество"
                                           class="form-control success"
                                           style="height: 30px">
                                </div>
                            </div>
                        </td>

                        <td aria-colindex="3" role="cell" class="">
                            <div class="row">
                                <div class="col-md-auto">
                                    <vue-multiselect v-model="field.unitNameModel" :options="unit"
                                                     :custom-label="unitNames"
                                                     placeholder="Ед. измер.">
                                    </vue-multiselect>
                                </div>
                            </div>
                        </td>

                        <td aria-colindex="4" role="cell" class="">
                            <div class="row">
                                <div class="col-md-auto">
                                    <input type="number" v-model.number="field.price" placeholder="Цена"
                                           class="form-control success"
                                           style="height: 30px">
                                </div>
                            </div>
                        </td>

                        <td aria-colindex="5" role="cell" class="">
                            <div class="row">
                                <div class="col-md-auto">
                                  <button @click="addNewPart(fieldIndex)" class="btn btn-success btn-sm">Добавить запчасть</button>
                                  <button @click="removeField(fieldIndex)" class="btn btn-danger btn-sm m-lg-1">Удалить</button>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr v-for="(part, partIndex) in field.parts" :key="partIndex" >
                      <td aria-colindex="1" role="cell" class="">
                        <div class="row">
                          <div class="col-md-auto">
                          </div>
                        </div>
                      </td>

                      <td aria-colindex="2" role="cell" class="">
                        <div class="row">
                          <div class="col-md-auto">
                            <vue-multiselect v-model="part.partNameModel" :options="service" :custom-label="serviceNames" placeholder="Запчасть">
                            </vue-multiselect>
                          </div>
                        </div>
                      </td>

                      <td aria-colindex="3" role="cell" class="">
                        <!-- Ваше поле для количества запчасти -->
                        <div class="row">
                          <div class="col-md-auto">
                            <input type="number" v-model.number="part.partCount" placeholder="Количество"
                                   class="form-control success"
                                   style="height: 20px">
                          </div>
                        </div>
                      </td>
                      <td aria-colindex="4" role="cell" class="">
                        <!-- Ваши поля для единицы измерения запчасти -->
                        <div class="row">
                          <div class="col-md-auto">
                            <vue-multiselect v-model="part.partUnitNameModel" :options="unit"
                                             :custom-label="unitNames"
                                             placeholder="Ед. измер.">
                            </vue-multiselect>
                          </div>
                        </div>
                      </td>
                      <td aria-colindex="5" role="cell" class="">
                        <!-- Ваше поле для цены запчасти -->
                        <div class="row">
                          <div class="col-md-auto">
                            <input type="number" v-model.number="part.partPrice" placeholder="Цена"
                                   class="form-control success"
                                   style="height: 20px">
                          </div>
                        </div>
                      </td>
                      <td aria-colindex="6" role="cell" class="">
                        <button @click="removePart(fieldIndex, partIndex)" class="btn btn-danger btn-sm">Удалить запчасть</button>
                      </td>
                    </tr>
                    <td colspan="6" class="spacer-row" style="background: #060818;"></td>
                    </tbody>
                </table>
              <div class="account-settings-container">
                <div class="as-footer-container">
                  <button type="button" class="btn btn-success" @click.prevent="postDefectiveAct()">Save Changes</button>
                </div>
              </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import "../../assets/sass/scrollspyNav.scss";
import "../../assets/sass/users/account-setting.scss";
import { useMeta } from "../../composables/use-meta";
import api from "../../api";
import VueMultiselect from "vue-multiselect";
import router from "../../router";

useMeta({ title: "Дефектный акт" });

const serviceNameModel = ref({ name: 'Услуга' });
const unitNameModel = ref({ unitName: 'Ед. измерения' });
const service = ref('Услуга');
const count = ref(null);
const price = ref(null);
const unit = ref('Ед. измерения');

const fields = ref([
  {
    serviceNameModel: null,
    count: null,
    unitNameModel: null,
    price: null,
    parts: [
      {
        partNameModel: null,
        partCount: null,
        partUnitNameModel: null,
        partPrice: null
      }
    ]
  }
]);

const getServiceName = async () => {
    try {
        const response = await api.get(`/api/auth/client/service-name`);
        service.value = response.data.serviceNames;
        unit.value = [
            { unitName: "Штук" },
            { unitName: "Литр" },
            { unitName: "Комплект" },
            { unitName: "Грамм" },
        ];
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
};

onMounted(getServiceName);

const serviceNames = ({ name }) => {
    return `${name}`;
};
const unitNames = ({ unitName }) => {
    return `${unitName}`;
};

const removePart = (fieldIndex,partIndex) => {
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
    parts: [
      {
        partNameModel: null,
        partCount: null,
        partUnitNameModel: null,
        partPrice: null,
      },
    ],
  };
  fields.value.push(newField);
};

const addNewPart = (fieldIndex) => {
    fields.value[fieldIndex].parts.push({
        partNameModel: null,
        partCount: null,
        partUnitNameModel: null,
        partPrice: null,
    });
};

const postDefectiveAct = async () => {

  // const order = {
  //   "serviceNameModel": serviceNameModel.value ? serviceNameModel : 1,
  //   "count": count.value ? count : 1,
  //   "unitNameModel": unitNameModel.value ? unitNameModel : 1,
  //   "price": price.value ? price : 1,
  //   "parts.partCount": fields.parts.partCount.value ? serviceNameModel : 1,
  //   "parts.partNameModel": fields.parts.partNameModel.value ? serviceNameModel : 1,
  //   "parts.partPrice": fields.parts.partPrice.value ? fields.parts.partPrice : 1,
  // };

  console.log(fields.value)
  // try {
  //   const response = await api.post('/api/auth/client/order', order);
  //   regions.value = response.data.regions;
  //
  //   new window.Swal({
  //     title: "Saved succesfully",
  //     padding: "2em",
  //   });
  // } catch (error) {
  //   new window.Swal({
  //     icon: "warning",
  //     title: "Ошибка",
  //     text: "Что то пошло не так!",
  //     padding: "2em"
  //   });
  //   console.error('Ошибка при получении данных:', error);
  // }
}

</script>

<style src="vue-multiselect/dist/vue-multiselect.css">
.spacer-row {
  height: 2px; /* Высота отступа */
}
</style>
