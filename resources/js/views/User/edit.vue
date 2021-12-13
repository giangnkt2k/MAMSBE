<template>
  <div>
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
                    <b-button @click="submitUserInfo()"> Change </b-button>
                  </div>

                  <div class="zone-return">
                    <b-button @click="returnToIndex()"> Return </b-button>
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
import { getOneUser, putOneUser } from '../../api/user';

export default {
    name: 'EditUser',

    data() {
        return {
            id: this.$route.params.id,
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
        this.getSelectedUserInfo();
    },

    methods: {

        async getSelectedUserInfo() {
            var response = await getOneUser(this.id);
            this.username = response.data.username;
            this.email = response.data.email;
            this.phone = response.data.phone;
            this.name = response.data.name;
            this.password = response.data.password;
            this.fax = response.data.fax;
            this.address = response.data.address;
            this.gender = response.data.gender;
        },

        validationData() {
            if (!this.username) {
                MakeToast({
                    variant: 'warning',
                    title: 'Warning',
                    content: 'Username can not be empty !',
                });
            } else if (!this.email) {
                MakeToast({
                    variant: 'warning',
                    title: 'Warning',
                    content: 'Email can not be empty !',
                });
            } else if (!this.phone) {
                MakeToast({
                    variant: 'warning',
                    title: 'Warning',
                    content: 'Phone can not be empty !',
                });
            } else if (!this.name) {
                MakeToast({
                    variant: 'warning',
                    title: 'Warning',
                    content: 'Name can not be empty !',
                });
            } else if (!this.password) {
                MakeToast({
                    variant: 'warning',
                    title: 'Warning',
                    content: 'Password can not be empty !',
                });
            } else if (!this.fax) {
                MakeToast({
                    variant: 'warning',
                    title: 'Warning',
                    content: 'Fax can not be empty !',
                });
            } else if (!this.address) {
                MakeToast({
                    variant: 'warning',
                    title: 'Warning',
                    content: 'Address can not be empty !',
                });
            } else if (!this.gender) {
                MakeToast({
                    variant: 'warning',
                    title: 'Warning',
                    content: 'Gender can not be empty !',
                });
            }
        },

        submitUserInfo() {
            const EDIT_USER_DATA = {
                username: this.username,
                email: this.email,
                phone: this.phone,
                name: this.name,
                fax: this.fax,
                address: this.address,
                avatar: this.avatar,
                gender: this.gender,
            };

            this.validationData();

            putOneUser(this.id, EDIT_USER_DATA)
                .then((response) => {
                    if (response.code === 200) {
                        MakeToast({
                            variant: 'success',
                            title: 'Successfull',
                            content: `Edit User Successfull !`,
                        });
                        this.returnToIndex();
                    }
                })
                .catch((error) => {
                    MakeToast({
                        variant: 'warning',
                        title: 'Warning',
                        content: error.message,
                    });
                });
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
