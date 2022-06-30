<template>
    <div class="container mt-3 w-25">
        <div v-if="success" class="alert alert-success" role="alert">
            {{ message }}
            <router-link to="/verifikasi-email">Verifikasi Email</router-link>
        </div>

        <h5 class="text-center">Register Form</h5>
        <p class="text-danger m-0" v-if="error && message.email">
            {{ message.email[0] }}
        </p>
        <div class="form-floating mb-3">
            <input
                v-model="email"
                type="email"
                class="form-control"
                id="floatingInput"
                placeholder="name@example.com"
            />
            <label for="floatingInput">Email address</label>
        </div>
        <p class="text-danger m-0" v-if="error && message.username">
            {{ message.username[0] }}
        </p>
        <div class="form-floating mb-3">
            <input
                v-model="username"
                type="text"
                class="form-control"
                id="floatingInput"
                placeholder="name@example.com"
            />
            <label for="floatingInput">Username</label>
        </div>
        <p class="text-danger m-0" v-if="error && message.name">
            {{ message.name[0] }}
        </p>
        <div class="form-floating mb-3">
            <input
                v-model="name"
                type="text"
                class="form-control"
                id="floatingInput"
                placeholder="name@example.com"
            />
            <label for="floatingInput">Name</label>
        </div>
        <p class="text-danger m-0" v-if="error && message.password">
            {{ message.password[0] }}
        </p>
        <div class="form-floating mb-3">
            <input
                v-model="password"
                type="password"
                class="form-control"
                id="floatingPassword"
                placeholder="Password"
            />
            <label for="floatingPassword">Password</label>
        </div>
        <p class="text-danger m-0" v-if="error && message.pass_confirm">
            {{ message.pass_confirm[0] }}
        </p>
        <div class="form-floating">
            <input
                v-model="pass_confirm"
                type="password"
                class="form-control"
                id="floatingPassword"
                placeholder="Confirm Password"
            />
            <label for="floatingPassword">Confirm Password</label>
        </div>
        <div class="btn btn-primary mt-4 d-block" v-on:click="register()">
            Register
        </div>
        <small class="text-muted text-center mt-2 d-block">
            Sudah Memiliki <router-link to="/login">Akun?</router-link>
        </small>
    </div>
</template>

<script>
export default {
    data() {
        return {
            email: "",
            username: "",
            name: "",
            password: "",
            pass_confirm: "",

            message: "",

            success: false,
            error: false,
        };
    },
    methods: {
        async register() {
            await axios
                .post("http://127.0.0.1:8000/api/register-user", {
                    email: this.email,
                    password: this.password,
                    pass_confirm: this.pass_confirm,
                    name: this.name,
                    username: this.username,
                })
                .then((response) => {
                    console.log(response.data);
                    if (response.data.error) {
                        this.error = true;
                        this.success = false;
                        this.message = response.data.message;
                    } else {
                        this.error = false;
                        this.success = true;
                        this.message = response.data.message;
                    }
                });
        },
    },
};
</script>

<style></style>
