<template>

    <div class="row">
        <div class="col-lg-12 col-12 layout-spacing">
            <div class="statbox panel box box-shadow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>File Upload</h4>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <form enctype="multipart/form-data">

                        <div class="custom-file mb-3">

<!--                            <input id="video" type="file" ref="video" accept="video/*" class="custom-file-input" @change="onFileChange"/>-->
<!--                            <label for="video" data-browse="Обзор" class="custom-file-label">-->
<!--                                <span class="d-block form-file-text">{{-->
<!--                                        selectedFile ? selectedFile.name : 'Файл не выбран'-->
<!--                                    }}</span>-->
<!--                            </label>-->

                            <input id="files" type="file" ref="files" accept="image/*, video/*" class="custom-file-input" multiple @change="onFileChange"/>
<!--                            <input id="files" type="file" ref="files" accept="video/*" class="custom-file-input" @change="onFileChange"/>-->
                            <label for="files" data-browse="Обзор" class="custom-file-label">
                                <span class="d-block form-file-text">{{
                                        selectedFile ? selectedFile.name : 'Файл не выбран'
                                    }}</span>
                            </label>
                        </div>

                        <div id="imagePreview" class="custom-file-container__image-preview"></div>

                        <button class="btn btn-success mt-4" @click.prevent="uploadVideo">Отправить видео</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>
import {onMounted, ref} from "vue";

import "../../../assets/sass/scrollspyNav.scss";
import "../../../assets/sass/forms/file-upload-with-preview.min.css";

import {useMeta} from "../../../composables/use-meta";

useMeta({title: "File Upload"});

const code_arr = ref([]);

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

import api from "../../../api";
import {useRouter} from "vue-router";
import {forEach} from "vue3-number-spinner";

const selectedFile = ref(null);

function onFileChange(event) {
    selectedFile.value = event.target.files[0];
}

const files = ref([]);

const route = useRouter();

const orderId = route.currentRoute.value.params.orderId;

const uploadVideo = async () => {

    const formData = new FormData();

    // formData.append('file', files.value.files[0]);

    const fileList = Array.from(files.value.files);

    fileList.forEach((file, index) => {
        formData.append(`file[${index}]`, file);
    });

    // formData.append('file', fileList)

    try {
        const response = await api.post(`/api/station/auth/upload-video/${orderId}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        console.log('Видео успешно загружено:', response.data);
    } catch (error) {
        console.error('Ошибка при загрузке видео:', error);
    }
};

</script>
