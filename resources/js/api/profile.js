import request from '../utils/request.js';
import { template } from './template.js';

const urlAPI = {
    urlGETProfile: template`/profile`,
    urlEditProfile: template `/profile`,
};

export function getProfileInfo(data) {
    return request.getRequest(urlAPI.urlGETProfile(), data);
}
export function editProfile(data) {
    return request.putRequest(urlAPI.urlEditProfile(), data);
}

