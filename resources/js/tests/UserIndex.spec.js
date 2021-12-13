import { shallowMount, createLocalVue, mount } from '@vue/test-utils';
import store from '@/store';
import UserIndex from '@/views/User/index.vue';
import { postLogin } from '@/api/login';
import { getAllUser } from '../api/user';

const componentName = 'UserIndex';
describe('Test Component ' + componentName, () => {
    const localVue = createLocalVue();
    const wrapper = shallowMount(UserIndex, { localVue, store });
    let TOKEN = null, USER;
    // const handleLogin = jest.fn();
    let UserList = [];
    const fakeData = [
        {
            id: 1,
            username: 'Dfdf',
            email: 'test1@gmail.com',
        },
        {
            id: 2,
            username: 'Aliquam tenetur et r',
            email: 'david@gmail.com',
        },
    ];
    // wrapper.setMethods({ handleLogin });
    test('Case 1: Check is rendered', () => {
        expect(wrapper.html()).toContain('veho_' + componentName.toLowerCase());
    });
    test('Case 2: Check render data', async() => {
        const wrapper = mount(UserIndex, {
            data() {
                return { UserList: fakeData };
            },
        });
        expect(wrapper.html()).toContain('test1@gmail.com');
    });

    test('Case 3: Check call api and render data', async() => {
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
        await store.dispatch('saveLogin', { USER, TOKEN });
        const PAGINATION = {
            page: 1,
            per_page: 10,
        };
        await getAllUser(PAGINATION)
            .then((res) => {
                UserList = res.data;
            })
            .catch((err) => {
                console.log(err);
            });
        const wrapper = mount(UserIndex, {
            data() {
                return { UserList };
            },
        });
        expect(wrapper.html()).toContain('test@gmail.com');
    });
    // test('Case 4: Click to button Create => call function createNewCity()', async() => {
    // const mockRoute = {
    //     params: {
    //         id: 1,
    //     },
    // };
    // const mockRouter = {
    //     push: jest.fn(),
    // };

    // const wrapper = mount(UserIndex, {
    //     mocks: {
    //         $route: { name: 'user_create' },
    //         // $router: mockRouter,
    //     },
    // });
    //
    // await wrapper.find('.btn_create').trigger('click');

    // expect(mockRouter.push).toHaveBeenCalledTimes(2);
    // expect(mockRouter.push).toHaveBeenCalledWith('/posts/1/edit');
    // const createNewCity = jest.fn();cc
    // await wrapper.find('.btn_create').trigger('click');
    // expect(wrapper.html()).toContain('btn_create');
    // expect(createNewCity).toHaveBeenCalled();?
    // });
    // test('Case 4: Click to button Detail => call function goToDetailScreen()', async() => {
    //     const wrapper = mount(UserIndex, {
    //         data() {
    //             return { UserList: fakeData };
    //         },
    //     });
    //     const goToDetailScreen = jest.fn();
    //     wrapper.find('.btn_detail').trigger('click');
    //     // expect(wrapper.html()).toContain('test@gmail.com');
    //     expect(goToDetailScreen).toHaveBeenCalled();
    // });

    // test('Case 5: Click to button Edit => call function goToEditScreen()', async() => {
    //     const goToEditScreen = jest.fn();
    //     // wrapper.find('.btn_detail').trigger('click');
    //     // expect(goToEditScreen).toHaveBeenCalled();
    // });
    //
    // test('Case 6: Click to button Delete => call function confirmationForm()', async() => {
    //     const confirmationForm = jest.fn();
    //     // wrapper.find('.btn_detail').trigger('click');
    //     // expect(confirmationForm).toHaveBeenCalled();
    // });
});
