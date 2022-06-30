<template>
    <div class="d-flex">
        <h3 class="text-muted me-auto">Following</h3>
        <router-link :to="{ path: backPath }" class="btn btn-outline-secondary">
            Back
        </router-link>
    </div>
    <div class="container mt-2">
        <div class="card mb-3" v-for="following in followings">
            <div class="card-body d-flex">
                <img
                    class="rounded-circle profil-picture me-3"
                    v-bind:src="'/' + following.image"
                    alt=""
                />
                <div class="my-auto">
                    <h4 class="d-inline-block mb-0">
                        {{ following.name }}
                    </h4>
                    <router-link
                        class="text-decoration-none"
                        :to="'/user/' + following.username"
                    >
                        <h6 class="text-muted mb-0">
                            {{ following.username }}
                        </h6>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["showForm", "id", "backPath"],
    data() {
        return {
            followings: [],
        };
    },

    async beforeMount() {
        await axios
            .post("http://127.0.0.1:8000/api/following/user", {
                id: this.$props.id,
            })
            .then((response) => {
                this.followings = response.data.followings;
            });
    },
};
</script>

<style scoped>
.btn.router-link-active {
    color: #6c757d !important;
}
.btn.router-link-active:hover {
    color: #fff !important;
}
</style>
