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
                            <input id="ufile" type="file" ref="video" accept="video/*" class="custom-file-input" @change="onFileChange"/>
                            <label for="ufile" data-browse="Обзор" class="custom-file-label">
                                <span class="d-block form-file-text">{{ selectedFile ? selectedFile.name : 'Файл не выбран' }}</span>
                            </label>
                        </div>

                        <div id="imagePreview" class="custom-file-container__image-preview"></div>

                        <button class="btn btn-success mt-4" @click="uploadVideo">Отправить видео</button>
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

const selectedFile = ref(null);

function onFileChange(event) {
    selectedFile.value = event.target.files[0];

}

const video = ref(null);

const uploadVideo = async () => {
    const formData = new FormData();
    formData.append('video', video.value.files[0]);

    console.log(formData)
    try {
        const response = await api.post(`/api/station/auth/upload-video/${1}`, formData, {
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
