<template>
  <div>

    <div class="main-page">
      <b-overlay :show="showLoading" rounded="sm">
        <b-row>
          <b-col xl="4" lg="6" md="12" sm="12">
            <div id="column-1">
              <b-card
                :title="Info.username"
                :img-src="avatar ? avatar : noimg"
                img-alt="Image"
                img-top
                tag="article"
                style="max-width: 100%, height:auto"
                class="mb-2"
              >
                <div class="container">
                  <div class="row my-2">
                    <label class="col-sm-4">Email:</label>
                    <div class="col-sm-8 text-center p-0"> {{ Info.email }}</div>
                  </div>
                  <div class="row my-2">
                    <label class="col-sm-4">Phone:</label>
                    <div class="col-sm-8 text-center p-0"> {{ Info.phone }}</div>
                  </div>
                  <div class="row my-2">
                    <label class="col-sm-4">Address:</label>
                    <div class="col-sm-8 text-center p-0"> {{ Info.address }}</div>
                  </div>
                  <div class="row my-2">
                    <label class="col-sm-4">Gender:</label>
                    <div v-if="Info.gender" class="col-sm-8 text-center p-0"> {{ Info.gender == 1 ? "Male" : "Female" }}</div>
                    <div v-else class="col-sm-8 text-center p-0"> --- </div>
                  </div>
                  <div class="row my-2">
                    <label class="col-sm-4">Fax:</label>
                    <div class="col-sm-8 text-center p-0"> {{ Info.fax }}</div>
                  </div>
                  <div class="row my-2">
                    <label class="col-sm-4">Status:</label>
                    <div class="col-sm-8 text-center p-0 text-success"> {{ Info.status ? Info.status : "---" }}</div>
                  </div>
                  <div class="d-flex justify-content-center cammera">
                    <b-button v-b-modal.upload type="button" class="b-cammera" @click="showModalEdit(Info.images)">
                      <b-icon icon="camera" font-scale="2" />
                    </b-button>
                  </div>
                  <!-- Modal Edit -->
                  <b-modal id="bv-modal-edit" size="lg" hide-footer hide-header>
                    <header class="d-flex justify-content-between style-modal">
                      <h4>Model Edit Image</h4>
                      <button class="delete-modal" @click="hideModalEdit()">
                        <b-icon icon="x" font-scale="2" />
                      </button>
                    </header>
                    <div>
                      <div class="d-block d-flex flex-column text-center p-4 style-modal">
                        <b-form class="py-3">
                          <!-- 1 -->
                          <b-form-group id="input-group-1" label="Title Name Image" label-for="input-1" label-cols-lg="2">
                            <div class="d-flex align-items-center flex-column mt-3 pr-5">
                              <b-form-input
                                id="input-1"
                                v-model="formImage.title"
                                class="w-50"
                                placeholder="Enter Title Image Name..."
                                :state="Error.title"
                                @change="handleChangeFormAvatar($event)"
                              />
                              <b-form-invalid-feedback :state="Error.title">
                                Your Title Image Name not null!
                              </b-form-invalid-feedback>
                            </div>

                          </b-form-group>
                        </b-form>
                        <div>
                          <button class="border border-white upload" @click="selectFile()">
                            <b-img-lazy fluid thumbnail class="img-product" :src="formImage.url ? formImage.url : noimg" alt="Image" />
                          </button>
                          <input id="avatar" ref="file" accept="image/png, image/jpeg, image/gif" type="file" class="d-none" @change="uploadAvt($event)">
                        </div>
                      </div>
                    </div>
                    <div class="d-flex justify-content-around">
                      <b-button class="mt-3 w-25" variant="outline-success" @click="onSubmitModal($event)">Yes</b-button>
                      <b-button class="mt-3 w-25" variant="outline-warning" @click="hideModalEdit()">Close</b-button>
                    </div>
                  </b-modal>
                </div>
              </b-card>
            </div>
          </b-col>
          <!-- Form Update -->
          <b-col xl="8" lg="6" md="12" sm="12">
            <div class="p-3 mb-2 bg-danger text-white">
              <h2 class="text-uppercase font-weight-bold ">update profile</h2>
            </div>
            <b-form v-if="show" class="py-3" @submit="onSubmit" @reset="onReset">
              <div id="column-2">
                <!-- 1 -->
                <b-form-group id="input-group-1" label="Your UserName:" label-for="input-1">
                  <b-form-input
                    id="input-1"
                    v-model="form.username"
                    :state="Error.username"
                    placeholder="Enter UserName"
                    @change="handleChangeForm($event,'username')"
                  />
                  <b-form-invalid-feedback :state="Error.username">
                    Your User Name not null
                  </b-form-invalid-feedback>
                </b-form-group>
                <!-- 2 -->
                <b-form-group
                  id="input-group-2"
                  label="Email:"
                  label-for="input-2"
                >
                  <b-form-input
                    id="input-2"
                    v-model="form.email"
                    :state="Error.email"
                    placeholder="Enter Email"
                    @change="handleChangeForm($event,'email')"
                  />
                  <b-form-invalid-feedback :state="Error.email">
                    Email not null and must in email format
                  </b-form-invalid-feedback>
                </b-form-group>
                <!-- 3 -->
                <b-form-group id="input-group-3" label="Your Phone:" label-for="input-3">
                  <b-form-input
                    id="input-3"
                    v-model="form.phone"
                    placeholder="Enter Phone"
                    :state="Error.phone"
                    type="number"
                    @change="handleChangeForm($event,'phone','number')"
                  />
                  <b-form-invalid-feedback :state="Error.phone">
                    Your phone must be a number and VN format
                  </b-form-invalid-feedback>
                </b-form-group>
                <!-- 4 -->
                <b-form-group id="input-group-4" label="Your Name:" label-for="input-4">
                  <b-form-input
                    id="input-4"
                    v-model="form.name"
                    placeholder="Enter name"
                    :state="Error.name"
                    @change="handleChangeForm($event,'name')"
                  />
                  <b-form-invalid-feedback :state="Error.name">
                    Your name not null !
                  </b-form-invalid-feedback>
                </b-form-group>
                <!-- 5 -->
                <b-form-group id="input-group-5" label="Your PassWord:" label-for="input5">
                  <b-form-input
                    id="input-5"
                    v-model="form.password"
                    placeholder="Enter Your PassWord"
                    :state="Error.password"
                    type="number"
                    @change="handleChangeForm($event,'password','number')"
                  />
                  <b-form-invalid-feedback :state="Error.password">
                    Your Password must be 5-12 characters long
                  </b-form-invalid-feedback>
                </b-form-group>
                <!-- 6 -->
                <b-form-group id="input-group-6" label="Your Fax:" label-for="input-6">
                  <b-form-input
                    id="input-6"
                    v-model="form.fax"
                    placeholder="Enter Your Fax"
                    :state="Error.fax"
                    type="number"
                    @change="handleChangeForm($event,'fax','number')"
                  />
                  <b-form-invalid-feedback :state="Error.fax">
                    Your Fax must be number of characters
                  </b-form-invalid-feedback>
                </b-form-group>
                <!-- 7 -->
                <b-form-group id="input-group-7" label="Your Address:" label-for="input-7">
                  <b-form-input
                    id="input-7"
                    v-model="form.address"
                    placeholder="Enter Your Address"
                    @change="handleChangeForm($event,'address')"
                  />
                  <b-form-invalid-feedback :state="Error.address">
                    Your Address not null
                  </b-form-invalid-feedback>
                </b-form-group>
                <div class="d-flex justify-content-center">
                  <b-button type="submit" variant="primary">Submit</b-button>
                </div>
              </div>
            </b-form>
          </b-col>
        </b-row>
      </b-overlay>
    </div>
  </div>
</template>

<script>

import { MakeToast } from '../../utils/toast_message';
import * as ImageApi from '../../api/upload';
import { getProfileInfo, editProfile } from '../../api/profile';

export default {

    name: 'Profile',
    data() {
        return {
            form: {
                username: '',
                email: '',
                phone: '',
                name: '',
                password: '',
                fax: '',
                address: '',
                image_id: '',

            },

            formImage: {
                title: '',
                url: '',
                id: '',
            },
            avatar: '',
            showLoading: false,
            Info: {},

            show: true,
            noimg: 'https://www.whiteknightconsulting.com.ng/wp-content/themes/wkc/images/no-image-found-360x250.png',
            Error: {
                username: undefined,
                email: undefined,
                phone: undefined,
                name: undefined,
                password: undefined,
                fax: undefined,
                address: undefined,
                title: undefined,
            },

        };
    },
    computed: {

    },

    created() {
        this.getProfileInfo();
    },
    methods: {
        async getProfileInfo() {
            this.openLoading();
            await getProfileInfo()
                .then((response) => {
                    this.closeLoading();
                    this.Info = response.data;
                    if (response.data.images){
                        this.avatar = process.env.MIX_STORE_IMAGE_URL + this.Info.images.url;
                        console.log('Data return', response.data);
                        this.formImage = response.data.images;
                        this.formImage.url = process.env.MIX_STORE_IMAGE_URL + response.data.images.url;
                        console.log('Form Image', this.formImage);
                    }

                    this.form = JSON.parse(JSON.stringify(response.data));
                })
                .catch((error) => {
                    this.closeLoading();
                    MakeToast({
                        variant: 'warning',
                        title: 'Warning',
                        content: error.message,
                    });
                });
        },

        renderNumber() {
            const numberRandom = Math.floor(Math.random() * 100) + 1;

            return numberRandom;
        },
        checkEmail(email) {
            const checkEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return checkEmail.test(email);
        },
        checkValidate() {
            if (!this.form.username) {
                this.Error.username = false;
                return false;
            } else if (!this.form.email) {
                this.Error.email = false;
                return false;
            } else if (!this.form.phone){
                this.Error.phone = false;
                return false;
            } else if (!this.form.name) {
                this.Error.name = false;
                return false;
            } else if (!this.form.password) {
                this.Error.password = false;
                return false;
            } else if (!this.form.fax){
                this.Error.fax = false;
                return false;
            } else if (!this.form.address) {
                this.Error.address = false;
                return false;
            } else {
                return true;
            }
        },
        selectFile() {
            const fileInputElement = this.$refs.file;
            fileInputElement.click();
        },
        openLoading() {
            this.showLoading = true;
        },
        closeLoading() {
            this.showLoading = false;
        },
        showModalEdit(Info) {
            this.checkValidate();
            if (this.checkValidate() === true){
                this.$bvModal.show('bv-modal-edit');
            }
        },
        hideModalEdit() {
            this.$bvModal.hide('bv-modal-edit');
            this.Error.title = null;
        },
        handleChangeForm(e, field, type) {
            let newValue = e;

            if (type === 'number') {
                newValue = newValue.replace(/\D/g, '');
            }
            switch (field) {
                case 'username':
                    if (newValue.length > 0) {
                        this.Error.username = true;
                    } else {
                        this.Error.username = false;
                    }
                    break;
                case 'email':
                    if (newValue.length === 0 || !this.checkEmail(newValue)) {
                        this.Error.email = false;
                    } else {
                        this.Error.email = true;
                    }
                    break;
                case 'phone':
                    if (newValue.length > 6 && newValue.length < 12) {
                        this.Error.phone = true;
                    } else {
                        this.Error.phone = false;
                    }
                    break;
                case 'name':
                    if (newValue.length === 0) {
                        this.Error.name = false;
                    } else {
                        this.Error.name = true;
                    }
                    break;
                case 'password':
                    if (newValue.length > 4 && newValue.length < 13) {
                        this.Error.password = true;
                    } else {
                        this.Error.password = false;
                    }
                    break;
                case 'fax':
                    if (newValue.length === 0) {
                        this.Error.fax = false;
                    } else {
                        this.Error.fax = true;
                    }
                    break;
                case 'address':
                    if (newValue.length === 0) {
                        this.Error.address = false;
                    } else {
                        this.Error.address = true;
                    }
                    break;
                default:
                    break;
            }
        },
        handleChangeFormAvatar(e){
            const newValue = e;
            if (newValue.length > 0) {
                this.Error.title = true;
            } else {
                this.Error.title = false;
            }
        },
        checkFormModal() {
            if (this.formImage.title) {
                return true;
            } else {
                this.Error.title = false;
                return false;
            }
        },

        onSubmit(event) {
            if (this.checkValidate() === true){
                editProfile(this.form)
                    .then((response) => {
                        if (response.code === 200) {
                            MakeToast({
                                variant: 'success',
                                title: 'Successfull',
                                content: `Edit User Successfull !`,
                            });
                            this.Error.password = undefined;

                            this.getProfileInfo();
                        }
                    })
                    .catch((error) => {
                        MakeToast({
                            variant: 'warning',
                            title: 'Warning',
                            content: error.message,
                        });
                    });
            } else {
                event.preventDefault();
                event.stopPropagation();
            }
        },
        onSubmitModal(event) {
            this.checkFormModal();
            if (this.checkValidate() === true && this.checkFormModal() === true){
                editProfile(this.form)
                    .then((response) => {
                        if (response.code === 200) {
                            MakeToast({
                                variant: 'success',
                                title: 'Successfull',
                                content: `Edit User Successfull !`,
                            });
                            this.hideModalEdit();
                            this.Error.password = undefined;
                            this.getProfileInfo();
                        }
                    });
            } else {
                event.preventDefault();
                event.stopPropagation();
            }
        },
        onReset(event) {
            event.preventDefault();
            // Reset our form values

            this.form.username = '';
            this.form.email = '';
            this.form.phone = '';
            this.form.name = '';
            this.form.password = '';
            this.form.fax = '';
            this.form.address = '';
            // Trick to reset/clear native browser form validation state
            this.show = false;
            this.$nextTick(() => {
                this.show = true;
            });
            this.Error = undefined;
        },

        uploadAvt(e) {
            if (document.getElementById('avatar').files[0] !== undefined){
                if (this.formImage.title) {
                    console.log('1');
                    const files = e.target.files[0];
                    const formData = new FormData();
                    formData.append('title', this.formImage.title);
                    formData.append('file', files);
                    if (this.avatar) {
                        console.log('2');
                        const idImage = this.Info.images.id;
                        ImageApi.editImage(idImage, formData)
                            .then((response) => {
                                if (response.code === 200) {
                                    MakeToast({
                                        variant: 'success',
                                        title: 'Successfull',
                                        content: `Update Image Successfull !`,
                                    });

                                    this.formImage.url = process.env.MIX_STORE_IMAGE_URL + response.data.url;
                                }
                            })
                            .catch((error) => {
                                MakeToast({
                                    variant: 'warning',
                                    title: 'Warning',
                                    content: error.message,
                                });
                            });
                    } else {
                        console.log('3');
                        ImageApi.uploadImage(formData)
                            .then((response) => {
                                if (response.code === 200) {
                                    MakeToast({
                                        variant: 'success',
                                        title: 'Successfull',
                                        content: `Update Image Successfull !`,
                                    });
                                    this.formImage.url = process.env.MIX_STORE_IMAGE_URL + response.data.url;

                                    this.form.image_id = response.data.id;
                                }
                            })
                            .catch((error) => {
                                MakeToast({
                                    variant: 'warning',
                                    title: 'Warning',
                                    content: error.message,
                                });
                            });
                    }
                } else {
                    this.Error.title = false;
                }
            }
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
    width: 80%;
    margin: 0 auto;
  }

  .buttons-control {
    text-align: center;
    margin-top: 100px;
    margin-bottom: 20px;
    margin-right: 50px;
  }
  .cammera {
    position: absolute;
    top: 10px;
    right: 10px;
  }
  .b-cammera {
    color: #111;
    background: #fff;
    border-radius: 50%;
    height: 56px;
    line-height: 56px;
    width: 60px;
  }
  input[type="file"] {
  border: 1px solid yellow;
}

input[type="file"].slotted {
  border: 1px solid rebeccapurple;
}
 .delete-modal{
   border: none;
   background-color: white;
 }
</style>
<style>
@media (min-width: 768px) {
  .card {
    max-width: 100% !important;
    height: auto;
  }
 }
</style>

