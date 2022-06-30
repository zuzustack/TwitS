<template>
    <div class="container mt-3">
        <h1>Profilmu</h1>
        <div class="row">
            <div class="col-3">
                <div class="card">
                    <img
                        :src="'/' + image"
                        class="card-img-top img-card"
                        alt="..."
                    />
                    <div class="card-body">
                        <h6 class="text-muted mb-0">
                            {{ username }}
                        </h6>
                        <div class="info-account d-flex">
                            <div class="follower me-auto">
                                <router-link
                                    to="/profil/follower"
                                    class="text-muted text-decoration-none"
                                >
                                    Follower
                                    <span class="count">{{ follower }}</span>
                                </router-link>
                            </div>
                            <div class="following">
                                <router-link
                                    class="text-muted text-decoration-none"
                                    to="/profil/following"
                                >
                                    Following
                                    <span class="count">{{ following }}</span>
                                </router-link>
                            </div>
                        </div>
                        <hr />
                        <p>{{ bio }}</p>
                        <hr />
                        <router-link to="/profil-edit" class="btn btn-primary">
                            Edit Profil
                        </router-link>
                    </div>
                </div>
            </div>
            <div class="col-9">
                <router-view
                    :id="id"
                    :backPath="path"
                    :showOption="true"
                    :showForm="true"
                >
                </router-view>
            </div>
        </div>
    </div>
</template>

<script>
import IconShare from "../icons/IconShare.vue";
import IconLike from "../icons/IconLike.vue";
import IconComment from "../icons/IconComment.vue";
export default {
    data() {
        return {
            path: "/profil",
            username: "",
            bio: "",
            image: "",
            follower: "",
            following: "",
            id: JSON.parse(localStorage.user).id,
        };
    },

    beforeMount() {
        if (JSON.parse(localStorage.isLogin) === false) {
            this.$router.push({
                name: "login",
            });
        }
    },

    beforeRouteEnter(to, from, next) {
        if (!JSON.parse(localStorage.isLogin)) {
            window.location.href = "/login";
        }
        next();
    },

    mounted() {
        if (JSON.parse(localStorage.isLogin) === true) {
            this.image = JSON.parse(localStorage.user).image;
            this.username = JSON.parse(localStorage.user).username;
            this.follower = JSON.parse(localStorage.user).followers_count;
            this.following = JSON.parse(localStorage.user).followings_count;
            this.bio = JSON.parse(localStorage.user).bio;
            console.log(this.id);
        }
    },
    components: {
        IconShare,
        IconLike,
        IconComment,
    },
};
</script>

<style scoped>
.img-card {
    height: 259px;
}

.router-link-active {
    color: rgba(33, 37, 41, 0.75) !important;
}
</style>
