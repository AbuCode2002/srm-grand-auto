<template>
    <div class="layout-px-spacing">
        <teleport to="#breadcrumb">
            <ul class="navbar-nav flex-row">
                <li>
                    <div class="page-header">
                        <nav class="breadcrumb-one" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page"><span>Statistic</span></li>
                            </ol>
                        </nav>
                    </div>
                </li>
            </ul>
        </teleport>

        <div class="row">
            <div class="col-lg-12 layout-spacing layout-top-spacing">
                <div class="statbox panel box box-shadow">
                    <div class="panel-heading">
                        <div class="position-relative">
                            <div class="col-sm-2">
                                <h4>{{ $t('KPI_manager') }}</h4>
                            </div>
                            <div class="position-absolute top-0 end-0">
                                <button @click.prevent="selectDate" class="btn btn-success">Выбрать дату</button>
                            </div>
                        </div>
                    </div>

                    <div v-if="seeDate === 1" style="position: absolute; top: 90px; right: 47px;">
                        <VDatePicker v-model.range="range" class=""/>
                    </div>

                    <div class="parent ex-1">
                        <div class="row">
                            <div class="col-sm-12">
                                <draggable class="drag-drop dragula" group="default" ghost-class="gu-transit"
                                           drag-class="el-drag-ex-1" :animation="200">
                                    <div v-for="(manager, index) in managers"
                                         class="media d-md-flex d-block text-sm-start text-center">
                                        <div class="media-body">
                                            <div class="d-xl-flex d-block justify-content-between">
                                                <div class="">
                                                    <h6 class="">{{ manager.name }}</h6>
                                                </div>
                                                <div>
                                                    <div style="border-color: #4dcf8f" size="sm">{{kpi[index]}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </draggable>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
.panel {
    padding: 0;
}
</style>

<script setup>
import {onMounted, ref, watch} from "vue";
import "../../../assets/sass/scrollspyNav.scss";
import "../../../assets/sass/drag-drop/drag-drop.css";
import {VueDraggableNext as draggable} from "vue-draggable-next";

import {useMeta} from "../../../composables/use-meta";
import api from "../../../api";

useMeta({title: "Drag & Drop"});

const code_arr = ref([]);
const toggleCode = (name) => {
    if (code_arr.value.includes(name)) {
        code_arr.value = code_arr.value.filter((d) => d != name);
    } else {
        code_arr.value.push(name);
    }
};

const managers = ref([])
const getManegers = async () => {
    try {
        const response = await api.get(`/api/admin/auth/all-manager`);
        managers.value = response.data.users;
        console.log(response.data.users)
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
};

onMounted(getManegers)

const range = ref({
    start: new Date(),
    end: new Date(),
});

const kpi = ref('')

const postCalendar = async () => {
    try {
        seeDate.value = 0
        const response = await api.post(`/api/admin/auth/statistic/kpi`, range.value);
        kpi.value = response.data

    } catch (error) {
        console.error('Ошибка при отправке данных:', error);
    }
}
watch(range, (newVal, oldVal) => {
    if (newVal !== oldVal) {
        postCalendar();
    }
})

const seeDate = ref(0)

const selectDate = async () => {
    try {
        seeDate.value = 1
    } catch (error) {
        console.error('Ошибка при отправке данных:', error);
    }
}

</script>
