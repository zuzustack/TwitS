<template>
    <div class="d-flex">
        <h3 class="text-muted me-auto">Follower</h3>
        <router-link to="/profil" class="btn btn-warning">Back</router-link>
    </div>
    <div class="container mt-2">
        <div class="card mb-3" v-for="follower in followers">
            <div class="card-body d-flex">
                <img
                    class="rounded-circle profil-picture me-3"
                    v-bind:src="'/' + follower.image"
                    alt=""
                />
                <div class="my-auto">
                    <h4 class="d-inline-block mb-0">
                        {{ follower.name }}
                    </h4>
                    <router-link
                        class="text-decoration-none"
                        :to="'/user/' + follower.username"
                    >
                        <h6 class="text-muted mb-0">
                            {{ follower.username }}
                        </h6>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            followers: "",
        };
    },
    async beforeMount() {
        await axios
            .get("http://127.0.0.1:8000/api/follower/user")
            .then((response) => {
                this.followers = response.data.followers;
            });
    },
};
</script>

<style></style>
