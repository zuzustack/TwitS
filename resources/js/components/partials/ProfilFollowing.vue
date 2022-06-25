<template>
    <div class="d-flex">
        <h3 class="text-muted me-auto">Following</h3>
        <router-link to="/profil" class="btn btn-warning">Back</router-link>
    </div>
    <div class="container">
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
    data() {
        return {
            followings: [],
        };
    },

    async beforeMount() {
        await axios
            .get("http://127.0.0.1:8000/api/following/user")
            .then((response) => {
                this.followings = response.data.followings;
                console.log(response.data.followings);
            });
    },
};
</script>

<style></style>
