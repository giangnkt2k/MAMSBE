<template>
  <div id="veho_login">
    <b-col>
      <b-row>
        <b-col md="6" offset-md="3">
          <div class="zone-login">
            <div class="card">
              <div class="card-body">
                <div class="zone-logo">
                  <img :src="logo" alt="Logo">
                </div>

                <div class="zone-title">
                  <span>{{ $t('login_page.title') }}</span>
                </div>

                <div class="zone-input">
                  <b-form-input v-model="Account.username" name="username" :placeholder="$t('login_page.placeholder_username')" type="text" spellcheck="false" />
                  <b-form-input v-model="Account.password" name="password" :type="typePassword" :placeholder="$t('login_page.placeholder_password')" @keyup.enter="handleLogin()" />
                </div>

                <div class="login-row row forrr no-margin">
                  <p id="showPassword"> <i v-show="passwordLength" :class="showPasswordStatus" @click="showPassword"> {{ passwordText }} </i> </p>
                </div>

                <div class="zone-submit">
                  <b-button class="btn_submit" @click="handleLogin()">{{ $t('login_page.button_submit') }}</b-button>
                </div>

                <div class="zone-register">
                  <b-button @click="handleRegister()">{{ $t('login_page.button_register') }}</b-button>
                </div>

                <div class="zone-forgot-password">
                  <b-button @click="handForgotPassword()">{{ $t('login_page.button_forgot_password') }}</b-button>
                </div>

              </div>
            </div>
          </div>
        </b-col>
      </b-row>
    </b-col>
  </div>
</template>

<script>
// Import Logo
const logo = require('../../assets/images/veho_icon.png');

// Import API
import { postLogin } from '../../api/login';
import { MakeToast } from '../../utils/toast_message';

const urlAPI = {
    urlLogin: `/auth/login`,
};

export default {

    name: 'Login',

    data() {
        return {

            // Logo
            logo: logo,

            // Account Login
            Account: {
                username: '',
                password: '',
            },
            typePassword: 'password',
            showPasswordStatus: 'icofont-eye-blocked',
            passwordLength: false,
            passwordText: '',
        };
    },

    computed: {

        showPasswordEye() {
            return this.Account.password.length;
        },

    },

    watch: {

        showPasswordEye() {
            if (this.Account.password.length > 0) {
                this.passwordLength = true;
                this.passwordText = 'See password';
            } else {
                this.passwordLength = false;
                this.passwordText = '';
            }
        },

    },

    methods: {

        async handleLogin() {
            if (this.Account.username === '') {
                MakeToast({
                    variant: 'warning',
                    title: 'Warning',
                    content: 'Username can not be empty !',
                });
            } else if (this.Account.password === '') {
                MakeToast({
                    variant: 'warning',
                    title: 'Warning',
                    content: 'Password can not be empty !',
                });
            } else {
                const ACCOUNT = {
                    url: urlAPI.urlLogin,
                    user_name: this.Account.username,
                    password: this.Account.password,
                };

                await postLogin(ACCOUNT)
                    .then((response) => {
                        if (response.code === 200) {
                            const TOKEN = response.data.access_token;
                            const PROFILE = response.data.profile;

                            const USER = {
                                address: PROFILE.address || '',
                                avatar: PROFILE.avatar || '',
                                email: PROFILE.email || '',
                                fax: PROFILE.fax || '',
                                gender: PROFILE.gender || '',
                                id: PROFILE.id || '',
                                name: PROFILE.name || '',
                                phone: PROFILE.phone || '',
                                status: PROFILE.status || '',
                            };

                            this.$store.dispatch('saveLogin', { USER, TOKEN })
                                .then(() => {
                                    MakeToast({
                                        variant: 'success',
                                        title: 'Successfully',
                                        content: 'Login Successfull !',
                                    });

                                    this.$router.push('/');
                                })
                                .catch(() => {
                                    console.error('Can not saveLogin!');
                                });
                        } else if (response.code === 401) {
                            MakeToast({
                                variant: 'warning',
                                title: 'Warning',
                                content: response.message,
                            });
                        } else if (response.code === 422) {
                            MakeToast({
                                variant: 'warning',
                                title: 'Warning',
                                content: response.message,
                            });
                        }
                    })
                    .catch((error) => {
                        MakeToast({
                            variant: 'danger',
                            title: 'Failed',
                            content: error.message,
                        });
                    });
            }
        },

        handleRegister() {
            this.$router.push('/register');
        },

        handForgotPassword() {
            this.$router.push('/remind-password');
        },

        showPassword() {
            if (this.typePassword === 'password') {
                this.typePassword = 'text';
                this.showPasswordStatus = 'icofont-eye';
                this.passwordText = 'Hide password';
            } else {
                this.typePassword = 'password';
                this.showPasswordStatus = 'icofont-eye-blocked';
                this.passwordText = 'See password';
            }
        },
    },
};
</script>

<style lang="scss" scoped>
  .zone-login {
      min-width: 450px;
      max-width: 500px;
      margin: 0 auto;

      #showPassword {
        margin-top: 10px;
        margin-left: 15px;
      }

      .zone-logo {
        text-align: center;

        img {
          height: 112px;
          width: auto;
        }

        margin-bottom: 20px;
      }

      .zone-title {
        text-align: center;
        overflow: hidden;
        margin-bottom: 20px;

        span {
          font-size: 25px;
          font-weight: 700;
        }
      }

      .zone-input {
        input[type="text"]:first-child {
          margin-bottom: 20px;
        }

        input {
          &:focus {
            border-color: #f98404;
          }
        }
      }

      .zone-submit {
        margin-top: 20px;

        button {
            width: 100%;
            background-color: #f98404;
            border: none;

            &:focus {
              background-color: #f98404;
            }

            &:hover {
              opacity: 0.8;
            }
        }
      }

      .zone-register {
        margin-top: 20px;

        button {
            width: 100%;
            background-color: #3fb0ac;
            border: none;

            &:focus {
              background-color: #f98404;
            }

            &:hover {
              opacity: 0.8;
            }
        }
      }

      .zone-forgot-password {
        margin-top: 20px;

        button {
            width: 100%;
            background-color: #173e43;
            border: none;

            &:focus {
              background-color: #f98404;
            }

            &:hover {
              opacity: 0.8;
            }
        }
      }
  }
</style>
