import "./bootstrap";
import "../assets/vendor/libs/jquery/jquery.js";
import "../assets/vendor/libs/popper/popper.js";
import "../assets/vendor/js/bootstrap.js";
import "../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js";
import "../assets/vendor/libs/node-waves/node-waves.js";
import "../assets/vendor/libs/hammer/hammer.js";
import "../assets/vendor/js/menu.js";

// import "../assets/vendor/js/helpers.js";
// import "../assets/js/config.js";

import { createApp } from "vue";
import { createRouter, createWebHistory } from "vue-router";
import Routes from "./routes.js";

const app = createApp({});
import { createIntl } from "vue-intl";

const router = createRouter({
    routes: Routes,
    history: createWebHistory(),
});

app.use(router);
app.use(
    createIntl({
        locale: "id",
        defaultLocale: "id",
    })
);

app.mount("#app");
