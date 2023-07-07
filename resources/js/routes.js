import ListDashboard from "./pages/dashboard/ListDashboard.vue";
import ListCostumers from "./pages/costumers/ListCostumers.vue";
import ListProducts from "./pages/products/ListProducts.vue";
import ListCategories from "./pages/categories/ListCategories.vue";
export default [
    {
        path: "/admin/dashboard",
        name: "admin.dashboard",
        component: ListDashboard,
    },
    {
        path: "/admin/costumers",
        name: "admin.costumers",
        component: ListCostumers,
    },
    {
        path: "/admin/products",
        name: "admin.products",
        component: ListProducts,
    },
    {
        path: "/admin/categories",
        name: "admin.categories",
        component: ListCategories,
    },
];
