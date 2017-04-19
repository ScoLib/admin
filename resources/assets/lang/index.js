import Vue from 'vue';
import VueI18n from 'vue-i18n';
import deepmerge from 'deepmerge';

import en from './en';
import zh from './zh-CN';

import EleEn from 'element-ui/lib/locale/lang/en';
import EleZh from 'element-ui/lib/locale/lang/zh-CN';

Vue.use(VueI18n);

const locales = {
    en: deepmerge(en,EleEn),
    'zh-CN': deepmerge(zh, EleZh),
};

Object.keys(locales).forEach(function (lang) {
    Vue.locale(lang, locales[lang]);
});

Vue.config.lang = window.Lang;

export default locales;