import IndexComponent from "./components/IndexComponent";
import DashboardComponent from "./components/DashboardComponent";
import LoginComponent from "./components/LoginComponent"
import RegisterComponent from "./components/RegisterComponent";

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
        },
        {
            path: '/register',
            component: RegisterComponent
        }
    ]
}