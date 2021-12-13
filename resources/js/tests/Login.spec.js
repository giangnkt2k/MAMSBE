import { shallowMount, createLocalVue } from '@vue/test-utils';
import store from '@/store';
import Login from '@/views/Login/Login.vue';
import { postLogin } from '@/api/login';

const componentName = 'Login';
describe('Test Component ' + componentName, () => {
    const localVue = createLocalVue();
    const wrapper = shallowMount(Login, { localVue, store });
    const Account = {
        url: '/auth/login',
        username: 'test@gmail.com',
        password: '123456',
    };
    wrapper.setData({ Account });
    const handleLogin = jest.fn();
    wrapper.setMethods({ handleLogin });
    let TOKEN = null, USER;
    test('Case 1: Check is rendered', () => {
        expect(wrapper.html()).toContain('veho_' + componentName.toLowerCase());
    });
    test('Case 2: Input (username, password)', async() => {
        expect(wrapper.vm.Account.username).toBe(Account.username);
        expect(wrapper.vm.Account.password).toBe(Account.password);
    });
    test('Case 3: Check call function handleLogin', async() => {
        wrapper.find('.btn_submit').trigger('click');
        expect(handleLogin).toHaveBeenCalled();
    });
    test('Case 4: Check function call api and save token', async() => {
        const Account = {
            url: '/auth/login',
            user_name: 'test@gmail.com',
            password: '123456',
        };
        await postLogin(Account)
            .then((res) => {
                TOKEN = res.data.access_token;
                USER = res.data.profile;
            })
            .catch((err) => {
                console.log(err);
            });
        expect(TOKEN).not.toBeNull();
        await store.dispatch('saveLogin', { USER, TOKEN });
        expect(store.getters.token).toBe(TOKEN);
        expect(store.getters.userInfo.email).toStrictEqual(USER.email);
    });
});
