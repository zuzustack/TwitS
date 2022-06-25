import "./bootstrap";
import { createApp } from "vue";
import App from "./components/App.vue";
import VueAxios from "vue-axios";
import router from "./routers/router";

import axios from "axios";

const app = createApp(App);

app.use(VueAxios, axios);
app.use(router);

app.mount("#app");
