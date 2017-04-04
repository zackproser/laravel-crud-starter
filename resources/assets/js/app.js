
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

Vue.component('adminclient', require('./components/ItemManager.vue'));

/**
 * Create a Vue filter which will convert datetime values to human-legible format
 *
 * For use in admin item manager table
 *
 * @param  {String} value A datetime string (e.g: 2017-02-19 01:03:57)
 * @return {String} value A slightly easier to read datetime string (e.g: Sat Feb 18 2017 22:07:51 GMT-0800 (PST))
 */
Vue.filter('formatDate', function(value) {
  if (value) {
    return new Date(Date.parse(value)).toString();
  }
});

/**
 * Create a Vue filter which will remove any non-alphanumeric characters from an error string
 *
 * @param  {String} value An error message string which may or may not include non-alphanumeric characters
 * @return {String} value A string from which all non-alphanumeric characters have been removed
 */
Vue.filter('plaintext', function(value) {
  if (value) {
    return String(value).replace('/\W/', ' ');
  }
});

const app = new Vue({
  el: '#app'
});