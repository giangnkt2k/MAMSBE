import request from '../utils/request.js';
import { template } from './template.js';

const urlAPI = {
    urlPOSTImage: template`/image`,
    urlPutImage: template`/image/edit/${'id'}`,
};

export function uploadImage(formData) {
    return request.postRequest(urlAPI.urlPOSTImage(), formData);
}
export function getAll(data) {
    return request.getRequest(data.url, data);
}
export function deleteImage(id) {
    return request.deleteRequest(id.url);
}
export function editImage(id, formData) {
    return request.postRequest(urlAPI.urlPutImage({ id: id }), formData);
}
