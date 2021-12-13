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
                  <b-form-input v-model="Account.email" :placeholder="$t('register_page.placeholder_email')" type="email" spellcheck="false" />

                </div>

                <div class="zone-register">
                  <b-button @click="handleRemindPassword()">{{ $t('remind_password_page.button_submit') }}</b-button>
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
import { urlPOSTRemindPassword } from '../../api/login';
import { MakeToast } from '../../utils/toast_message';

export default {

    name: 'RemindPassword',

    data() {
        return {

            // Logo
            logo: logo,

            // Remind Password Information
            Account: {
                email: '',
            },

        };
    },

    computed: {

    },

    watch: {

    },

    methods: {

        // async handleRemindPassword() {
        async handleRemindPassword() {
            const REMIND_PASSWORD_INFOR = {
                email: this.Account.email,
            };
            // console.log('Day la ket qua gui di', REMIND_PASSWORD_INFOR);

            await urlPOSTRemindPassword(REMIND_PASSWORD_INFOR)
                .then((response) => {
                    console.log('Status code return', response.code);

                    if (response.code === 200) {
                        MakeToast({
                            variant: 'success',
                            title: 'Successfully',
                            content: 'Send Recovery Email Successfully !',
                        });
                    } else {
                        MakeToast({
                            variant: 'warning',
                            title: 'Warning',
                            content: response.message,
                        });
                    }
                })
                .catch((error) => {
                    MakeToast({
                        variant: 'warning',
                        title: 'Warning',
                        content: error,
                    });
                });
            // console.log('Manh da di vao day');
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
