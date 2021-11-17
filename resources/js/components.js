import Vue from "vue";

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
//events
Vue.component('events', require('./components/backend/Events').default);
Vue.component('add-event', require('./components/backend/AddEvent').default);
Vue.component('edit-event', require('./components/backend/EditEvent').default);
Vue.component('view-event', require('./components/backend/ViewEvent').default);
//payments
Vue.component('payments', require('./components/backend/Payments').default);
//users
Vue.component('staff', require('./components/backend/Staff').default);
Vue.component('users', require('./components/backend/Users').default);
//settings
Vue.component('settings', require('./components/backend/Settings').default);
