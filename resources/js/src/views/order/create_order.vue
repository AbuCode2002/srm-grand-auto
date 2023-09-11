<template>
    <div class="layout-px-spacing">
        <teleport to="#breadcrumb">
            <ul class="navbar-nav flex-row">
                <li>
                    <div class="page-header">
                        <nav class="breadcrumb-one" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:;">Users</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><span>Account Settings</span>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </li>
            </ul>
        </teleport>

        <div class="account-settings-container layout-top-spacing">
            <div class="account-content">
                <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll"
                     data-offset="-100">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="work-experience" class="section work-experience">
                                <div class="info">
                                    <h5 class="">Создания заявки</h5>
                                    <div class="row">
                                        <div class="col-md-11 mx-auto">
                                            <div class="work-section">
                                                <div class="row">

                                                    <div class="col-md-12 mb-4">
                                                        <select v-model="selectedApplication" class="form-select w-100">
                                                            <option :value="null">Тип заявки</option>
                                                            <option v-for="item in applications" :value="item">
                                                                {{ item.type }}
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-12 mb-4">
                                                        <select v-model="selectedContracts" class="form-select w-100">
                                                            <option :value="null">Номер контракта</option>
                                                            <option v-for="item in contracts" :value="item">
                                                                {{ item.number_of_contract }}
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-12 mb-4">
                                                        <vue-multiselect v-model="carModel" :options="cars"
                                                                         :custom-label="nameCar"
                                                                         placeholder="Гос. Номер">
                                                        </vue-multiselect>
                                                    </div>

                                                    <div class="col-md-12 mb-4">
                                                        <select v-model="selectedRegion" class="form-select w-100">
                                                            <option :value="null">Регион</option>
                                                            <option v-for="item in regions" :value="item">
                                                                {{ item.region_name }}
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-12 mb-4">
                                                        <vue-multiselect v-model="driverModel" :options="drivers"
                                                                         :custom-label="nameDriver"
                                                                         placeholder="Водитель"></vue-multiselect>
                                                    </div>

                                                    <div class="col-md-12 mb-3">
                                                        <select v-model="selectedTypeDriver" class="form-select w-100">
                                                            <option :value="null">Тип водителя</option>
                                                            <option v-for="item in typeDriver" :value="item">
                                                                {{ item.name }}
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="col-12 s-success">
                                                        <h6 class="text-success">Машина исправна?</h6>
                                                    </div>

                                                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                                        <label class="switch s-success mb-4 me-2">
                                                            <input type="checkbox" :checked="isChecked"
                                                                   @change="toggleCheckbox"/>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>

                                                    <div class="col-md-12 mb-4">
                                                        <input v-model="mileage" placeholder="Пробег"
                                                               class="form-control success"
                                                               style="height: 50px">
                                                    </div>

                                                    <div class="col-md-12 mb-1">
                                                        <textarea v-model="description" placeholder="Описание" rows="10"
                                                                  class="form-control"
                                                                  style="height: 243px"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

                        <div class="account-settings-container">
                            <div class="as-footer-container">
                                <button type="button" class="btn btn-success" @click.prevent="postOrder()">Save Changes</button>
                            </div>
                        </div>
        </div>
    </div>
</template>

<script setup>
import {onMounted, ref, watch} from "vue";
import "../../assets/sass/scrollspyNav.scss";
import "../../assets/sass/users/account-setting.scss";

import {useMeta} from "../../composables/use-meta";
import api from "../../api";
import VueMultiselect from 'vue-multiselect'
import router from "../../router";

useMeta({title: "Account Setting"});


const selectedApplication = ref(null);
const selectedContracts = ref(null);
const selectedRegion = ref(null);
const selectedTypeDriver = ref(null);
const description = ref(null);
const mileage = ref(null);

const save = () => {
    showMessage("Settings saved successfully.");
};

const showMessage = (msg = "", type = "success") => {
    const toast = window.Swal.mixin({
        toast: true,
        position: "top",
        showConfirmButton: false,
        timer: 3000,
    });
    toast.fire({
        icon: type,
        title: msg,
        padding: "10px 20px",
    });
};

const applications = ref(null);

const getApplications = async () => {
    try {
        const response = await api.get('/api/auth/client/application');
        applications.value = response.data.applications;
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
};

onMounted(getApplications);

const contracts = ref(null);

const getContracts = async () => {
    try {
        const response = await api.get('/api/auth/client/contract');
        contracts.value = response.data.contracts;
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
};

onMounted(getContracts);

const regions = ref(null);

const getRegions = async () => {
    try {
        const response = await api.get('/api/auth/client/region');
        regions.value = response.data.regions;
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
};

onMounted(getRegions);

const driverModel = ref({name: 'Водитель'});
const drivers = ref('Водитель');

const getDrivers = async () => {
    try {
        const response = await api.get('/api/auth/client/driver');
        drivers.value = response.data.drivers;
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
};
const nameDriver = ({name}) => {
    return `${name}`;
};

onMounted(getDrivers);

const carModel = ref({number: 'Гос. номер'});
const cars = ref('Гос. номер');

const getCars = async () => {
    try {
        const response = await api.get('/api/auth/client/car');
        cars.value = response.data.cars;
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
};


const nameCar = ({number}) => {
    return `${number}`;
};

onMounted(getCars);

const typeDriver = [
    {name: 'Водитель'},
    {name: 'Механик'},
];


const postOrder = async () => {
    const order = {
        "car_id": carModel.value ? carModel.value.id : null,
        "region_id": selectedRegion.value ? selectedRegion.value.id : null,
        "is_evacuated": 0,
        "contract_id": selectedContracts.value ? selectedContracts.value.id : null,
        "problem_description": description.value,
        "is_broken": isChecked.value ? 1 : 0,
        "service_type": selectedApplication.value ? selectedApplication.value.type : null,
        "driver_id": driverModel.value ? driverModel.value.id : null,
        "driver_type": selectedTypeDriver.value ? selectedTypeDriver.value.name : null,
        "mileage": mileage.value,
    };
    try {
        const response = await api.post('/api/auth/client/order', order);
        regions.value = response.data.regions;

        console.log(router.push({name: 'Home'}));

        new window.Swal({
            title: "Saved succesfully",
            padding: "2em",
        });
    } catch (error) {
        new window.Swal({
            icon: "warning",
            title: "Ошибка",
            text: "Что то пошло не так!",
            padding: "2em"
        });
        console.error('Ошибка при получении данных:', error);
    }
};

const isChecked = ref(true);

const toggleCheckbox = () => {
    isChecked.value = !isChecked.value;
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>
