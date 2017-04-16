import deepmerge from 'deepmerge';

import en from './en';
import zh from './zh-CN';

import EleEn from 'element-ui/lib/locale/lang/en';
import EleZh from 'element-ui/lib/locale/lang/zh-CN';

export default {
    en: deepmerge(en,EleEn),
    'zh-CN': deepmerge(zh, EleZh),
}