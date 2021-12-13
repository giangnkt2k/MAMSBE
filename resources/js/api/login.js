import * as RequestApi from './request';
import request from '../utils/request.js';
import { template } from './template.js';

const urlAPI = {
    urlPOSTRegister: template`/auth/register`,
    urlPOSTRemindPassword: template`/auth/remind-password`,
    urlPOSTRefreshUser: template`/auth/refresh`,
};

export function postLogin(data) {
    return RequestApi.postOne(data);
}
export function postRegister(data) {
    return request.postRequest(urlAPI.urlPOSTRegister(), data);
}

export function urlPOSTRemindPassword(data) {
    return request.postRequest(urlAPI.urlPOSTRemindPassword(), data);
}

export function urlPOSTRefreshUser(data) {
    return request.postRequest(urlAPI.urlPOSTRefreshUser(), data);
}
