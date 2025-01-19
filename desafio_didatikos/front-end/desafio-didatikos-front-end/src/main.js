import "./assets/main.css";

import { config } from "dotenv";
import { createApp } from "vue";
import App from "./App.vue";
import router from "./router/route";

config();

const app = createApp(App);

app.use(router);

app.mount("#app");
