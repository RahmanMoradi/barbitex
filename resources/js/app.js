/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
var numeral = require("numeral");
window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('last-order', require('./components/Market/LastOrder.vue').default);
Vue.component('buyer', require('./components/Market/Buyer.vue').default);
Vue.component('seller', require('./components/Market/Seller.vue').default);
Vue.component('chart', require('./components/Market/Chart.vue').default);
Vue.component('markets', require('./components/Market/Markets.vue').default);
Vue.component('currency-slide', require('./components/Home/CurrencySlides.vue').default);
Vue.component('currency-table', require('./components/Home/CurrencyTable.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.filter("formatNumber", function (value, percent = "0,0") {
    return numeral(value).format(percent);
});

Vue.filter("timeFormat", function (value) {
    var date = new Date(value * 1000);
    return date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds()
})

Vue.filter('noE', function (number) {
    if (Math.abs(number) < 1.0) {
        var e = parseInt(number.toString().split('e-')[1]);
        if (e) {
            number *= Math.pow(10, e - 1);
            number = '0.' + (new Array(e)).join('0') + number.toString().substring(2);
        }
    } else {
        var e = parseInt(number.toString().split('+')[1]);
        if (e > 20) {
            e -= 20;
            number /= Math.pow(10, e);
            number += (new Array(e + 1)).join('0');
        }
    }
    return number;
});

const app = new Vue({
    el: '#app',
});
