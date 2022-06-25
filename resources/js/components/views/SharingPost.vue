<template>
    <div class="container mt-3">
        <div v-if="none">
            <h3 class="text-muted text-center">No Post</h3>
        </div>
        <div v-else class="card mb-2">
            <div class="card-body">
                <!-- Username -->
                <div class="profile-pos d-flex">
                    <img
                        class="rounded-circle profil-picture me-3"
                        :src="'/' + post.user.image"
                        alt=""
                    />
                    <div class="my-auto">
                        <h4 class="d-inline-block mb-0">
                            {{ post.user.name }}
                        </h4>
                        <router-link class="text-decoration-none" to="/">
                            <h6 class="text-muted mb-0">
                                {{ post.user.username }}
                            </h6>
                        </router-link>
                    </div>
                </div>
                <!-- Caption -->
                <p class="mt-3">
                    {{ post.caption }}
                </p>
                <!-- action -->
                <div v-if="isLogin" class="action-user mb-0 d-flex">
                    <div
                        v-on:click="like(post.id)"
                        class="love d-flex m-0 logo text-danger me-3"
                    >
                        <IconLike />
                        <small class=""> {{ post.likes_count }} </small>
                    </div>
                    <div
                        data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasRight"
                        aria-controls="offcanvasRight"
                        class="love d-flex m-0 logo text-success me-3"
                        v-on:click="show(post.id)"
                    >
                        <IconComment />
                        <small class=""> {{ post.comments_count }} </small>
                    </div>
                    <div
                        v-on:click="share(post.slug, post.id)"
                        data-bs-toggle="modal"
                        data-bs-target="#ShareModal"
                        class="love d-flex m-0 logo text-primary"
                    >
                        <IconShare />
                        <small class=""> {{ post.share }} </small>
                    </div>
                </div>

                <div class="d-flex flex-end">
                    <small class="ms-auto text-muted"></small>
                </div>
            </div>
        </div>
    </div>

    <Modal ref="modal" />
    <Comments :post="post" :show="showComment" />
</template>

<script>
import Comments from "../partials/Comment.vue";
import Modal from "../partials/Modal.vue";
import IconShare from "../icons/IconShare.vue";
import IconComment from "../icons/IconComment.vue";
import IconLike from "../icons/IconLike.vue";
export default {
    components: {
        IconShare,
        IconComment,
        IconLike,
        Comments,
        Modal,
    },
    data() {
        return {
            isLogin: JSON.parse(localStorage.isLogin),
            slug: this.$route.params.slug,
            post: {
                user: {},
            },
            showComment: "",
            none: false,
        };
    },
    async mounted() {
        await axios
            .get("http://127.0.0.1:8000/api/post/slug/" + this.slug)
            .then((response) => {
                if (response.data.post != null) {
                    this.post = response.data.post;
                    this.none = false;
                } else {
                    this.none = true;
                }
            });
    },

    methods: {
        async show(id) {
            this.showComment = true;
        },

        share(s, id) {
            this.$refs.modal.show(s, id);
        },

        async like(id) {
            await axios
                .post("http://127.0.0.1:8000/api/add/like/" + id)
                .then((response) => {
                    this.$router.go();
                });
        },
    },
};
</script>

<style></style>
