import $ from 'jquery'

require('bootstrap')
require('./AdminLTE')

import Vue from 'vue'

import ElementUI from 'element-ui'
import util from '../util/index'

window.$ = window.jQuery = $
window.Vue = require('vue')

Vue.use(ElementUI)
Vue.use(util)

