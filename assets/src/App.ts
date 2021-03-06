import Vue from 'vue';
import {VuetifyCustom} from "./Plugins/Vuetify";
import {router} from "./Domain/User/Guard.ts";
import {Store} from "./Domain/App/Store.ts";
import {ApiRouter} from "./Domain/App/ApiRouter";
import App from './App.vue';
import i18n from "./Plugins/I18n/I18n";
Vue.config.productionTip = false;

const app =  new Vue({
    el: '#app',
    i18n: i18n,
    router: router,
    apiRouter: ApiRouter,
    vuetify: VuetifyCustom,
    store: Store,
    render: h => h(App),
});

export default app;