import Bookable from "./bookable/Bookable";
import VueRouter from "vue-router";

const routes = [
    {
        path: "/",
        component:Bookable,
        name:"home",
    }
];

const router = new VueRouter({
    routes,
    mode: "history"
});

export default router;
