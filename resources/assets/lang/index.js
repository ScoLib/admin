import Vue from 'vue';
import VueI18n from 'vue-i18n';
// import deepmerge from 'deepmerge';

import en from './en';
import zh_CN from './zh-CN';

import enLocale from 'element-ui/lib/locale/lang/en';
import zh_CN_Locale from 'element-ui/lib/locale/lang/zh-CN';

// import zhLocale from 'iview/src/locale/lang/zh-CN';
// import enLocale from 'iview/src/locale/lang/en-US';

Vue.config.lang = 'zh-CN';
if (typeof window.Admin != 'undefined') {
    Vue.config.lang = window.Admin.Lang;
}

Vue.use(VueI18n);

const messages = {
    en: Object.assign(en, enLocale),
    'zh-CN': Object.assign(zh_CN, zh_CN_Locale)
}

const i18n = new VueI18n({
    locale: Vue.config.lang,
    fallbackLocale: 'en',
    messages
})

export default i18n;