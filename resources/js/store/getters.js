const getters = {
    language: state => state.app.language,
    address: state => state.user.userInfo.address,
    avatar: state => state.user.userInfo.avatar,
    email: state => state.user.userInfo.email,
    fax: state => state.user.userInfo.fax,
    gender: state => state.user.userInfo.gender,
    id: state => state.user.userInfo.id,
    name: state => state.user.userInfo.name,
    phone: state => state.user.userInfo.phone,
    status: state => state.user.userInfo.status,
    token: state => state.user.token,
};

export default getters;
