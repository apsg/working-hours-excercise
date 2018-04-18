
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('alerts', require('./components/Alerts.vue'));
Vue.component('employee-working-hours', require('./components/EmployeeWorkingHours.vue'));

const app = new Vue({
    el: '#app',

    data: {
    	is_alert_visible: false,

    },

    methods: {
    	
    	showMessage(type, message){
    		this.$refs.alerts.addAlert(type, message);
    	},

    	onSaved(data){
    		this.showMessage('success', data);
    	}
    }

});
