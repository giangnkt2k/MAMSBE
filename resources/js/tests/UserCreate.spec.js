import { shallowMount, createLocalVue } from '@vue/test-utils';
import store from '@/store';
import UserCreate from '@/views/User/create.vue';

const componentName = 'UserCreate';
describe('Test Component ' + componentName, () => {
    const localVue = createLocalVue();
    const wrapper = shallowMount(UserCreate, { localVue, store });
    const dataCorrect = {
        username: 'david',
        email: 'david@gmail.com',
        phone: '12345',
        name: 'david bui',
        password: '12345678',
        fax: '123456789',
        address: 'ha noi',
        gender: '1',
    };
    wrapper.setData({ ...dataCorrect });
    let TOKEN = null, USER;
    const submitUserInfo = jest.fn();
    test('Case 1: Check is rendered', () => {
        expect(wrapper.html()).toContain('veho_' + componentName.toLowerCase());
    });
    test('Case 2: Input form', async() => {
        expect(wrapper.vm.username).toBe(dataCorrect.username);
    });
    test('Case 3: Validate username empty', async() => {
        const f = 'username';
        wrapper.vm[f] = '';
        wrapper.find('.btn_submit').trigger('click');
        expect(wrapper.vm.error).toBe(f + ' can not be empty');
    });
    test('Case 4: Validate email empty', async() => {
        const f = 'email';
        wrapper.vm[f] = '';
        wrapper.find('.btn_submit').trigger('click');
        expect(wrapper.vm.error).toBe(f + ' can not be empty');
    });
    test('Case 5: Validate password empty', async() => {
        const f = 'password';
        wrapper.vm[f] = '';
        wrapper.find('.btn_submit').trigger('click');
        expect(wrapper.vm.error).toBe(f + ' can not be empty');
    });
    test('Case 6: Validate email', async() => {
        const f = 'email';
        wrapper.setData({ ...dataCorrect });
        wrapper.vm[f] = 'wrong email';
        await wrapper.find('.btn_submit').trigger('click');
        expect(wrapper.vm.error).toContain('Email invalid!');
    });

    // test('Case 7: Check call function submitUserInfo', async() => {
    //     await wrapper.find('.btn_submit').trigger('click');
    //     // expect(wrapper.html()).toContain('Email invalid1!');
    //     expect(submitUserInfo).toHaveBeenCalled();
    // });
    test('Case 8: Check function call api and return success', async() => {
        wrapper.setData({ ...dataCorrect });
        await wrapper.vm.submitUserInfo();
        // console.log(wrapper.vm.isSuccess, wrapper.vm.error, 444);
        // expect(wrapper.vm.isSuccess).toBe(true);
    });
});
