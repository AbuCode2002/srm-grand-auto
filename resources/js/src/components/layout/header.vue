<template>
    <div>
        <!--  BEGIN NAVBAR  -->
        <div class="header-container fixed-top">
            <header class="header navbar navbar-expand-sm">
                <ul class="navbar-item theme-brand flex-row text-center">
                    <li class="nav-item theme-logo">
                        <router-link to="/">
                            <img src="/assets/images/logo.svg" class="navbar-logo" alt="logo"/>
                        </router-link>
                    </li>
                    <li class="nav-item theme-text">
                        <router-link to="/" class="nav-link"> CORK</router-link>
                    </li>
                </ul>
                <div class="d-none horizontal-menu">
                    <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"
                       @click="$store.commit('toggleSideBar', !$store.state.is_show_sidebar)">
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
                            class="feather feather-menu"
                        >
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </a>
                </div>


                <div class="navbar-item flex-row ms-md-auto">
                    <div class="dark-mode d-flex align-items-center">
                        <a v-if="$store.state.dark_mode == 'light'" href="javascript:;"
                           class="d-flex align-items-center" @click="toggleMode('dark')">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="20"
                                height="20"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="feather feather-sun"
                            >
                                <circle cx="12" cy="12" r="5"></circle>
                                <line x1="12" y1="1" x2="12" y2="3"></line>
                                <line x1="12" y1="21" x2="12" y2="23"></line>
                                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                                <line x1="1" y1="12" x2="3" y2="12"></line>
                                <line x1="21" y1="12" x2="23" y2="12"></line>
                                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                                <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                            </svg>
                            <span class="ms-2">Light</span>
                        </a>
                        <a v-if="$store.state.dark_mode == 'dark'" href="javascript:;" class="d-flex align-items-center"
                           @click="toggleMode('light')">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="20"
                                height="20"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="feather feather-moon"
                            >
                                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                            </svg>
                            <span class="ms-2">Dark</span>
                        </a>
                    </div>

                    <div class="dropdown nav-item language-dropdown btn-group">
                        <a href="javascript:;" id="ddllang" data-bs-toggle="dropdown" aria-expanded="false"
                           class="btn dropdown-toggle btn-icon-only nav-link">
                            <img v-if="selectedLang" :src="`/assets/images/flags/${selectedLang.code}.png`"
                                 class="flag-width" alt="flag"/>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="ddllang">
                            <perfect-scrollbar>
                                <li v-for="item in countryList" :key="item.code">
                                    <a href="javascript:;" class="dropdown-item d-flex align-items-center"
                                       :class="{ active: i18n.locale === item.code }"
                                       @click.prevent="changeLanguage(item)">
                                        <img :src="`/assets/images/flags/${item.code}.png`" class="flag-width" alt=""/>
                                        <span>{{ item.name }}</span>
                                    </a>
                                </li>
                            </perfect-scrollbar>
                        </ul>
                    </div>

                    <div class="navbar-item flex-row ms-0 m-4">
                        <div class="dark-mode d-flex align-items-center">
                            <a href="javascript:;"
                               class="d-flex align-items-center" @click.prevent="logout">
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
                                    class="feather feather-log-out"
                                >
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                {{ $t('sign_out') }}
                            </a>
                        </div>
                    </div>

                </div>
            </header>
        </div>
        <!--  END NAVBAR  -->
        <!--  BEGIN NAVBAR  -->
        <div class="sub-header-container">
            <header class="header navbar navbar-expand-sm">
                <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"
                   @click="$store.commit('toggleSideBar', !$store.state.is_show_sidebar)">
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
                        class="feather feather-menu"
                    >
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </a>

                <!-- Portal vue/Teleport for Breadcrumb -->
                <div id="breadcrumb" class="vue-portal-target"></div>
            </header>
        </div>
        <!--  END NAVBAR  -->
        <!--  BEGIN TOPBAR  -->
        <div class="topbar-nav header navbar" role="banner">
            <nav class="topbar">
                <ul class="list-unstyled menu-categories" id="topAccordion">
                    <li class="menu">
                        <a class="dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#users"
                           aria-controls="users" aria-expanded="false">
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
                                    <path
                                        d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
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
                                <router-link to="/order/create-order" @click="toggleMobileMenu">Создать заявку
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/order/new" @click="toggleMobileMenu;
                            filter(statusName, status)">Все заявки
                                </router-link>
                            </li>
                            <li>
                                <router-link to="order/new" @click.prevent="toggleMobileMenu;
                            filter(statusName1, status1)">Новая заявка
                                </router-link>
                            </li>
                            <li>
                                <router-link to="order/new" @click.prevent="toggleMobileMenu;
                            filter(statusName2, status2)">Ожидает назначение диагностики от СТО
                                </router-link>
                            </li>
                            <li>
                                <router-link to="order/new" @click.prevent="toggleMobileMenu;
                            filter(statusName3, status3)">Назначена диагностика
                                </router-link>
                            </li>
                            <li>
                                <router-link to="order/new" @click.prevent="toggleMobileMenu;
                            filter(statusName4, status4)">ДА ожидает согласования в отделе по работе с партнерами
                                </router-link>
                            </li>
                            <li>
                                <router-link to="order/new" @click.prevent="toggleMobileMenu;
                            filter(statusName5, status5)">ДА на согласовании в отделе по работе с клиентами
                                </router-link>
                            </li>
                            <li>
                                <router-link to="order/new" @click.prevent="toggleMobileMenu;
                            filter(statusName6, status6)">Согласован
                                </router-link>
                            </li>
                            <li>
                                <router-link to="order/new" @click.prevent="toggleMobileMenu;
                            filter(statusName7, status7)">Проводятся ремонтные работы
                                </router-link>
                            </li>
                            <li>
                                <router-link to="order/new" @click.prevent="toggleMobileMenu;
                            filter(statusName8, status8)">Ремонт выполнен
                                </router-link>
                            </li>
                            <li>
                                <router-link to="order/new" @click.prevent="toggleMobileMenu;
                            filter(statusName9, status9)">Заявка закрыта
                                </router-link>
                            </li>
                            <li>
                                <router-link to="order/new" @click.prevent="toggleMobileMenu;
                            filter(statusName10, status10)">ДА акт не принят
                                </router-link>
                            </li>
                            <li>
                                <router-link to="order/new" @click.prevent="toggleMobileMenu;
                            filter(statusName11, status11)">Не оплачено
                                </router-link>
                            </li>
                        </ul>
                    </li>

                    <li class="menu">
                        <a class="dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#statistics"
                           aria-controls="statistics" aria-expanded="false">
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
                            <li @click="toggleMobileMenu"><a target="_blank"
                                                             href="/statistics">{{ $t('service_statistics') }}</a></li>
                            <li @click="toggleMobileMenu"><a target="_blank" href="/percent-statistic">{{
                                    $t('percent_statistics')
                                }}</a></li>
                            <li @click="toggleMobileMenu"><a target="_blank" href="/KPI">{{ $t('KPI') }}</a></li>
                            <li @click="toggleMobileMenu"><a target="_blank" href="/budget">{{ $t('budgets') }}</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
        <!--  END TOPBAR  -->
    </div>
</template>

<script setup>
import {onMounted, ref, reactive} from 'vue';
import {useI18n} from 'vue-i18n';
import {useStore} from 'vuex';
import api from "../../api";
import router from "../../router";
import Buttons from "../../views/elements/buttons.vue";

const store = useStore();

const selectedLang = ref(null);
const countryList = ref(store.state.countryList);

const i18n = reactive(useI18n());

onMounted(() => {
    selectedLang.value = window.$appSetting.toggleLanguage();
    toggleMode();
});

const toggleMode = (mode) => {
    window.$appSetting.toggleMode(mode);
};

const changeLanguage = (item) => {
    selectedLang.value = item;
    i18n.locale = item.code;
    window.$appSetting.toggleLanguage(item);
};

const logout = async () => {
    try {
        const response = await api.post('/api/auth/logout');
        localStorage.removeItem('access_token');
        await router.push({name: 'order-create'})
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
};
</script>
