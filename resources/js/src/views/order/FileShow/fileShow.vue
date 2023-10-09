<template>
    <div class="panel-body">
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
                <tbody role="rowgroup">
                <tr v-for="item in file" :value="item" role="row" class="">

                    <td aria-colindex="1" role="cell" class="">{{ item.file_name }}</td>

                    <td aria-colindex="2" role="cell" class="">
                        <div class="row">
                            <div class="feather-icon">
                                <div style="display: inline-block;" class="text-success">
                                    <button class="custom-button" @click="getFile(item.file_name)">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                      </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </td>

                </tr>
                </tbody>
            </table>

          <div v-if="fileContent">
            <video :src="fileContent" controls></video>
          </div>

        </div>
    </div>
</template>

<script setup>
import {ref, onMounted} from 'vue';
import api from "../../../api";
import {useRouter} from "vue-router";

const router = useRouter();

const file = ref([]);
const orderId = router.currentRoute.value.params.orderId

const getPath = async () => {
    try {
        const response = await api.get(`/api/manager/auth/show-file-path/${orderId}`);
        file.value = response.data.files

    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
}

onMounted(getPath)

const fileContent = ref(null);

const getFile = async (path) => {

  const pathRequest = {
    "path": path,
  };

  try {
    const response = await api.post(`/api/manager/auth/show-file/${orderId}`, pathRequest);

    fileContent.value = response.data;
    console.log(response)
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

.custom-field {
    color: #4dcf8f !important;
}

.custom-field:hover {
    color: #f09819 !important;
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
