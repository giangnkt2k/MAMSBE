<template>
  <div id="veho_usercreate">
    <div class="main-page">
      <b-col>
        <b-row>
          <b-col>
            <div class="zone-create">
              <div class="card">
                <div class="card-body">

                  <div class="zone-input">
                    <b-form-input v-model="username" :placeholder="'Username'" />
                    <b-form-input v-model="email" :placeholder="'Email'" />
                    <b-form-input v-model="phone" style="margin-top: 20px;" :placeholder="'Phone'" />
                    <b-form-input v-model="name" :placeholder="'Name'" />
                    <b-form-input v-model="password" :placeholder="'Password'" />
                    <b-form-input v-model="fax" :placeholder="'Fax'" />
                    <b-form-input v-model="address" :placeholder="'Address'" />
                    <b-form-input v-model="gender" :placeholder="'Gender'" />
                  </div>

                  <div class="zone-submit">
                    <b-button class="btn_submit" @click="submitUserInfo()"> Submit</b-button>
                  </div>

                  <div class="zone-return">
                    <b-button @click="returnToIndex()"> Return</b-button>
                  </div>

                </div>
              </div>
            </div>
          </b-col>
        </b-row>
      </b-col>

    </div>

  </div>
</template>

<script>

import { MakeToast } from '../../utils/toast_message';
import { postOneUser } from '../../api/user';

export default {
    name: 'UserCreate',

    data() {
        return {
            error: '',
            isSuccess: false,
            // id: this.$route.params.id,
            username: '',
            email: '',
            phone: '',
            name: '',
            password: '',
            fax: '',
            address: '',
            gender: '',
        };
    },

    created() {

    },

    methods: {

        validationData() {
            this.error = '';
            const arrFieldRequired = ['username', 'email', 'phone', 'name', 'password'];
            for (const f of arrFieldRequired) {
                if (!this[f]) {
                    this.error = f + ' can not be empty';
                }
            }
            if (!this.error && !this.validEmail(this.email)) {
                this.error = 'Email invalid!';
            }
            if (this.error !== '') {
                MakeToast({
                    variant: 'warning',
                    title: 'Warning',
                    content: this.error,
                });
            }
        },
        validEmail: function(email) {
            var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        },

        submitUserInfo() {
            this.validationData();

            const NEW_USER_DATA = {
                username: this.username,
                email: this.email,
                phone: this.phone,
                name: this.name,
                password: this.password,
                fax: this.fax,
                address: this.address,
                avatar: this.avatar,
                gender: this.gender,
            };
            postOneUser(NEW_USER_DATA)
                .then((response) => {
                    if (response.code === 200) {
                        MakeToast({
                            variant: 'success',
                            title: 'Successfull',
                            content: `Create User Successful!`,
                        });
                        this.isSuccess = true;
                        this.returnToIndex();
                    } else {
                        this.error = response.message;
                    }
                })
                .catch((error) => {
                    this.error = 'Error!';
                    MakeToast({
                        variant: 'warning',
                        title: 'Warning',
                        content: error.message,
                    });
                });
            this.isSuccess = 'no await';
        },

        returnToIndex() {
            this.$router.push('/user/index');
        },
    },

};
</script>

<style scoped>

#screen-title {
    position: flex;
    text-align: center;
    margin-top: 50px;
}

.main-page {
    width: 98%;
    margin: 0 auto;
}

.buttons-control {
    text-align: center;
    margin-top: 100px;
    margin-bottom: 20px;
    margin-right: 50px;
}

</style>

<style lang="scss" scoped>

.zone-create {
    min-width: 450px;
    max-width: 500px;
    margin: 0 auto;
    margin-top: 150px;

    .zone-input {
        input[type="text"] {
            margin-bottom: 20px;
            margin-top: 20px;
        }

        input {
            &:focus {
                border-color: #f98404;
            }
        }
    }

    .zone-return {
        margin-top: 20px;

        button {
            width: 100%;
            border: none;
            background-color: #E6A23C;

            &:focus {
                background-color: #f98404;
            }

            &:hover {
                opacity: 0.8;
            }
        }
    }

    .zone-submit {
        margin-top: 20px;

        button {
            width: 100%;
            border: none;
            background-color: #67C23A;

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
