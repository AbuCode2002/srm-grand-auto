import axios from 'axios';
import router from './router';

const api = axios.create();

axios.defaults.baseURL = 'http://66.42.32.129';

api.interceptors.request.use((config) => {
    if (localStorage.getItem('access_token')) {
        config.headers.authorization = `Bearer ${localStorage.getItem('access_token')}`;
    }
    return config;
});

api.interceptors.response.use((config) => {
    if (localStorage.getItem('access_token')) {
        config.headers.authorization = `Bearer ${localStorage.getItem('access_token')}`;
    }
    return config;
}, async (error) => {
    if (error.response.data.message === 'Token has expired') {
        try {
            const response = await axios.post('api/auth/refresh', {}, {
                headers: {
                    'authorization': `Bearer ${localStorage.getItem('access_token')}`
                }
            });

            localStorage.setItem('access_token', response.data.access_token);
            error.config.headers.authorization = `Bearer ${response.data.access_token}`;

            return api.request(error.config);
        } catch (refreshError) {
            console.error('Ошибка при обновлении токена:', refreshError);
        }
    }

    if (error.response.status === 401) {
        router.push({ name: 'login-boxed' });
    }
});

export default api;


// import axios from "axios";
// import router from "./router";
//
// const api = await axios.create();
//
// api.interceptors.request.use(config => {
//     if (localStorage.getItem('access_token')) {
//         config.headers.authorization = `Bearer ${localStorage.getItem('access_token')}`
//     }
//     return config
// },error => {
// })
//
// api.interceptors.response.use(config => {
//     if (localStorage.getItem('access_token')) {
//         config.headers.authorization = `Bearer ${localStorage.getItem('access_token')}`
//     }
//     return config
// },error => {
//     if (error.response.data.message === 'Token has expired') {
//         return axios.post('api/auth/refresh', {}, {
//             headers: {
//                 'authorization': `Bearer ${localStorage.getItem('access_token')}`
//             }
//         }).then( res => {
//             localStorage.setItem('access_token', res.data.access_token)
//
//             error.config.headers.authorization = `Bearer ${res.data.access_token}`
//
//             return api.request(error.config)
//         })
//     }
//     if (error.response.status === 401) {
//         router.push({name: 'login-boxed'})
//     }
// })
//
// export default api
