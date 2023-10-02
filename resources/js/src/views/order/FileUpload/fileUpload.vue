<template>
<!--    <div id="fuMultipleFile" class="col-lg-12 layout-spacing">-->
<!--        <div class="statbox panel box box-shadow">-->
<!--            <div class="panel-heading">-->
<!--                <div class="row">-->
<!--                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">-->
<!--                        <h4>Загрузите видео</h4>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="panel-body">-->
<!--                <div class="custom-file-container" data-upload-id="mySecondImage">-->
<!--                    <label>Upload (Allow Multiple) <a href="javascript:void(0)"-->
<!--                                                      class="custom-file-container__image-clear"-->
<!--                                                      title="Clear Image">x</a></label>-->
<!--                    <label class="custom-file-container__custom-file">-->
<!--                        <input type="file" ref="video" accept="video/*" class="custom-file-container__custom-file__custom-file-input" multiple @change="uploadVideo"/>-->
<!--                        <input type="hidden" name="MAX_FILE_SIZE" value="10485760"/>-->
<!--                        <span class="custom-file-container__custom-file__custom-file-control"></span>-->
<!--                    </label>-->
<!--                    <div class="custom-file-container__image-preview"></div>-->
<!--                </div>-->
<!--                <button @click="uploadVideo">Отправить видео</button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->

    <div class="panel-body">
        <div class="custom-file-container" data-upload-id="mySecondImage">
            <label>Upload (Allow Multiple) <a href="javascript:void(0)"
                                              class="custom-file-container__image-clear"
                                              title="Clear Image">x</a></label>
            <label class="custom-file-container__custom-file">
                <input type="file" ref="video" accept="video/*" class="custom-file-container__custom-file__custom-file-input" multiple @change="uploadVideo"/>
                <input type="hidden" name="MAX_FILE_SIZE" value="10485760"/>
                <span class="custom-file-container__custom-file__custom-file-control"></span>
            </label>
            <div class="custom-file-container__image-preview"></div>
        </div>
        <button @click="uploadVideo">Отправить видео</button>
    </div>

        <div>
            <form @submit.prevent="uploadVideo" enctype="multipart/form-data">
                <input type="file" ref="video" accept="video/*">
                <button type="submit">Загрузить видео</button>
            </form>
        </div>
</template>

<script setup>
import {onMounted, ref} from "vue";

import "../../../assets/sass/scrollspyNav.scss";
import "../../../assets/sass/forms/file-upload-with-preview.min.css";

import FileUploadWithPreview from "file-upload-with-preview";

import {useMeta} from "../../../composables/use-meta";

useMeta({title: "File Upload"});

const code_arr = ref([]);

onMounted(() => {
    initTooltip();

    //multiple file upload
    new FileUploadWithPreview("mySecondImage", {
        images: {
            baseImage: "/assets/images/file-preview.png",
            backgroundImage: "",
        },
    });
});

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
