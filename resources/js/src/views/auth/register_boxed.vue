<template>
    <div class="form auth-boxed">
        <div class="form-container outer">
            <div class="form-form">
                <div class="form-form-wrap">
                    <div class="form-container">
                        <div class="form-content mb-5">
                            <h1 class="">Register</h1>
                            <p class="signup-link register">Already have an account? <router-link to="/auth/login-boxed">Log in</router-link></p>
                            <form class="text-start">
                                <div class="form">
                                    <div id="username-field" class="field-wrapper input">
                                        <label for="username">USERNAME</label>
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
                                            class="feather feather-user"
                                        >
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        <input type="text" v-model="name" class="form-control" placeholder="Username" />
                                    </div>

                                    <div id="email-field" class="field-wrapper input">
                                        <label for="email">EMAIL</label>
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
                                            class="feather feather-at-sign register"
                                        >
                                            <circle cx="12" cy="12" r="4"></circle>
                                            <path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path>
                                        </svg>
                                        <input type="email" v-model="email" class="form-control" placeholder="Email" />
                                    </div>

                                    <div id="password-field" class="field-wrapper input mb-1">
                                        <div class="d-flex justify-content-between">
                                            <label for="password">PASSWORD</label>
                                        </div>
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
                                            class="feather feather-lock"
                                        >
                                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                        </svg>
                                        <input :type="pwd_type" v-model="password" class="form-control" placeholder="Password" />
                                        <svg
                                            @click="set_pwd_type"
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            id="toggle-password"
                                            class="feather feather-eye"
                                        >
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                    </div>

                                    <div id="password-field" class="field-wrapper input mb-4">
                                        <div class="d-flex justify-content-between">
                                            <label for="password">CONFIRM PASSWORD</label>
                                        </div>
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
                                            class="feather feather-lock"
                                        >
                                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                        </svg>
                                        <input :type="pwd_type" v-model="confirmPassword" class="form-control" placeholder="Confirm password" />
                                        <svg
                                            @click="set_pwd_type"
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            id="toggle-password"
                                            class="feather feather-eye"
                                        >
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                    </div>

                                    <div class="col-md-12 mb-5">
                                        <select v-model="roleId" class="form-select w-100">
                                            <option :value="null">Роль пользователя</option>
                                            <option v-for="item in role" :value="item" :key="item">
                                                {{ item.name }}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="d-sm-flex justify-content-between">
                                        <div class="field-wrapper">
                                            <button type="submit" @click.prevent="postRegister" class="btn btn-primary">Get Started!</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {onMounted, ref} from "vue";
    import "../../assets/sass/authentication/auth-boxed.scss";

    import { useMeta } from "../../composables/use-meta";
    import axios from "axios";
    import router from "../../router";
    import api from "../../api";
    useMeta({ title: "Register Boxed" });

    const pwd_type = ref("password");

    const set_pwd_type = () => {
        if (pwd_type.value === "password") {
            pwd_type.value = "text";
        } else {
            pwd_type.value = "password";
        }
    };
    const roleId = ref(null);

    const email = ref(null);

    const name = ref(null);

    const password = ref(null);

    const confirmPassword = ref(null);

    const role = ref(null);

    const postRegister = async () => {
        try {
            const res = await axios.post('/api/auth/register', {
                email: email.value,
                name: name.value,
                password: password.value,
                password_confirmation: confirmPassword.value,
                role_id: roleId._value.id,
            });
            if (res.data.access_token) {
                localStorage.setItem('access_token', res.data.access_token);
                router.push({name: 'Home'})
            }
        } catch (error) {
            console.error('Ошибка при введений данных:', error);
        }
    };

    const getRole = async () => {
        try {
            const response = await api.get('/api/role/');
            role.value = response.data.roles;
            } catch (error) {
            console.error('Ошибка при получении данных:', error);
        }
    };
    onMounted(getRole);
</script>
