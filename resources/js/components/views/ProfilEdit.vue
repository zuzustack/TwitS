<template>
    <div class="container w-75 mt-3">
        <div v-if="message" class="alert alert-success" role="alert">
            Account Has Changed
        </div>

        <h3 class="">Edit Profil</h3>
        <div class="container">
            <div class="mb-3">
                <input
                    class="form-control hidden"
                    @change="uploadImage"
                    type="file"
                    id="formFile"
                />
                <label class="position-relative">
                    <img
                        :src="'/' + photo"
                        alt="Photo-Profil-User"
                        class="photo rounded-circle"
                    />
                    <h5 class="cursor-pointer">
                        <label
                            for="formFile"
                            class="cursor-pointer position-absolute top-75 start-50 translate-middle badge rounded-pill bg-primary"
                        >
                            Edit
                        </label>
                    </h5>
                </label>
            </div>

            <div class="form-floating mb-3">
                <input
                    v-model="name"
                    type="text"
                    class="form-control"
                    id="floatingInput"
                />
                <label for="floatingInput">Nama</label>
            </div>
            <div class="form-floating mb-3">
                <input
                    v-model="bio"
                    type="text"
                    class="form-control"
                    id="floatingInput"
                />
                <label for="floatingInput">Bio</label>
            </div>

            <div class="btn btn-primary me-3" v-on:click="upload">Edit</div>
            <div to="/profil" v-on:click="cancel" class="btn btn-primary">
                Kembali
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            message: false,
            name: "",
            bio: "",
            image: "",
            photo: "",
        };
    },

    beforeMount() {
        this.name = JSON.parse(localStorage.user).name;
        this.bio = JSON.parse(localStorage.user).bio;
        this.photo = JSON.parse(localStorage.user).image;
        this.image = "";
    },

    methods: {
        async uploadImage(e) {
            this.image = e.target.files[0];
            let data = new FormData();
            data.append("image", this.image);

            await axios
                .post("http://127.0.0.1:8000/api/upload/temp/user", data, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    this.photo = response.data.tempImage;
                });
        },

        async upload() {
            let data = new FormData();
            data.append("name", this.name);
            data.append("bio", this.bio);
            await axios
                .post("http://127.0.0.1:8000/api/update/user", data, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    this.message = response.data.message;
                    this.bio = response.data.bio;
                    this.name = response.data.name;

                    let localUser = JSON.parse(localStorage.user);
                    localUser["bio"] = this.bio;
                    localUser["name"] = this.name;
                    localUser["image"] = response.data.image;

                    localStorage.setItem("user", JSON.stringify(localUser));
                });

            setTimeout(() => {
                this.message = false;
            }, 3000);
        },

        cancel() {
            this.$router.push({
                path: "/profil",
            });
        },
    },
};
</script>

<style scoped>
.hidden {
    cursor: default !important;
    width: 0;
    height: 0;
    overflow: hidden;
    opacity: 0;
}

.photo {
    width: 100px;
    height: 100px;
}

.cursor-pointer {
    cursor: pointer !important;
}
</style>
