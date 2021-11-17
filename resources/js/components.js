import Vue from "vue";

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('events', require('./components/backend/Events').default);
Vue.component('add-event', require('./components/backend/AddEvent').default);
Vue.component('edit-event', require('./components/backend/EditEvent').default);
Vue.component('view-event', require('./components/backend/ViewEvent').default);
Vue.component('settings', require('./components/backend/Settings').default);
