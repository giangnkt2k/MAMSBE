import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Layout from '../layout';

export const constantRoutes = [
    {
        path: '/redirect',
        component: Layout,
        redirect: { name: 'redirect' },
        hidden: true,
        children: [
            {
                path: '/redirect/:path*',
                component: () => import('../views/Redirect/index.vue'),
                name: 'redirect',
            },
        ],
    },
    {
        path: '',
        redirect: '/dashboard',
        meta: {
            title: 'routes.dashboard',
            icon: 'icofont-institution',
        },
        hidden: true,
    },
    {
        path: '/dashboard',
        redirect: '/dashboard/index',
        component: Layout,
        meta: {
            title: 'routes.dashboard',
            icon: 'icofont-institution',
        },
        children: [
            {
                path: 'index',
                component: () => import('../views/Dashboard/index.vue'),
                meta: {
                    title: 'routes.dashboard',
                    icon: 'icofont-institution',
                },
            },
        ],
    },
    {
        path: '/admin',
        redirect: '/admin/index',
        component: Layout,
        meta: {
            title: 'routes.admin',
            icon: 'icofont-crown',
        },
        children: [
            {
                path: 'index',
                component: () => import('../views/Admin/index'),
                meta: {
                    title: 'routes.admin',
                    icon: 'icofont-crown',
                },
            },
        ],
    },
    {
        path: '/city',
        redirect: '/city/index',
        component: Layout,
        meta: {
            title: 'routes.city',
            icon: 'icofont-favourite',
        },
        children: [
            {
                path: 'index',
                component: () => import('../views/City/index'),
                meta: {
                    title: 'routes.city',
                    icon: 'icofont-favourite',
                },
            },
            {
                path: 'create',
                component: () => import('../views/City/create'),
                hidden: true,
                meta: {
                    title: 'routes.city',
                    icon: 'icofont-favourite',
                },
            },
            {
                path: 'detail/:id',
                component: () => import('../views/City/detail'),
                hidden: true,
                meta: {
                    title: 'routes.city',
                    icon: 'icofont-favourite',
                },
            },
            {
                path: 'edit/:id',
                component: () => import('../views/City/edit'),
                hidden: true,
                meta: {
                    title: 'routes.city',
                    icon: 'icofont-favourite',
                },
            },
        ],
    },
    {
        path: '/user',
        name: 'user',
        redirect: '/user/index',
        component: Layout,
        meta: {
            title: 'routes.user',
            icon: 'icofont-ui-user',
        },
        children: [
            {
                path: 'index',
                component: () => import('../views/User/index'),
                meta: {
                    title: 'routes.user',
                    icon: 'icofont-ui-user',
                },
            },
            {
                path: 'create',
                name: 'user_create',
                component: () => import('../views/User/create'),
                hidden: true,
                meta: {
                    title: 'routes.user',
                    icon: 'icofont-ui-user',
                },
            },
            {
                path: 'detail/:id',
                component: () => import('../views/User/detail'),
                hidden: true,
                meta: {
                    title: 'routes.user',
                    icon: 'icofont-ui-user',
                },
            },
            {
                path: 'edit/:id',
                component: () => import('../views/User/edit'),
                hidden: true,
                meta: {
                    title: 'routes.user',
                    icon: 'icofont-ui-user',
                },
            },
        ],
    },
    {
        path: '/setting',
        redirect: '/setting/index',
        component: Layout,
        meta: {
            title: 'routes.setting',
            icon: 'icofont-ui-settings',
        },
        children: [
            {
                path: 'index',
                component: () => import('../views/Setting/index'),
                meta: {
                    title: 'routes.setting',
                    icon: 'icofont-ui-settings',
                },
            },
            {
                path: 'create',
                component: () => import('../views/Setting/create'),
                meta: {
                    title: 'routes.setting',
                },
                hidden: true,
            },
            {
                path: 'detail/:id',
                component: () => import('../views/Setting/detail'),
                hidden: true,
                meta: {
                    title: 'routes.setting',
                },
            },
            {
                path: 'edit/:id',
                component: () => import('../views/Setting/edit'),
                hidden: true,
                meta: {
                    title: 'routes.setting',
                },
            },
        ],
    },
    {
        path: '/roles',
        redirect: '/roles/index',
        component: Layout,
        meta: {
            title: 'routes.roles',
            icon: 'icofont-users-alt-6',
        },
        children: [
            {
                path: 'index',
                component: () => import('../views/Roles/index'),
                meta: {
                    title: 'routes.roles',
                },
            },
            {
                path: 'create',
                component: () => import('../views/Roles/create'),
                hidden: true,
                meta: {
                    title: 'routes.roles',
                },
            },
            {
                path: 'detail/:id',
                component: () => import('../views/Roles/detail'),
                hidden: true,
                meta: {
                    title: 'routes.roles',
                },
            },
            {
                path: 'edit/:id',
                component: () => import('../views/Roles/edit'),
                hidden: true,
                meta: {
                    title: 'routes.roles',
                },
            },
        ],
    },
    {
        path: '/profile',
        redirect: '/profile/index',
        component: Layout,
        meta: {
            title: 'routes.profile',
            icon: 'icofont-check',
        },
        children: [
            {
                path: 'index',
                component: () => import('../views/Profile/index'),
                meta: {
                    title: 'routes.profile',
                    icon: 'icofont-check',
                },
            },
        ],
    },
    {
        path: '/image',
        redirect: '/image/index',
        component: Layout,
        meta: {
            title: 'routes.image',
            icon: 'icofont-image',
        },
        children: [
            {
                path: 'index',
                component: () => import('../views/Image/index'),
                meta: {
                    title: 'routes.image',
                    icon: 'icofont-image',
                },
            },
        ],
    },
    {
        path: '/login',
        name: 'Login',
        component: () => import('../views/Login/Index'),
        hidden: true,
    },
    {
        path: '/register',
        name: 'Register',
        component: () => import('../views/Register/Index'),
        hidden: true,
    },
    {
        path: '/remind-password',
        name: 'RemindPassword',
        component: () => import('../views/RemindPassword/Index'),
        hidden: true,
    },
];

export const asyncRoutes = [];

const createRouter = () => new VueRouter({
    scrollBehavior: () => ({ y: 0 }),
    base: process.env.MIX_LARAVEL_PATH,
    routes: constantRoutes,
});

const router = createRouter();

export function resetRouter() {
    const newRouter = createRouter();
    router.matcher = newRouter.matcher;
}

export default router;
