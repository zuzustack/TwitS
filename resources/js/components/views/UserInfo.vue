<template>
    <div class="container mt-3">
        <div v-if="!isLoad">
            <div v-if="!noUser" class="">
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
                                <h6 class="text-muted mb-0">
                                    {{ user.username }}
                                </h6>
                                <div class="info-account d-flex">
                                    <div class="follower me-auto">
                                        <router-link
                                            :to="{
                                                path: `/user/${user.username}/follower`,
                                            }"
                                            class="text-muted text-decoration-none"
                                        >
                                            Follower
                                            <span class="count">{{
                                                user.followers_count
                                            }}</span>
                                        </router-link>
                                    </div>
                                    <div class="following">
                                        <router-link
                                            class="text-muted text-decoration-none"
                                            :to="{
                                                path: `/user/${user.username}/following`,
                                            }"
                                        >
                                            Following
                                            <span class="count">{{
                                                user.followings_count
                                            }}</span>
                                        </router-link>
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
                        <router-view
                            :backPath="path"
                            :showForm="false"
                            :id="id"
                        ></router-view>
                    </div>
                </div>
            </div>
            <div v-else class="">
                <h4 class="text-muted text-center">No User Found</h4>
            </div>
        </div>
        <div v-else class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden justify-self-center"
                    >Loading...</span
                >
            </div>
        </div>
    </div>
</template>

<script>
import Post from "../partials/Post.vue";
export default {
    data() {
        return {
            id: "",
            path: "",
            isLoad: true,
            class_btn: "",
            user: "",
            isDisable: false,
            show: false,
            followed: "",
            noUser: "",
        };
    },
    async beforeMount() {
        this.loadPage();
    },

    watch: {
        async "$route.params.username"() {
            this.show = false;
            this.isLoad = true;
            await this.loadPage();
        },
    },

    methods: {
        async loadPage() {
            await axios
                .get(
                    "http://127.0.0.1:8000/api/user/" +
                        this.$route.params.username
                )
                .then((response) => {
                    if (response.data.name) {
                        this.user = response.data;
                        this.id = this.user.id;
                        console.log(this.id);
                    } else {
                        this.noUser = true;
                    }
                });

            if (this.user.name) {
                await axios
                    .post("http://127.0.0.1:8000/api/check-follow", {
                        username: this.user.username,
                    })
                    .then((response) => {
                        if (response.data.status == true) {
                            this.followed = true;
                            if (
                                this.user.id != JSON.parse(localStorage.user).id
                            ) {
                                this.show = true;
                                this.class_btn = "btn btn-secondary";
                                this.status_follow = "Unfollow";
                            }
                        } else {
                            this.followed = false;
                            if (
                                this.user.id != JSON.parse(localStorage.user).id
                            ) {
                                this.show = true;
                                this.class_btn = "btn btn-primary";
                                this.status_follow = "Follow";
                            }
                        }
                    });
            }

            this.path = "/user/" + this.$route.params.username;
            this.isLoad = false;
        },
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

    beforeRouteEnter(to, from, next) {
        if (!JSON.parse(localStorage.isLogin)) {
            window.location.href = "/login";
        }
        next();
    },

    components: {
        Post,
    },
};
</script>

<style scoped>
.router-link-active {
    color: rgba(33, 37, 41, 0.75) !important;
}
</style>
