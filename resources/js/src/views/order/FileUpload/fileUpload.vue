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

                            <input id="files" type="file" ref="files" accept="image/*, video/*" class="custom-file-input" multiple @change="onFileChange"/>
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

// const uploadVideo = async () => {
//     const fileList = Array.from(files.value.files);
//
//     for (const file of fileList) {
//         const video = document.createElement('video');
//         video.preload = 'metadata';
//         video.src = URL.createObjectURL(file);
//
//         video.onloadedmetadata = async () => {
//             const canvas = document.createElement('canvas');
//             const videoWidth = video.videoWidth;
//             const videoHeight = video.videoHeight;
//
//             canvas.width = 640; // Новая ширина
//             canvas.height = (640 / videoWidth) * videoHeight; // Сохранение пропорций
//
//             const ctx = canvas.getContext('2d');
//             ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
//
//             // Преобразование сжатого изображения в Blob и добавление к formData
//             canvas.toBlob(async (blob) => {
//                 const formData = new FormData();
//                 formData.append('file', blob, file.name);
//
//                 try {
//                     const response = await api.post(`/api/station/auth/upload-video/${orderId}`, formData);
//
//                     console.log('Видео успешно загружено:', response.data);
//                 } catch (error) {
//                     console.error('Ошибка при загрузке видео:', error);
//                 }
//             }, 'video/mp4', 0.7); // 0.7 - качество сжатия (0.0 - 1.0)
//         };
//     }
// };

const uploadVideo = async () => {

    const formData = new FormData();

    const fileList = Array.from(files.value.files);

    fileList.forEach((file, index) => {
        formData.append(`file[${index}]`, file);
    });

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

const route = useRouter();

const orderId = route.currentRoute.value.params.orderId;

</script>
