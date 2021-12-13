import Cookies from 'js-cookie';
import { getLanguage } from '../../utils/getLang';

export default {
    state: {
        language: getLanguage(),
    },
    mutations: {
        SET_LANGUAGE(state, language) {
            state.language = language;
            Cookies.set('language', language);
        },
    },
    actions: {
        setLanguage({ commit }, language) {
            commit('SET_LANGUAGE', language);
        },
    },
    getters: {
        language(state) {
            return state.language;
        },
    },
};
