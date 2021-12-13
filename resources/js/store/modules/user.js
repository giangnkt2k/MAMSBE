import Cookies from 'js-cookie';
import { getToken } from '../../utils/getToken';

function getUserInfo() {
    const USER_INFO = Cookies.get('userInfo');

    if (USER_INFO) {
        return JSON.parse(USER_INFO);
    }

    const USER = {
        address: '',
        avatar: '',
        email: '',
        fax: '',
        gender: '',
        id: '',
        name: '',
        phone: '',
        status: '',
    };

    return USER;
}

export default {
    state: {
        userInfo: getUserInfo(),
        token: getToken(),
        fileNameImport1: 'Unselected',
        fileNameImport2: 'Unselected',
        fileNameImport3: 'Unselected',
        checkMapData: '',
        checkLocation: '',
        checkActual: '',
    },
    mutations: {
        SET_ADDRESS(state, address) {
            state.userInfo.address = address;
        },
        SET_AVATAR(state, avatar) {
            state.userInfo.avatar = avatar;
        },
        SET_EMAIL(state, email) {
            state.userInfo.email = email;
        },
        SET_FAX(state, fax) {
            state.userInfo.fax = fax;
        },
        SET_GENDER(state, gender) {
            state.userInfo.gender = gender;
        },
        SET_ID(state, id) {
            state.userInfo.id = id;
        },
        SET_NAME(state, name) {
            state.userInfo.name = name;
        },
        SET_PHONE(state, phone) {
            state.userInfo.phone = phone;
        },
        SET_STATUS(state, status) {
            state.userInfo.status = status;
        },
        SET_TOKEN(state, token) {
            state.token = token;
        },
        SET_FILENAME1(state, fileName1) {
            state.fileNameImport1 = fileName1;
        },
        SET_FILENAME2(state, fileName2) {
            state.fileNameImport2 = fileName2;
        },
        SET_FILENAME3(state, fileName3) {
            state.fileNameImport3 = fileName3;
        },
        SET_LOCATION(state, locationMaster) {
            state.checkLocation = locationMaster;
        },
        SET_ACTUAL(state, actualPickData) {
            state.checkActual = actualPickData;
        },
        SET_MAP_DATA(state, mapData) {
            state.checkMapData = mapData;
        },
    },
    actions: {
        saveLogin({ commit }, userInfo) {
            commit('SET_ADDRESS', userInfo.USER.address);
            commit('SET_AVATAR', userInfo.USER.avatar);
            commit('SET_EMAIL', userInfo.USER.email);
            commit('SET_FAX', userInfo.USER.fax);
            commit('SET_GENDER', userInfo.USER.gender);
            commit('SET_ID', userInfo.USER.id);
            commit('SET_NAME', userInfo.USER.name);
            commit('SET_PHONE', userInfo.USER.phone);
            commit('SET_STATUS', userInfo.USER.status);
            commit('SET_TOKEN', userInfo.TOKEN);

            Cookies.set('token', userInfo.TOKEN);
            Cookies.set('userInfo', userInfo.USER);
        },

        logout({ commit }) {
            commit('SET_ADDRESS', '');
            commit('SET_AVATAR', '');
            commit('SET_EMAIL', '');
            commit('SET_FAX', '');
            commit('SET_GENDER', '');
            commit('SET_ID', '');
            commit('SET_NAME', '');
            commit('SET_PHONE', '');
            commit('SET_STATUS', '');
            commit('SET_TOKEN', '');

            Cookies.set('token', '');
            Cookies.set('userInfo', '');
        },
    },
    getters: {
        userInfo(state) {
            return state.userInfo;
        },
        address(state) {
            return state.userInfo.address;
        },
        avatar(state) {
            return state.userInfo.avatar;
        },
        email(state) {
            return state.userInfo.email;
        },
        fax(state) {
            return state.userInfo.fax;
        },
        gender(state) {
            return state.userInfo.gender;
        },
        id(state) {
            return state.userInfo.id;
        },
        name(state) {
            return state.userInfo.name;
        },
        phone(state) {
            return state.userInfo.phone;
        },
        status(state) {
            return state.userInfo.status;
        },
        token(state) {
            return state.token;
        },
        fileNameImport1(state) {
            return state.fileNameImport1;
        },
        fileNameImport2(state) {
            return state.fileNameImport2;
        },
        fileNameImport3(state) {
            return state.fileNameImport3;
        },
        checkMapData(state) {
            return state.checkMapData;
        },
        checkLocation(state) {
            return state.checkLocation;
        },
        checkActual(state) {
            return state.checkActual;
        },
    },
};
