<template>
    <div class="container mt-3">
        <h2>{{ user.name }}</h2>
        <div class="row">
            <div class="col-3">
                <div class="card">
                    <img
                        src="https://source.unsplash.com/600x600?man"
                        class="card-img-top img-card"
                        alt="..."
                    />
                    <div class="card-body">
                        <h6 class="text-muted mb-0">{{ user.username }}</h6>
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
                        <p>Nice guy from Indonesia</p>
                        <hr />
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
import Post from "../partials/Post.vue";
export default {
    data() {
        return {
            user: "",
        };
    },
    async mounted() {
        await axios
            .get(
                "http://127.0.0.1:8000/api/user/" + this.$route.params.username
            )
            .then((response) => {
                this.user = response.data;
                this.$refs.post.userPost(this.user.id);
            });
    },

    components: {
        Post,
    },
};
</script>

<style></style>
