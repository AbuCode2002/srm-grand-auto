<template>
    <div class="layout-px-spacing">
        <teleport to="#breadcrumb">
            <ul class="navbar-nav flex-row">
                <li>
                    <div class="page-header">
                        <nav class="breadcrumb-one" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:;">Users</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><span>Account Settings</span></li>
                            </ol>
                        </nav>
                    </div>
                </li>
            </ul>
        </teleport>

        <div class="account-settings-container layout-top-spacing">
            <div class="account-content">
                <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="work-experience" class="section work-experience">
                                <div class="info">
                                    <h5 class="">Work Experience</h5>
                                    <div class="row">
                                        <div class="col-md-12 text-end mb-5">
                                            <button type="button" id="add-work-exp" class="btn btn-primary">Add</button>
                                        </div>
                                        <div class="col-md-11 mx-auto">
                                            <div class="work-section">
                                                <div class="row">

                                                    <div class="col-md-12 mb-4">
                                                        <select v-model="selected" class="form-select w-100">
                                                            <option :value="null">Тип заявки</option>
                                                            <option v-for="item in applications" :value="item" :key="item">
                                                                {{ item.type }}
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-12 mb-4">
                                                        <select v-model="selected" class="form-select w-100">
                                                            <option :value="null">Номер контракта</option>
                                                            <option v-for="item in contracts" :value="item" :key="item">
                                                                {{ item.number_of_contract }}
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-12 mb-4">
                                                        <select v-model="selected" class="form-select w-100">
                                                            <option :value="null">Регион</option>
                                                            <option v-for="item in months" :value="item" :key="item">
                                                                {{ item }}
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-12 mb-4">
                                                        <select v-model="selected" class="form-select w-100">
                                                            <option :value="null">Водитель</option>
                                                            <option v-for="item in months" :value="item" :key="item">
                                                                {{ item }}
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-12 mb-4">
                                                        <select v-model="selected" class="form-select w-100">
                                                            <option :value="null">Тип водителя</option>
                                                            <option v-for="item in months" :value="item" :key="item">
                                                                {{ item }}
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-12 mb-4">
                                                        <select v-model="selected" class="form-select w-100">
                                                            <option :value="null">Пробег</option>
                                                            <option v-for="item in months" :value="item" :key="item">
                                                                {{ item }}
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <textarea placeholder="Описание" rows="10" class="form-control" style="height: 243px"></textarea>
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

            <div class="account-settings-footer">
                <div class="as-footer-container">
                    <button type="button" class="btn btn-primary">Reset All</button>
                    <button type="button" class="btn btn-success" @click="save()">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {onMounted, ref} from "vue";
import "../../assets/sass/scrollspyNav.scss";
import "../../assets/sass/users/account-setting.scss";

import { useMeta } from "../../composables/use-meta";
import api from "../../api";

    useMeta({ title: "Account Setting" });

    const selected = ref(null);
    const selected_file = ref(null);
    const ddl_1 = ref("20");
    const ddl_2 = ref("Jan");
    const ddl_3 = ref("1989");
    const ddl_4 = ref("May");
    const ddl_5 = ref("2009");
    const ddl_6 = ref("United States");
    const months = ref(["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]);
    const range_1 = ref(25);
    const range_2 = ref(50);
    const range_3 = ref(70);
    const range_4 = ref(60);

    const change_file = (event) => {
        selected_file.value = URL.createObjectURL(event.target.files[0]);
    };

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
        const response = await api.get('/api/client/contract');
        contracts.value = response.data.Contracts;
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
};

const regions = ref(null);

const getRegions = async () => {
    try {
        const response = await api.get('/api/client/region');
        contracts.value = response.data;
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
};

onMounted(getRegions);

</script>
