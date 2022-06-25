<template>
    <div class="container mt-3">
        <h1>Profilmu</h1>
        <div class="row">
            <div class="col-3">
                <div class="card">
                    <img :src="image" class="card-img-top img-card" alt="..." />
                    <div class="card-body">
                        <h6 class="text-muted mb-0">{{ username }}</h6>
                        <div class="info-account d-flex">
                            <div class="follower me-auto">
                                <span class="text-muted">
                                    follower
                                    <span class="count">0</span>
                                </span>
                            </div>
                            <div class="following">
                                <span class="text-muted">
                                    following
                                    <span class="count">0</span>
                                </span>
                            </div>
                        </div>
                        <hr />
                        <p>{{ bio }}</p>
                        <hr />
                        <router-link to="/profil-edit" class="btn btn-primary"
                            >Edit Profil</router-link
                        >
                    </div>
                </div>
            </div>
            <div class="col-9">
                <h3 class="text-muted">Postingan</h3>
                <div class="container">
                    <Post ref="post" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import IconShare from "../icons/IconShare.vue";
import IconLike from "../icons/IconLike.vue";
import IconComment from "../icons/IconComment.vue";
import Post from "../partials/Post.vue";
export default {
    data() {
        return {
            username: "",
            bio: "",
            image: "",
        };
    },
    mounted() {
        if (JSON.parse(localStorage.isLogin) === false) {
            this.$router.push({
                name: "login",
            });
        } else {
            this.image = JSON.parse(localStorage.user).image;
            this.username = JSON.parse(localStorage.user).username;
            this.bio = JSON.parse(localStorage.user).bio;
            this.$refs.post.userPost(JSON.parse(localStorage.user).id);
        }
    },
    components: {
        Post,
        IconShare,
        IconLike,
        IconComment,
    },
};
</script>

<style>
.img-card {
    height: 259px;
}
</style>
