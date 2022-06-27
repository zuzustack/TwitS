<template>
    <div class="modal" id="OptionModal" v-on:click="reset" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">Delete Post?</h5>
                </div>
                <div class="modal-body">
                    <p class="text-muted">
                        Jika Postingan ini dihapus tidak bisa dikembalikan lagi
                    </p>
                </div>
                <div class="modal-footer">
                    <div
                        class="btn btn-outline-danger"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        v-on:click="send()"
                    >
                        Delete
                    </div>
                    <div
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        class="btn btn-outline-secondary"
                    >
                        Cancel
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            id: "",
            index: "",
        };
    },
    methods: {
        setId(id, index) {
            this.id = id;
            this.index = index;
        },

        send() {
            this.$emit("send", {
                id: this.id,
                index: this.index,
            });
        },
    },
};
</script>

<style></style>
