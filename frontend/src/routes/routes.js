import ProductList from '../components/ProductList';
import AddProduct from '../components/AddProduct';
import {createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        name:'ProductList',
        path:'/',
        component:ProductList
    },
    {
        name:'AddProduct',
        path:'/add_contact',
        component:AddProduct
    }
];
const router = createRouter(
    {
        history:createWebHistory(),
        routes
    }
)
export default router;
