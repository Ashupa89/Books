import AllBooks from './components/AddBook.vue';
import AddBook from './components/AllBook.vue';
import EditBook from './components/EditBook.vue';

export const routes = [
    {
        name: 'home',
        path: '/',
        component: AllBooks
    },
    {
        name: 'add',
        path: '/add',
        component: AddBook
    },
    {
        name: 'edit',
        path: '/edit/:id',
        component: EditBook
    }
];
