<template>
    <PostForm @updatePost="getPost" v-if="showForm && isLogin" />
    <div v-if="isLoad" class="posts container mt-3">
        <div v-if="posts.length > 0" v-for="(post, index) in posts">
            <div class="card mb-2">
                <div class="card-body">
                    <!-- Username -->
                    <div class="profile-pos d-flex">
                        <img
                            class="rounded-circle profil-picture me-3"
                            v-bind:src="'/' + post.user.image"
                            alt=""
                        />
                        <div class="d-flex my-auto w-100">
                            <div class="me-auto">
                                <h4 class="d-inline-block mb-0">
                                    {{ post.user.name }}
                                </h4>
                                <router-link
                                    class="text-decoration-none"
                                    :to="'/user/' + post.user.username"
                                >
                                    <h6 class="text-muted mb-0">
                                        {{ post.user.username }}
                                    </h6>
                                </router-link>
                            </div>
                            <div v-if="showOption" class="dropstart">
                                <IconThreeDot
                                    class="logo"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                    :value="20"
                                />
                                <ul class="dropdown-menu">
                                    <li
                                        v-on:click="warning(post.id, index)"
                                        data-bs-toggle="modal"
                                        data-bs-target="#OptionModal"
                                        class="dropdown-item logo"
                                    >
                                        Delete Post
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Caption -->
                    <p class="mt-3">
                        {{ post.caption }}
                    </p>
                    <!-- action -->
                    <div v-if="isLogin" class="action-user mb-0 d-flex">
                        <div
                            v-if="post.liked"
                            v-on:click="like(post.id, index)"
                            :class="['love d-flex m-0 logo me-3', status_text]"
                        >
                            <IconFullLike class="me-1" />
                            <small class=""> {{ post.likes_count }} </small>
                        </div>
                        <div
                            :disabled="isDisable"
                            v-else
                            v-on:click="like(post.id, index)"
                            :class="['love d-flex m-0 logo me-3', status_text]"
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
                        <small class="ms-auto text-muted">
                            {{ date[index] }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <h5 class="text-muted text-center">No Post.</h5>
        </div>
    </div>
    <div v-else class="d-flex justify-content-center">
        <div class="spinner-border" role="status">
            <span class="visually-hidden justify-self-center">Loading...</span>
        </div>
    </div>

    <ModalShare ref="modal" />
    <Comments :post="post" :show="showComment" />
    <ModalOption @send="hapus" v-if="showOption" ref="option" />
</template>

<script>
import PostForm from "./PostForm.vue";
import Comments from "./Comment.vue";
import ModalShare from "./ModalShare.vue";
import ModalOption from "./ModalDelete.vue";
import IconShare from "../icons/IconShare.vue";
import IconComment from "../icons/IconComment.vue";
import IconLike from "../icons/IconLike.vue";
import IconFullLike from "../icons/IconFullLike.vue";
import IconThreeDot from "../icons/IconThreeDot.vue";

export default {
    data() {
        return {
            status_text: "text-danger",
            posts: null,
            date: null,
            isDisable: false,
            post: null,
            showComment: false,

            isLoad: false,
        };
    },

    components: {
        ModalOption,
        ModalShare,
        Comments,
        IconShare,
        IconComment,
        IconLike,
        IconFullLike,
        PostForm,
        IconThreeDot,
    },

    beforeMount() {
        this.isLogin = JSON.parse(localStorage.isLogin);
    },

    props: {
        showForm: {
            type: Boolean,
            default: false,
        },
        showOption: {
            type: Boolean,
            default: false,
        },
    },

    methods: {
        async show(id) {
            await axios
                .get("http://127.0.0.1:8000/api/post/" + id)
                .then((response) => {
                    this.post = response.data.post;
                });
            this.showComment = true;
        },

        share(s, id) {
            this.$refs.modal.show(s, id);
        },
        async getPost(search = null) {
            this.isLoad = false;
            if (search == "" || search == null) {
                await axios
                    .get("http://127.0.0.1:8000/api/posts")
                    .then((response) => {
                        this.posts = response.data.posts;
                        this.date = response.data.date;
                    });
            } else {
                await axios
                    .get("http://127.0.0.1:8000/api/post/search/" + search)
                    .then((response) => {
                        this.posts = response.data.posts;
                        this.date = response.data.date;
                    });
            }
            this.isLoad = true;
        },

        async like(id, index) {
            if (!this.isDisable) {
                await axios
                    .post("http://127.0.0.1:8000/api/add/like/" + id)
                    .then((response) => {
                        this.status_text = "text-secondary";
                        this.isDisable = true;
                        if (this.posts[index].liked) {
                            this.posts[index].likes_count -= 1;
                        } else {
                            this.posts[index].likes_count += 1;
                        }
                        this.posts[index].liked = !this.posts[index].liked;
                    });
            }

            setTimeout(() => {
                this.isDisable = false;
                this.status_text = "text-danger";
            }, 900);
        },

        async userPost(id) {
            await axios
                .get("http://127.0.0.1:8000/api/user/" + id + "/post")
                .then((response) => {
                    this.posts = response.data.posts;
                    this.date = response.data.date;
                });
            this.isLoad = true;
        },

        warning(id, index) {
            this.$refs.option.setId(id, index);
        },

        async hapus(data) {
            await axios
                .post("http://127.0.0.1:8000/api/delete/post", {
                    id: data.id,
                })
                .then((response) => {
                    this.posts.splice(data.index, data.index);
                });
        },
    },
};
</script>

<style>
.profil-picture {
    width: 60px;
    height: 60px;
}

.logo {
    cursor: pointer;
}
</style>
