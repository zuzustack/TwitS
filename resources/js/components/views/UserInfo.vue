<template>
    <div class="container mt-3">
        <h2>{{ user.name }}</h2>
        <div class="row">
            <div class="col-3">
                <div class="card">
                    <img
                        :src="'/' + user.image"
                        class="card-img-top img-card"
                        alt="..."
                    />
                    <div class="card-body">
                        <h6 class="text-muted mb-0">{{ user.username }}</h6>
                        <div class="info-account d-flex">
                            <div class="follower me-auto">
                                <span class="text-muted">
                                    follower
                                    <span class="count">{{
                                        user.followers_count
                                    }}</span>
                                </span>
                            </div>
                            <div class="following">
                                <span class="text-muted">
                                    following
                                    <span class="count">{{
                                        user.followings_count
                                    }}</span>
                                </span>
                            </div>
                        </div>
                        <hr />
                        <p>{{ user.bio }}</p>
                        <hr />
                        <button
                            v-if="show"
                            :disabled="isDisable"
                            :class="class_btn"
                            @click="follow"
                        >
                            {{ status_follow }}
                        </button>
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
            class_btn: "",
            user: "",
            isDisable: false,
            show: false,
            followed: "",
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

        await axios
            .post("http://127.0.0.1:8000/api/check-follow", {
                username: this.user.username,
            })
            .then((response) => {
                console.log(response.data.status);
                if (response.data.status == true) {
                    this.followed = true;
                    if (this.user.id != JSON.parse(localStorage.user).id) {
                        this.show = true;
                        this.class_btn = "btn btn-secondary";
                        this.status_follow = "Unfollow";
                    }
                } else {
                    this.followed = false;
                    if (this.user.id != JSON.parse(localStorage.user).id) {
                        this.show = true;
                        this.class_btn = "btn btn-primary";
                        this.status_follow = "Follow";
                    }
                }
            });
    },

    methods: {
        follow(e) {
            if ("btn btn-primary" == this.class_btn && !this.followed) {
                this.class_btn = "btn btn-secondary";
                this.status_follow = "Unfollow";
                this.user.followers_count += 1;

                axios
                    .post("http://127.0.0.1:8000/api/follow", {
                        username: this.user.username,
                        followed: this.followed,
                    })
                    .then((response) => {
                        console.log(response.data);
                        this.followed = true;
                    });
            } else {
                this.class_btn = "btn btn-primary";
                this.status_follow = "Follow";
                this.user.followers_count -= 1;

                axios
                    .post("http://127.0.0.1:8000/api/follow", {
                        username: this.user.username,
                        followed: this.followed,
                    })
                    .then((response) => {
                        console.log(response.data);
                        this.followed = false;
                    });
            }

            this.isDisable = true;

            setTimeout(() => {
                this.isDisable = false;
            }, 950);
        },
    },

    components: {
        Post,
    },
};
</script>

<style></style>
