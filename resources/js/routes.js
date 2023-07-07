import ListDashboard from "./pages/dashboard/ListDashboard.vue";
import ListUsers from "./pages/users/ListUsers.vue";
import ListProducts from "./pages/products/ListProducts.vue";
import FormProducts from "./pages/products/FormProducts.vue";
import ListCategories from "./pages/categories/ListCategories.vue";
export default [
    {
        path: "/admin/dashboard",
        name: "admin.dashboard",
        component: ListDashboard,
    },
    {
        path: "/admin/users",
        name: "admin.users",
        component: ListUsers,
    },
    {
        path: "/admin/products",
        name: "admin.products",
        component: ListProducts,
    },
    {
        path: "/admin/products/create",
        name: "admin.products.create",
        component: FormProducts,
    },
    {
        path: "/admin/categories",
        name: "admin.categories",
        component: ListCategories,
    },
];
