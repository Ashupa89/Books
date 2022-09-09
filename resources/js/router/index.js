
import {createWebHistory, createRouter} from "vue-router";

import Register from '../pages/Register';
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';
import Books from '../components/Books';
import EditBook from '../components/EditBook';
import AddBook from '../components/AddBook';
import ViewBook from '../components/ViewBook'
export const routes = [
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard
    },
    {
        name: 'books',
        path: '/books',
        component: Books
    },
    {
        name: 'viewbook',
        path: '/books/view/:id',
        component: ViewBook
    },
    {
        name: 'addbook',
        path: '/books/add',
        component: AddBook
    },
    {
        name: 'editbook',
        path: '/books/edit/:id',
        component: EditBook
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
