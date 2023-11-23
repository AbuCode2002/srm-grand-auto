<template>
    <div class="container">
        <teleport to="#breadcrumb">
            <ul class="navbar-nav flex-row">
                <li>
                    <div class="page-header">
                        <nav class="breadcrumb-one" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:;">Budgets</a></li>
                            </ol>
                        </nav>
                    </div>
                </li>
            </ul>
        </teleport>

        <div class="container">
            <div v-scroll-spy class="row">
                <div id="chartColumnStacked" class="col-xl-12 layout-spacing">
                    <div class="statbox panel box box-shadow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>Статистика</h4>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <apexchart v-if="options" height="350" type="bar" :options="options"
                                       :series="series"></apexchart>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

import {computed, onMounted, ref} from "vue";
import "../../../assets/sass/scrollspyNav.scss";
import apexchart from "vue3-apexcharts";
import {useStore} from "vuex";
import {useMeta} from "../../../composables/use-meta";
import api from "../../../api";

useMeta({title: "Apex Chart"});

const store = useStore();

const code_arr = ref([]);

const options = computed(() => {
    const is_dark = store.state.is_dark_mode;
    return {
        chart: {stacked: true, toolbar: {show: false}},
        responsive: [{breakpoint: 480, options: {legend: {position: "bottom", offsetX: -10, offsetY: 5}}}],
        plotOptions: {bar: {horizontal: false}},
        xaxis: {
            categories: [regions.value]
            // categories: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16]
            // categories: ["01/01/2011 GMT", "01/02/2011 GMT", "01/03/2011 GMT", "01/04/2011 GMT", "01/05/2011 GMT", "01/06/2011 GMT", "01/07/2011 GMT"]
        },
        grid: {borderColor: is_dark ? "#191e3a" : "#e0e6ed"},
        fill: {opacity: 1},
        legend: {position: "right", offsetY: 40},
        tooltip: {theme: is_dark ? "dark" : "light"},
    };
});

const series = [
    {name: "PRODUCT A", data: [44, 55, 41, 67, 22, 43, 11, 23, 44, 55, 41, 67, 22, 43, 11, 23]},
    {name: "PRODUCT B", data: [13, 23, 20, 8, 13, 27, 12, 24, 13, 23, 20, 8, 13, 27, 12, 24]},
    {name: "PRODUCT C", data: [11, 17, 15, 15, 21, 14, 13, 25, 11, 17, 15, 15, 21, 14, 13, 25]},
    {name: "PRODUCT D", data: [21, 7, 25, 13, 22, 8, 14, 27, 21, 7, 25, 13, 22, 8, 14, 27]},
];

const series1 = ref([
    {name: "Budget", data: []},
    {name: "Used", data: []},
    {name: "Work Sum", data: []},
    {name: "Rest Sum", data: []},
    {name: "Rest Sum Not NDS", data: []},
    {name: "Rest Sum Not NDS Not Markup", data: []},
]);

const regions = ref([]);

const getManegers = async () => {
    try {
        const response = await api.get(`/api/admin/auth/region/parent-region`);

        response.data.regions.forEach((region) => {
            regions.value.push(region['region_name']);
            series1.value[0].data.push(region['budget']);
            series1.value[1].data.push(region['usedSum']);
            series1.value[2].data.push(region['workSum']);
            series1.value[3].data.push(region['restSum']);
            series1.value[4].data.push(region['restSumNotNDS']);
            series1.value[5].data.push(region['restSumNotNDSNotMarkup']);
        });

        // options.value.xaxis.categories = regions.value;
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
};

onMounted(getManegers)
</script>
