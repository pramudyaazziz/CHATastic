<template>
   <GuestLayout>
        <Head title="Login" />
        <div class="col-md-6 p-5 d-flex align-items-center">
            <img :src="image" alt="welcome" class="img-fluid">
        </div>
        <div class="col-md-6 p-4">
            <div class="card h-100 shadow">
                <div class="card-body d-flex align-items-center">
                    <div class="col p-4">
                        <h5>Welcome to</h5>
                        <h3 class="text-primary fw-bold">CHATastic</h3>
                        <hr>
                        <p class="text-danger">{{ form.errors.stats }}</p>
                        <form @submit.prevent="submit">
                            <div class="mb-3">
                                <label class="form-label">Email address</label>
                                <input type="email" autofocus :class="[{ 'is-invalid': form.errors.email, 'form-control': true }]" v-model="form.email">
                                <div class="invalid-feedback">{{ form.errors.email }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" :class="[{ 'is-invalid': form.errors.password, 'form-control': true }]" v-model="form.password">
                                <div class="invalid-feedback">{{ form.errors.password }}</div>
                            </div>
                            <div class="mb-3 d-flex justify-content-end">
                                <Link :href="route('password.request')" class="text-end">Forgot Password</Link>
                            </div>
                            <div class="row ps-2 pe-2">
                                <button type="submit" :class="[{ 'btn': true, 'btn-primary': true, 'loading': form.processing }]">
                                    <div v-if="form.processing">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            Login
                                    </div>
                                    <span v-else>Login</span>
                                </button>
                            </div>
                        </form>
                        <div class="mt-4">
                            <p class="text-center">Don't have an account yet? <Link :href="route('register')">Register</Link></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </GuestLayout>
</template>

<script>
    import GuestLayout from '@/Layouts/GuestLayout.vue';
    import { Link, Head, useForm } from '@inertiajs/vue3';

    export default {
        components: {
            GuestLayout,
            Link,
            Head
        },
        data() {
            return {
                image: window.location.origin + '/assets/auth/img/welcome.svg',
                form: useForm({
                    email: '',
                    password: ''
                })
            }
        },
        methods: {
            submit() {
                this.form.post(route('login'), {
                    onFinish: () => {
                        this.form.reset('password')
                    },
                });
            }
        }
    }
</script>
