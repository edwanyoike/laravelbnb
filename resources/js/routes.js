import exampleComponent from "./components/ExampleComponent";
import VueRouter from "vue-router";

const routes = [
    {
        path: "/",
        component:exampleComponent,
        name:"home",
    }
];

const router = new VueRouter({
    routes
});

export default router;
