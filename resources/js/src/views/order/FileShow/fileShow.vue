<template xmlns="http://www.w3.org/1999/html">
    <div v-if="status === 'Заявка закрыта'" style="position: absolute; right: 10%; top: 10px;">
        <button class="btn btn-success" @click.prevent="installACW">
            <img src="../../../../../../public/assets/images/install_icon1.png"/>
            {{ $t('install_acw') }}
        </button>
    </div>
    <div class="panel-body">
        <div class="account-settings-container" style="position: absolute; left: 5%; right: 10%; top: 60px">
            <div class="table-checkable table-highlight-head table-responsive">
                <table role="table" aria-busy="false" aria-colcount="5"
                       class="table b-table table-striped table-hover table-bordered" id="__BVID__368">
                    <thead role="rowgroup" class="">
                    <tr role="row" class="">
                        <th role="columnheader" scope="col" aria-colindex="1" class="text-success">
                            <div>Path</div>
                        </th>
                        <th role="columnheader" scope="col" aria-colindex="2" class="text-success">
                            <div></div>
                        </th>
                    </tr>
                    </thead>
                    <tbody v-for="item in file.url" role="rowgroup">

                    <tr role="row" class="">

                        <td aria-colindex="1" role="cell" class="">{{ item.match(/([^\/]+)$/)[1] }}</td>

                        <td aria-colindex="2" role="cell" class="" style="width: 10px">
                            <div class="row">
                                <div class="feather-icon">
                                    <div style="display: inline-block;" class="text-success">
                                        <button class="custom-button" @click="getFile(item)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                <path
                                                    d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                                <path
                                                    d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </td>

                    </tr>
                    </tbody>
                </table>
            </div>

            <div v-if="loading === 0" class="panel-body text-center">
                <div class="d-flex justify-content-center align-items-center mx-5 mt-3 mb-5">
                    <div class="spinner-border text-success loader-lg">Loading...</div>
                </div>
            </div>

            <div v-if="image" class="text-center mt-4">
                <img :src="image" alt="profile"/>
            </div>
            <div v-if="video" class="text-center mt-4">
                <video :src="video" controls class="border" width="720" height="360"></video>
            </div>

            <div v-if="file.url && file.url.length > 0 && status === 'Ремонт выполнен' " class="row">
                <div class="as-footer-container">
                    <button style="position: absolute; bottom: 30px; left: 30px;"
                            type="button" class="btn btn-success"
                            @click.prevent="acceptOrRejectFile(accepted)">Принять
                    </button>
                </div>

                <div class="as-footer-container">
                    <button style="position: absolute; bottom: 30px; right: 30px;"
                            type="button" class="btn btn-danger"
                            @click.prevent="acceptOrRejectFile(rejected)">Отклонить
                    </button>
                </div>

            </div>
        </div>

    </div>
    <DialogsWrapper/>
</template>

<script setup>
import {computed, onMounted, ref} from 'vue';
import api from "../../../api";
import {useRouter} from "vue-router";

const router = useRouter();

const file = ref([]);

const orderId = router.currentRoute.value.params.orderId
const status = router.currentRoute.value.query.status
// const status = router.currentRoute.value.params.status

const getPath = async () => {
    try {
        const response = await api.get(`/api/manager/auth/show-file-path/${orderId}`);
        file.value = response.data
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
}

onMounted(getPath)

const video = ref('')
const image = ref('')
const loading = ref('')
const accepted = ref('accepted')
const rejected = ref('rejected')

const getFile = async (path) => {
    loading.value = 0
    fetch(path)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Network response was not ok: ${response.status}`);
            }
            return response.headers.get('Content-Type');
        })
        .then(contentType => {
            if (contentType.startsWith('image/')) {
                image.value = path
                video.value = ''
            } else if (contentType.startsWith('video/')) {
                video.value = path
                image.value = ''
            }
            loading.value = 1;
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

const acceptOrRejectFile = async (result) => {
    const fileResult = {
        "result": result,
    };
    try {
        await api.post(`/api/manager/auth/accepted-rejected-file/${orderId}`, fileResult);

        router.push({name: 'status'});

        if (result === accepted.value) {
            new window.Swal({
                title: "Файл принят",
                padding: "2em",
            });
        } else {
            new window.Swal({
                title: "Файл был отклонен",
                padding: "2em",
            });
        }
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
}

const installACW = async () => {
    try {
        const response = await api.get(`/api/auth/client/defective-act/ACW/${orderId}`, {
            responseType: 'blob', // important
        });

        const url = window.URL.createObjectURL(new Blob([response.data]));

        const link = document.createElement('a');
        link.href = url;
        // link.setAttribute('download', `АВР_${orderId}.xlsx`); // Задайте имя файла для скачивания
        link.setAttribute('download', `АВР_${orderId}.pdf`); // Задайте имя файла для скачивания
        document.body.appendChild(link);
        link.click();

        document.body.removeChild(link);
        URL.revokeObjectURL(url);

    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
}
</script>

<style lang="css" scoped>

.custom-button {
    color: #4dcf8f !important;
    background: rgba(0, 0, 0, 0.0) !important;
}

.custom-multiselect-field :deep(.multiselect__tags) {
    border-color: #4dcf8f;
}

.custom-multiselect-part :deep(.multiselect__tags) {
    border-color: #2c7be5;
}

.table th[aria-colindex] {
    border-top: 2px solid #4dcf8f !important;
}

</style>
