<template>
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark text-light">
        <div class="container">
            <router-link class="navbar-brand" :to="{ name: 'home' }"
                >TwitS</router-link
            >
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/">
                            Beranda
                        </router-link>
                    </li>
                    <li class="nav-item me-auto">
                        <router-link class="nav-link" to="/cari">
                            Cari
                        </router-link>
                    </li>
                </ul>
                <div class="ms-auto">
                    <div v-if="isLogin" class="d-flex">
                        <router-link
                            v-on:click="reset"
                            to="/notifikasi"
                            class="nav-item list-style-none me-4 notif position-relative"
                        >
                            <IconBell class="mouse-pointer" />

                            <span
                                v-if="unread_notif > 0"
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            >
                                {{ unread_notif }}
                                <span class="visually-hidden"
                                    >unread messages</span
                                >
                            </span>
                        </router-link>
                        <li class="nav-item dropdown list-style-none">
                            <a
                                class="nav-link dropdown-toggle"
                                href="#"
                                id="navbarDropdownMenuLink"
                                role="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                {{ username }}
                            </a>
                            <ul
                                class="dropdown-menu"
                                aria-labelledby="navbarDropdownMenuLink"
                            >
                                <li>
                                    <router-link
                                        class="dropdown-item"
                                        to="/profil"
                                    >
                                        Profil
                                    </router-link>
                                </li>
                                <li>
                                    <a
                                        class="dropdown-item"
                                        v-on:click="logOut"
                                    >
                                        Keluar
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </div>
                    <div v-else class="login">
                        <li class="list-style-none nav-item">
                            <router-link
                                to="/login"
                                class="nav-link text-primary mb-0"
                                >Login Now</router-link
                            >
                        </li>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
import IconBell from "../icons/IconBell.vue";
export default {
    data() {
        return {
            isLogin: "",
            unread_notif: "",
        };
    },
    async beforeMount() {
        this.isLogin = JSON.parse(localStorage.isLogin);
        if (this.isLogin) {
            this.unread_notif = JSON.parse(localStorage.user).unread_notif;
            this.username = JSON.parse(localStorage.user).username;
            console.log(this.username);
        }
    },

    components: {
        IconBell,
    },

    methods: {
        reset() {
            this.unread_notif = 0;
            let user = JSON.parse(localStorage.user);
            user.unread_notif = 0;
            localStorage.setItem("user", JSON.stringify(user));
        },
        logOut() {
            axios.post("http://127.0.0.1:8000/api/logout").then((response) => {
                console.log(response);
                localStorage.isLogin = false;
                localStorage.removeItem("user");
                this.$router.go();
            });
        },
    },
};
</script>

<style>
.list-style-none {
    list-style: none;
}

.mouse-pointer {
    cursor: pointer;
}

.notif {
    color: white;
}

.dropdown-item.router-link-active {
    color: #212529 !important;
}

.notif:hover {
    color: rgb(216, 216, 216);
}
</style>
