<template>
    <div class="container mt-3 w-25">
        <div v-if="success" class="alert alert-success" role="alert">
            {{ message }}
        </div>

        <div
            v-if="error && message.err"
            class="alert alert-danger"
            role="alert"
        >
            {{ message.err }}
        </div>

        <h5 class="text-center">Login Form</h5>
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
        <p class="text-danger m-0" v-if="error && message.password">
            {{ message.password[0] }}
        </p>
        <div class="form-floating">
            <input
                v-model="password"
                type="password"
                class="form-control"
                id="floatingPassword"
                placeholder="Password"
            />
            <label for="floatingPassword">Password</label>
        </div>
        <div v-on:click="login" class="btn btn-primary mt-4 d-block">Login</div>
        <small class="text-muted text-center mt-2 d-block">
            Belum Memiliki <router-link to="/register">Akun?</router-link>
        </small>
    </div>
</template>

<script>
export default {
    data() {
        return {
            success: "",
            message: "",
            error: "",

            email: "",
            password: "",
        };
    },

    async mounted() {
        if (JSON.parse(localStorage.isLogin)) {
            this.$router.push({
                name: "home",
            });
        }
    },

    methods: {
        async login() {
            await axios
                .post("http://127.0.0.1:8000/api/login-user", {
                    email: this.email,
                    password: this.password,
                })
                .then((response) => {
                    if (response.data.error) {
                        this.success = false;
                        this.error = response.data.error;
                        this.message = response.data.message;
                    } else {
                        this.error = false;
                        (this.success = response.data.success),
                            (this.message = response.data.message);
                        localStorage.isLogin = true;
                        localStorage.user = JSON.stringify(response.data.user);
                        console.log(JSON.parse(localStorage.user));
                        this.$router.go();
                    }
                });
        },
    },
};
</script>

<style></style>
