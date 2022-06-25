<template>
    <div class="container mt-3">
        <h1>Notifikasi</h1>
        <hr />

        <div v-for="notification in notifications" class="card mb-3">
            <div class="card-body d-flex">
                <img
                    class="rounded-circle profil-picture me-3"
                    :src="notification.user.image"
                    alt=""
                />
                <p class="text-muted text-notification">
                    {{ notification.user.name }}, {{ notification.body }}
                    <IconFullLike
                        v-if="notification.type === 'like'"
                        class="text-danger"
                    />
                    <IconComment
                        v-else-if="notification.type === 'comment'"
                        class="text-success"
                    />
                </p>
            </div>
        </div>
    </div>
</template>

<script>
import IconFullLike from "../icons/IconFullLike.vue";
import IconComment from "../icons/IconComment.vue";

export default {
    data() {
        return {
            notifications: [],
        };
    },

    beforeMount() {
        axios
            .get("http://127.0.0.1:8000/api/notification/user")
            .then((response) => {
                this.notifications = response.data.notifications;
            });
    },

    components: {
        IconFullLike,
        IconComment,
    },
};
</script>

<style>
.text-notification {
    margin: 0;
    display: inline-block;
    line-height: 50px;
}
</style>
