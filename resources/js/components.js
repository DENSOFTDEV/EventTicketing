import Vue from "vue";

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('events', require('./components/backend/Events').default);
Vue.component('settings', require('./components/backend/Settings').default);
