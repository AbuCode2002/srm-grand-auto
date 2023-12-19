<template>
    <!--  BEGIN SIDEBAR  -->
    <div class="sidebar-wrapper sidebar-theme">
        <nav ref="menu" id="sidebar">
            <div class="shadow-bottom"></div>

            <perfect-scrollbar class="list-unstyled menu-categories" tag="ul" :options="{ wheelSpeed: 0.5, swipeEasing: !0, minScrollbarLength: 40, maxScrollbarLength: 300, suppressScrollX: true }">

                <li class="menu">
                    <a class="dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#users" aria-controls="users" aria-expanded="false">
                        <div class="">
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
                                class="feather feather-clipboard"
                            >
                                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                            </svg>
                            <span>{{ $t('applications') }}</span>
                        </div>
                        <div>
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
                                class="feather feather-chevron-right"
                            >
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>

                    <ul id="users" class="collapse submenu list-unstyled" data-bs-parent="#sidebar">
                        <li v-if="roleUser === 2">
                            <router-link to="/order/create-order" @click="toggleMobileMenu">Создать заявку</router-link>
                        </li>
                        <li>
                            <router-link to="/order/new" @click="toggleMobileMenu;
                            filter(statusName, status)">{{ $t('all_applications') }}</router-link>
                        </li>
                        <li>
                            <router-link to="order/new" @click.prevent="toggleMobileMenu;
                            filter(statusName1, status1)">{{ $t('new_application') }}</router-link>
                        </li>
                        <li>
                            <router-link to="order/new" @click.prevent="toggleMobileMenu;
                            filter(statusName2, status2)">{{ $t('waiting_for_diagnostic_appointment_from_service_station') }}</router-link>
                        </li>
                        <li>
                            <router-link to="order/new" @click.prevent="toggleMobileMenu;
                            filter(statusName3, status3)">{{ $t('diagnostics_prescribed') }}</router-link>
                        </li><li>
                            <router-link to="order/new" @click.prevent="toggleMobileMenu;
                            filter(statusName4, status4)">{{ $t('yes_is_awaiting_approval_from_the_partner_relations_department') }}</router-link>
                        </li><li>
                            <router-link to="order/new" @click.prevent="toggleMobileMenu;
                            filter(statusName5, status5)">{{ $t('yes_subject_to_approval_by_the_customer_service_department') }}</router-link>
                        </li><li>
                            <router-link to="order/new" @click.prevent="toggleMobileMenu;
                            filter(statusName6, status6)">{{ $t('agreed') }}</router-link>
                        </li><li>
                            <router-link to="order/new" @click.prevent="toggleMobileMenu;
                            filter(statusName7, status7)">{{ $t('repair_work_is_underway') }}</router-link>
                        </li><li>
                            <router-link to="order/new" @click.prevent="toggleMobileMenu;
                            filter(statusName8, status8)">{{ $t('repair_completed') }}</router-link>
                        </li><li>
                            <router-link to="order/new" @click.prevent="toggleMobileMenu;
                            filter(statusName9, status9)">{{ $t('application_closed') }}</router-link>
                        </li><li>
                            <router-link to="order/new" @click.prevent="toggleMobileMenu;
                            filter(statusName10, status10)">{{ $t('yes_the_act_was_not_accepted') }}</router-link>
                        </li><li>
                            <router-link to="order/new" @click.prevent="toggleMobileMenu;
                            filter(statusName11, status11)">{{ $t('not_paid') }}</router-link>
                        </li>
                    </ul>
                </li>

                <li class="menu">
                    <a class="dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#statistics" aria-controls="statistics" aria-expanded="false">
                        <div class="">
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
                                class="feather feather-pie-chart"
                            >
                                <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                            </svg>
                            <span>{{ $t('statistic') }}</span>
                        </div>
                        <div>
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
                                class="feather feather-chevron-right"
                            >
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>

                    <ul id="statistics" class="collapse submenu list-unstyled" data-bs-parent="#sidebar">
                        <li @click="toggleMobileMenu"><a target="_blank" href="/statistics">{{ $t('service_statistics') }}</a></li>
                        <li @click="toggleMobileMenu"><a target="_blank" href="/percent-statistic">{{ $t('percent_statistics') }}</a></li>
                        <li @click="toggleMobileMenu"><a target="_blank" href="/KPI">{{ $t('KPI') }}</a></li>
                        <li @click="toggleMobileMenu"><a target="_blank" href="/budget">{{ $t('budgets') }}</a></li>
                    </ul>
                </li>

            </perfect-scrollbar>
        </nav>
    </div>
    <!--  END SIDEBAR  -->
</template>

<script setup>
    import { onMounted, ref } from 'vue';
    import { useStore } from 'vuex';
    import {useRouter} from "vue-router";
    import api from "../../api";
    const store = useStore();

    const status = ref('all');
    const status1 = ref('Новая заявка');
    const status2 = ref('Ожидает назначение диагностики от СТО');
    const status3 = ref('Назначена диагностика');
    const status4 = ref('ДА ожидает согласования в отделе по работе с партнерами');
    const status5 = ref('ДА на согласовании в отделе по работе с клиентами');
    const status6 = ref('Согласован');
    const status7 = ref('Проводятся ремонтные работы');
    const status8 = ref('Ремонт выполнен ');
    const status9 = ref('Заявка закрыта');
    const status10 = ref('ДА акт не принят');
    const status11 = ref('Не оплачено');

    const statusName = ref('status');
    const statusName1 = ref('status1');
    const statusName2 = ref('status2');
    const statusName3 = ref('status3');
    const statusName4 = ref('status4');
    const statusName5 = ref('status5');
    const statusName6 = ref('status6');
    const statusName7 = ref('status7');
    const statusName8 = ref('status8');
    const statusName9 = ref('status9');
    const statusName10 = ref('status10');
    const statusName11 = ref('status11');

    const router = useRouter();

    const filter = (statusName, status) => {
        router.push({name: statusName, query: {status}});
    }

    onMounted(() => {
        const selector = document.querySelector('#sidebar a[href="' + window.location.pathname + '"]');
        if (selector) {
            const ul = selector.closest('ul.collapse');
            if (ul) {
                let ele = ul.closest('li.menu').querySelectorAll('.dropdown-toggle');
                if (ele) {
                    ele = ele[0];
                    setTimeout(() => {
                        ele.click();
                    });
                }
            } else {
                selector.click();
            }
        }
    });

    const toggleMobileMenu = () => {
        if (window.innerWidth < 991) {
            store.commit('toggleSideBar', !store.state.is_show_sidebar);
        }
    };

    const roleUser = ref(null)

    const getRole = async () => {
        try {
            const response = await api.get(`/api/admin/auth/user`);
            roleUser.value = response.data.users[0].role_id
        } catch (error) {
            console.error('Ошибка при получении данных:', error);
        }
    }

    onMounted(getRole)
</script>
