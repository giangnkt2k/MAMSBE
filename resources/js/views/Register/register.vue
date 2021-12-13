<template>
  <div>
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
                  <span>{{ $t('register_page.title') }}</span>
                </div>

                <div class="zone-input">
                  <b-form-input v-model="Account.name" :placeholder="$t('register_page.placeholder_name')" type="text" spellcheck="false" />
                  <b-form-input v-model="Account.phone" :placeholder="$t('register_page.placeholder_phone')" type="number" />
                  <b-form-input v-model="Account.email" :placeholder="$t('register_page.placeholder_email')" type="email" spellcheck="false" />
                  <b-form-input v-model="Account.password" :type="typePassword" :placeholder="$t('register_page.placeholder_password')" />
                  <b-form-input v-model="Account.password_confirmation" :type="typePassword" :placeholder="$t('register_page.placeholder_confirmation_password')" @keyup.enter="handleLogin()" />
                </div>

                <div class="login-row row forrr no-margin">
                  <p id="showPassword"> <i v-show="passwordLength" :class="showPasswordStatus" @click="showPassword"> {{ passwordText }} </i> </p>
                </div>

                <div class="zone-register">
                  <b-button @click="handleRegister()">{{ $t('register_page.button_register') }}</b-button>
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
import { postRegister } from '../../api/login';
import { MakeToast } from '../../utils/toast_message';

export default {

    name: 'Login',

    data() {
        return {

            // Logo
            logo: logo,

            // Account Login
            Account: {
                name: '',
                phone: '',
                email: '',
                password: '',
                password_confirmation: '',
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

        async handleRegister() {
            if (this.Account.name === '') {
                MakeToast({
                    variant: 'warning',
                    title: 'Warning',
                    content: 'Name is required, can not be empty.',
                });
            } else if (this.Account.phone === '') {
                MakeToast({
                    variant: 'warning',
                    title: 'Warning',
                    content: 'Phone is required, can not be empty.',
                });
            } else if (this.Account.email === '') {
                MakeToast({
                    variant: 'warning',
                    title: 'Warning',
                    content: 'Email is required, can not be empty.',
                });
            } else if (this.Account.password === '') {
                MakeToast({
                    variant: 'warning',
                    title: 'Warning',
                    content: 'Password is required, can not be empty.',
                });
            } else if (this.Account.password !== this.Account.password_confirmation) {
                MakeToast({
                    variant: 'warning',
                    title: 'Warning',
                    content: 'The confirmation password is not correct, please try again.',
                });
            } else if (this.Account.password.length < 8 || this.Account.password_confirmation.length < 8) {
                MakeToast({
                    variant: 'warning',
                    title: 'Warning',
                    content: 'Password must be at least 8 characters.',
                });
            } else if (this.Account.password_confirmation === '') {
                MakeToast({
                    variant: 'warning',
                    title: 'Warning',
                    content: 'Name is required, can not be empty.',
                });
            } else {
                const NEW_REGISTER_DATA = {
                    name: this.Account.name,
                    phone: this.Account.phone,
                    email: this.Account.email,
                    password: this.Account.password,
                    password_confirmation: this.Account.password_confirmation,
                };

                await postRegister(NEW_REGISTER_DATA)
                    .then((response) => {
                        if (response.code !== 200) {
                            MakeToast({
                                variant: 'warning',
                                title: 'Warning',
                                content: response.message,
                            });
                        } else {
                            MakeToast({
                                variant: 'success',
                                title: 'Successfully',
                                content: 'Register Successfull !',
                            });
                            this.$router.push('/login');
                        }
                    })
                    .catch((error) => {
                        MakeToast({
                            variant: 'warning',
                            title: 'Warning',
                            content: error,
                        });
                    });
            }
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
      margin-top: 150px;

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

        input {
          margin-top: 10px;
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
