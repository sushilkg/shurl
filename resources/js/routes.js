import IndexComponent from "./components/IndexComponent";
import DashboardComponent from "./components/DashboardComponent";
import LoginComponent from "./components/LoginComponent.vue"

export default {
    mode: 'history',
    routes: [
        {
            path: '/',
            component: IndexComponent
        },
        {
            path: '/dashboard',
            component: DashboardComponent
        },
        {
            path: '/login',
            component: LoginComponent
        }
    ]
}