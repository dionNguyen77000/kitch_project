const { default: Echo } = require('laravel-echo');
require('./bootstrap');
require('./store/subscriber')

import {createApp} from 'vue'
// import App from './App.vue'
// import Echo from 'laravel-echo';
import App_Stock from './App_Stock.vue'
import store from './store'
import router from './router'

//Loading component
import Loading from 'vue-loading-overlay';
import Header from './Pages/page_component/header.vue'
import Footer from './Pages/page_component/footer.vue'
import Sidebar from './Pages/page_component/sidebar.vue'
import Sidebar_Delivery from './Pages/page_component/sidebar_delivery.vue'
import Navbar from './Pages/page_component/Navbar.vue'
import SidebarHamburger from './components/SidebarHamburger.vue'




// app.mount('#app')

// call setupLoginedAuth in auth.js, this help to authenticate the user
store.dispatch('auth/setUpLoginedAuth',localStorage.getItem('token')).then(()=> {
        // const app = createApp(App)
    const app = createApp(App_Stock)

    // register global component
    app.component('Header',Header)
    app.component('Navbar',Navbar)
    app.component('Footer',Footer)
    app.component('Sidebar',Sidebar)
    app.component('Sidebar_Delivery',Sidebar_Delivery)
    app.component('SidebarHamburger',SidebarHamburger)
    app.component('Loading', Loading)

    // add plugins 
    app.use(store)
    app.use(router)
    app.config.globalProperties.user = window.User
    app.mount('#app')
})





