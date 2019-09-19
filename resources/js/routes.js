import IndexComponent from "./components/IndexComponent";
import DashboardComponent from "./components/DashboardComponent";

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
        }
    ]
}