import Bookables from './bookables/Bookables';
import Bookable from './bookable/Bookable';
import Review from './review/Review';
import VueRouter from 'vue-router';
import Basket from './basket/Basket';
import Login from './auth/Login';
import register from './auth/Register';
import {isLoggedIn} from './shared/utilis/auth';


const routes = [
	{
		path: '/',
		component:Bookables,
		name:'home',
        meta:{
            requiresAuth:true
        }

	},
	{
		path: '/bookable/:id',
		component:Bookable,
		name:'bookable',
        meta:{
            requiresAuth:true
        }

	},
	{
		path: '/review/:id',
		component:Review,
		name:'review',
        meta:{
            requiresAuth:true
        }

	},
	{
		path: '/basket',
		component:Basket,
		name:'basket',
        meta:{
            requiresAuth:true
        }

	},
    {
        path: '/auth/login',
        component: Login,
        name:'login',

    },
    {
        path: '/auth/register',
        component: register,
        name:'register',

    }

];

const router = new VueRouter({
	routes,
	mode: 'history'
});

router.beforeEach(
    (to,from,next)=>{
        if(to.matched.some(record => record.meta.requiresAuth)   ){
            if(!isLoggedIn()){
                sessionStorage.setItem('redirectPath', to.path)
                next({ name: 'login' })
            }
            else {
                next();
            }
        }else {
            next();
        }
    }
)
export default router;
