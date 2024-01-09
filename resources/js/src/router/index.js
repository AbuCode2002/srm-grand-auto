import {createRouter, createWebHistory} from 'vue-router';


const routes = [
    //dashboard
    {
        path: '/index2',
        name: 'index2',
        component: () => import(/* webpackChunkName: "index2" */ '../views/index2.vue'),
    },

    //fonts
    {
        path: '/font-icons',
        name: 'font-icons',
        component: () => import(/* webpackChunkName: "font-icons" */ '../views/font_icons.vue'),
    },

    //auth
    {
        path: '/auth/login-boxed',
        name: 'login-boxed',
        component: () => import(/* webpackChunkName: "auth-login-boxed" */ '../views/auth/login_boxed.vue'),
        meta: {layout: 'auth'},
    },
    {
        path: '/auth/register-boxed',
        name: 'register-boxed',
        component: () => import(/* webpackChunkName: "auth-register-boxed" */ '../views/auth/register_boxed.vue'),
        meta: {layout: 'auth'},
    },
    {
        path: '/auth/login',
        name: 'login',
        component: () => import(/* webpackChunkName: "auth-login" */ '../views/auth/login.vue'),
        meta: {layout: 'auth'},
    },

    //order
    {
        path: '/order/profile',
        name: 'profile',
        component: () => import(/* webpackChunkName: "order-profile" */ '../views/profile.vue'),
    },
    {
        path: '/order/create-order',
        name: 'order-create',
        component: () => import(/* webpackChunkName: "create_order" */ '../views/order/Client/create_order.vue'),
    },
    {
        path: '/order/new',
        name: 'status',
        component: () => import(/* webpackChunkName: "index_order" */ '../views/order/status/status.vue'),
    },
    {
        path: '/order/new',
        name: 'status1',
        component: () => import('../views/order/status/status1.vue'),
    }, {
        path: '/order/new',
        name: 'status2',
        component: () => import('../views/order/status/status2.vue'),
    },
    {
        path: '/order/new',
        name: 'status3',
        component: () => import('../views/order/status/status3.vue'),
    },{
        path: '/order/new',
        name: 'status4',
        component: () => import('../views/order/status/status4.vue'),
    },{
        path: '/order/new',
        name: 'status5',
        component: () => import('../views/order/status/status5.vue'),
    },{
        path: '/order/new',
        name: 'status6',
        component: () => import('../views/order/status/status6.vue'),
    },{
        path: '/order/new',
        name: 'status7',
        component: () => import('../views/order/status/status7.vue'),
    },{
        path: '/order/new',
        name: 'status8',
        component: () => import('../views/order/status/status8.vue'),
    },{
        path: '/order/new',
        name: 'status9',
        component: () => import('../views/order/status/status9.vue'),
    },{
        path: '/order/new',
        name: 'status10',
        component: () => import('../views/order/status/status10.vue'),
    },{
        path: '/order/new',
        name: 'status11',
        component: () => import('../views/order/status/status11.vue'),
    },
    {
        path: '/order/index/station/:regionId/:orderId',
        name: 'order-index-station',
        component: () => import('../views/order/station.vue'),
    },
    {
        path: '/order/defective-act/edit/:orderId',
        name: 'order-defective-act-edit',
        component: () => import('../views/order/edit_defective_act.vue'),
    },
    {
        path: '/order/defective-act/show/:orderId',
        name: 'order-defective-act-show-manager',
        component: () => import('../views/order/Manager/show_defective_act.vue'),
    },{
        path: '/order/defective-act/show/:orderId',
        name: 'order-defective-act-show-client',
        component: () => import('../views/order/Client/show_defective_act.vue'),
    },
    {
        path: '/order/upload/:orderId',
        name: 'order-upload',
        component: () => import('../views/order/FileUpload/fileUpload.vue'),
    },
    {
        // path: '/order/show/:orderId, :status',
        path: '/order/show/:orderId',
        name: 'file-show',
        component: () => import('../views/order/FileShow/fileShow.vue'),
    },
    {
        path: '/statistics',
        name: 'statistics',
        component: () => import('../views/order/Statistics/statistics.vue'),
    },
    {
        path: '/percent-statistic',
        name: '/percent-statistic',
        component: () => import('../views/order/Statistics/percentStatistics.vue'),
    },
    {
        path: '/KPI',
        name: 'KPI',
        component: () => import('../views/order/Statistics/KPI.vue'),
    },
    {
        path: '/budget',
        name: 'budget',
        component: () => import('../views/order/Statistics/budget.vue'),
    },


    //drag&drop
    {
        path: '/dragndrop',
        name: 'dragndrop',
        component: () => import(/* webpackChunkName: "dragndrop" */ '../views/dragndrop.vue'),
    },

    //widgets
    {
        path: '/widgets',
        name: 'widgets',
        component: () => import(/* webpackChunkName: "widgets" */ '../views/widgets.vue'),
    },
    {
        path: '/:pathMatch(.*)*',
        name:'404',
        component: () => import('../views/pages/error404.vue'),
    },
];

const router = new createRouter({
    // mode: 'history',
    history: createWebHistory(),
    linkExactActiveClass: 'active',
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        } else {
            return {left: 0, top: 0};
        }
    },
});

router.beforeEach((to, from, next) => {

    const accessToken = localStorage.getItem('access_token')

    if (to.name !== 'login-boxed' && to.name !== 'register-boxed' || to.name !== 'phpmyadmin' && !accessToken) {
        return next({
            name: 'login-boxed'
        });
    }
    else if (to.name === 'login-boxed' && accessToken) {
        return next({
            name: 'order-create'
        });
    }
    next();
});

export default router;
