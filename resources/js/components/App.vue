<template>
    <Navbar v-if="Ready" />

    <router-view v-if="Ready"></router-view>
</template>

<script>
import Navbar from "./partials/Navbar.vue";
export default {
    data() {
        return {
            Ready: true,
        };
    },

    async mounted() {
        await axios.get("/api/get-session").then((response) => {
            console.log(response);
            localStorage.setItem("token", response.data._token);
            localStorage.setItem("isLogin", response.data.isLogin);

            if (
                response.data.login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d
            ) {
                this.id =
                    response.data.login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d;
            }

            this.Ready = true;
        });

        if (this.id) {
            await axios.get("/api/user/" + this.id).then((response) => {
                localStorage.setItem("user", JSON.stringify(response.data));
            });
        }
    },
    components: {
        Navbar,
    },
};
</script>

<style>
.router-link-active {
    color: #fff !important;
}
</style>
