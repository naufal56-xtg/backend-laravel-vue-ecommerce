<template>
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
            <!-- Login -->
            <div class="card p-2">

                <div class="card-body mt-2">
                    <h4 class="mb-2 fw-semibold">Welcome to Materialize! 👋</h4>
                    <p class="mb-4">Please sign-in to your account and start the adventure</p>

                    <Form v-slot:default="{ errors }" class="mb-3" @submit="handleSubmit">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" :class="{ 'is-invalid': errors.email }" id="email"
                                v-model="form.email" placeholder="Silahkan Masukkan Email" autofocus />
                            <label for="email">Email</label>
                            <span class="mt-1 invalid-feedback">{{ errors.email }}</span>
                        </div>
                        <div class="mb-3">
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="password" id="password" :class="{ 'is-invalid': errors.password }"
                                            class="form-control" v-model="form.password"
                                            placeholder="Silahkan Masukan Passwod" aria-describedby="password" />
                                        <label for="password">Password</label>
                                        <span class="mt-1 invalid-feedback">{{ errors.password }}</span>
                                    </div>
                                    <span class="input-group-text cursor-pointer"><i
                                            class="mdi mdi-eye-off-outline"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 d-flex justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-me" />
                                <label class="form-check-label" for="remember-me"> Remember Me </label>
                            </div>
                            <a href="auth-forgot-password-basic.html" class="float-end mb-1">
                                <span>Forgot Password?</span>
                            </a>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                        </div>
                    </Form>



                    <div class="divider my-4">
                        <div class="divider-text">or</div>
                    </div>

                    <div class="d-flex justify-content-center gap-2">
                        <a href="javascript:;" class="btn btn-icon btn-lg rounded-pill btn-text-facebook">
                            <i class="tf-icons mdi mdi-24px mdi-facebook"></i>
                        </a>

                        <a href="javascript:;" class="btn btn-icon btn-lg rounded-pill btn-text-twitter">
                            <i class="tf-icons mdi mdi-24px mdi-twitter"></i>
                        </a>

                        <a href="javascript:;" class="btn btn-icon btn-lg rounded-pill btn-text-github">
                            <i class="tf-icons mdi mdi-24px mdi-github"></i>
                        </a>

                        <a href="javascript:;" class="btn btn-icon btn-lg rounded-pill btn-text-google-plus">
                            <i class="tf-icons mdi mdi-24px mdi-google"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Login -->

        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { Form } from "vee-validate";
import { reactive } from 'vue';



let form = reactive({
    'email': '',
    'password': '',
});

const handleSubmit = async (values, actions) => {
    await axios.post('/login', form).then(() => {
        window.location.href = '/admin/dashboard';
    }).catch((error) => {
        actions.setErrors(error.response.data.errors);
    });
}

</script>

<style lang="scss" scoped></style>
