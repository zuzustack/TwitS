import Home from "../components/views/Home.vue";
import Search from "../components/views/Search.vue";
import Notification from "../components/views/Notification.vue";
import Profile from "../components/views/Profile.vue";
import Login from "../components/views/Login.vue";
import Register from "../components/views/Register.vue";
import ProfilEdit from "../components/views/ProfilEdit.vue";
import UserInfo from "../components/views/UserInfo.vue";
import NotFound from "../components/views/NotFound.vue";
import Share from "../components/views/SharingPost.vue";

import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/",
        name: "home",
        component: Home,
    },
    {
        path: "/cari",
        name: "cari",
        component: Search,
    },
    {
        path: "/notifikasi",
        name: "notifikasi",
        component: Notification,
    },
    {
        path: "/profil",
        name: "profil",
        component: Profile,
    },
    {
        path: "/sharing/:slug",
        name: "share",
        props: true,
        component: Share,
    },
    {
        path: "/user/:username",
        name: "userInfo",
        props: true,
        component: UserInfo,
    },
    {
        path: "/profil-edit",
        name: "profilEdit",
        component: ProfilEdit,
    },
    {
        path: "/login",
        name: "login",
        component: Login,
    },
    {
        path: "/register",
        name: "register",
        component: Register,
    },
    {
        path: "/:catchAll(.*)",
        name: "notFound",
        component: NotFound,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
