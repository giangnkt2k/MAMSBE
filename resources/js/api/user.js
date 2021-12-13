import request from '../utils/request.js';
import { template } from './template.js';

const urlAPI = {
    urlGETUser: template`/user`,
    urlPOSTOneUser: template`/user`,
    urlGETOneUser: template`/user/${'id'}`,
    urlPUTOneUser: template`/user/${'id'}`,
    urlDELETEOneUser: template`/user/${'id'}`,
};

export function getAllUser(params) {
    return request.getRequest(urlAPI.urlGETUser(), params);
}

export function postOneUser(data) {
    return request.postRequest(urlAPI.urlPOSTOneUser(), data);
}

export function getOneUser(id, data) {
    return request.getRequest(urlAPI.urlGETOneUser({ id: id }), data);
}

export function putOneUser(id, data) {
    return request.putRequest(urlAPI.urlPUTOneUser({ id: id }), data);
}

export function deleteOneUser(id) {
    return request.deleteRequest(urlAPI.urlDELETEOneUser({ id: id }));
}
