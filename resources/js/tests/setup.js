import Vue from 'vue';
import { config } from '@vue/test-utils';
import BootstrapVue from 'bootstrap-vue';
require('dotenv').config();
Vue.use(BootstrapVue);

config.mocks.$t = key => key;

Vue.config.productionTip = false;
config.showDeprecationWarnings = false;
