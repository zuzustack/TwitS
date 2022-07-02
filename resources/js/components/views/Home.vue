<template>
    <div class="container">
        <h1 class="mt-3">
            Selamat Datang<span v-if="isLogin">, {{ name }}</span>
        </h1>
        <Post :showForm="true" ref="getPost" />
    </div>
</template>

<script>
import PostForm from "../partials/PostForm.vue";
import Navbar from "../partials/Navbar.vue";
import Post from "../partials/Post.vue";
export default {
    data() {
        return {
            name: "",
            isLogin: "",
        };
    },

    async beforeMount() {
        if (JSON.parse(localStorage.isLogin)) {
            this.isLogin = JSON.parse(localStorage.isLogin);
            this.name = JSON.parse(localStorage.user).name;
        }
    },

    async mounted() {
        console.log(this.name);
        this.isLogin = JSON.parse(localStorage.isLogin);
        this.$refs.getPost.getPost();
    },

    beforeRouteEnter(to, from, next) {
        if (!JSON.parse(localStorage.isLogin)) {
            window.location.href = "/login";
        }

        if (!window.laravel.email_confirm) {
            window.location.href = "/verifikasi-email";
        }
        next();
    },

    components: {
        Navbar,
        Post,
        PostForm,
    },
};
</script>

<style></style>
