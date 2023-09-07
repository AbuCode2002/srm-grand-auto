<template>
    <div class="layout-px-spacing apps-invoice-list">
        <teleport to="#breadcrumb">
            <ul class="navbar-nav flex-row">
                <li>
                    <div class="page-header">
                        <nav class="breadcrumb-one" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:;">Apps</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><span>Invoice List</span></li>
                            </ol>
                        </nav>
                    </div>
                </li>
            </ul>
        </teleport>

        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="panel br-6">
                    <div class="custom-table">
                        <v-client-table :data="items" :columns="columns" :options="table_option">
                            <template #invoice="props">
                                <router-link to="/apps/invoice/preview">
                                    <span class="inv-number">#{{ props.row.invoice }}</span>
                                </router-link>
                            </template>
                            <template #name="props">
                                <div class="d-flex">
                                    <div class="usr-img-frame me-2 rounded-circle">
                                        <img :src="'/assets/images/' + props.row.thumb" class="img-fluid rounded-circle" alt="avatar" />
                                    </div>
                                    <p class="align-self-center mb-0 admin-name">{{ props.row.name }}</p>
                                </div>
                            </template>
                            <template #email="props">
                                <span class="inv-email">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="feather feather-mail"
                                    >
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                        <polyline points="22,6 12,13 2,6"></polyline>
                                    </svg>
                                    {{ props.row.email }}
                                </span>
                            </template>
                            <template #date="props">
                                <span class="inv-date">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="feather feather-calendar"
                                    >
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    {{ props.row.date }}
                                </span>
                            </template>
                            <template #amount="props"> ${{ props.row.amount }} </template>
                            <template #status="props">
                                <span class="badge inv-status" :class="'badge-' + props.row.status.class">{{ props.row.status.key }}</span>
                            </template>
                            <template #actions="props">
                                <div class="mb-4 me-2 custom-dropdown dropdown btn-group">
                                    <a class="btn dropdown-toggle btn-icon-only" href="#" role="button" id="pendingTask" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            style="width: 24px; height: 24px"
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="feather feather-more-horizontal"
                                        >
                                            <circle cx="12" cy="12" r="1"></circle>
                                            <circle cx="19" cy="12" r="1"></circle>
                                            <circle cx="5" cy="12" r="1"></circle>
                                        </svg>
                                    </a>

                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="pendingTask">
                                        <li>
                                            <router-link href="javascript:void(0);" to="/apps/invoice/edit" class="dropdown-item action-edit"
                                                ><svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="24"
                                                    height="24"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="feather feather-edit-3"
                                                >
                                                    <path d="M12 20h9"></path>
                                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                                </svg>
                                                Edit
                                            </router-link>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" @click="delete_row(props.row)" class="dropdown-item action-delete"
                                                ><svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="24"
                                                    height="24"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="feather feather-trash"
                                                >
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                </svg>
                                                Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </template>
                        </v-client-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { onMounted, ref } from "vue";
    import "../../assets/sass/apps/invoice-list.scss";

    import { useMeta } from "../../composables/use-meta";
    import api from "../../api";
    useMeta({ title: "Invoice List" });

    const items = ref([]);
    const columns = ref(["id", "invoice", "name", "email", "date", "amount", "status", "actions"]);
    const table_option = ref({
        headings: {
            id: (h, row, index) => {
                return "#";
            },
        },
        perPage: 10,
        perPageValues: [5, 10, 20, 50],
        skin: "table table-hover",
        columnsClasses: { actions: "actions text-center" },
        pagination: { nav: "scroll", chunk: 5 },
        texts: {
            count: "Showing {from} to {to} of {count}",
            filter: "",
            filterPlaceholder: "Search...",
            limit: "Results:",
        },
        resizableColumns: false,
        sortable: ["invoice", "name", "email", "date", "amount", "status"],
        sortIcon: {
            base: "sort-icon-none",
            up: "sort-icon-asc",
            down: "sort-icon-desc",
        },
    });
    const selected_rows = ref([]);

    onMounted(() => {
        bind_data();
    });

    const bind_data = () => {
        items.value = [
            {
                id: 1,
                invoice: "081451",
                thumb: "profile-28.jpeg",
                name: "Laurie Fox",
                email: "lauriefox@company.com",
                date: "15 Dec 2020",
                amount: "2275.45",
                status: { key: "Paid", class: "success" },
            },
            {
                id: 2,
                invoice: "081452",
                thumb: "profile-30.png",
                name: "Alexander Gray",
                email: "alexGray3188@gmail.com",
                date: "20 Dec 2020",
                amount: "1044.00",
                status: { key: "Paid", class: "success" },
            },
            {
                id: 3,
                invoice: "081681",
                thumb: "profile-32.jpeg",
                name: "James Taylor",
                email: "jamestaylor468@gmail.com",
                date: "27 Dec 2020",
                amount: "20.00",
                status: { key: "Pending", class: "danger" },
            },
        ];
    };

    const regionId = ref(null);
    const station = ref(null);
    const getStation = async () => {
        const id = id;
        regionId.value = {
            "region_id": id.value,
        };
        try {
            const response = await api.get(`/api/auth/client/station`, regionId);
            station.value = response.stations
        } catch (error) {
            console.error('Ошибка при получении данных:', error);
        }
    };

    items.value = [];

    station.forEach((item) => {
        items.value.push({
            id: item.id,
            invoice: item.name,
            thumb: item.address,
            name: item.contact_phone,
            email: item.bin,
            date: item.bik,
            amount: item.iik,
            status: item.fact_address,
        });
    });
</script>
