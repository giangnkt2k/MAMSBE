<template>

  <b-container fluid class="main-page">

    <div class="card d-flex flex-row bg-light justify-content-between">
      <h2 class="py-2 mt-2 text-center text-uppercase">List image</h2>
      <div class="p-3">
        <b-button v-b-modal.bv-modal-add variant="dark" @click="showModalAdd()">
          <b-icon icon="plus" font-scale="1" />
          Add Image
        </b-button>
      </div>
      <!-- Modal Add -->
      <b-modal id="bv-modal-add" size="lg" hide-footer hide-header>
        <header class="d-flex justify-content-between style-modal">
          <h4>Model Add Image</h4>
          <button class="delete-modal" @click="hideModalAdd()">
            <b-icon icon="x" font-scale="2" />
          </button>
          <input id="photo" ref="file" accept="image/png, image/jpeg, image/gif" type="file" class="d-none" @change="uploadPhoto($event)">
        </header>
        <div>
          <div class="d-block d-flex flex-column text-center p-4 style-modal">
            <b-form class="py-3">
              <!-- 1 -->
              <b-form-group id="input-group-1" label="Title Name Image" label-for="input-1" label-cols-lg="2">
                <div class="d-flex align-items-center flex-column mt-3 pr-5">
                  <b-form-input
                    id="input-1"
                    v-model="form.title"
                    class="w-50"
                    placeholder="Enter Title Image Name..."
                    :state="Error.title"
                  />
                  <b-form-invalid-feedback :state="Error.title">
                    Your Title Image Name not null!
                  </b-form-invalid-feedback>
                </div>

              </b-form-group>
            </b-form>
            <div>
              <button class="border border-white upload" @click="selectFile()">
                <b-img-lazy fluid thumbnail class="img-product" :src="image ? image : noimg" alt="Image" />
              </button>
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-around mx-4">
          <b-button class="mt-3 w-25" variant="outline-success" @click="onSubmitModelAdd()">Yes</b-button>
          <b-button class="mt-3 w-25" variant="outline-warning" @click="hideModalAdd()">Close</b-button>
        </div>
      </b-modal>
    </div>
    <b-row class="list-item bg-white">
      <b-col v-for="(item, index) in listImage" :key="index" xl="4" lg="4" md="4" sm="12">

        <div class="polaroid">
          <b-img-lazy fluid thumbnail class="img-product" :src="item.url ? url + item.url : noimg" alt="Image 1" />
          <div class="product-info">
            <h4 class="text-center py-1"> {{ item.title }}</h4>
          </div>
          <div class="d-flex justify-content-center b-delete">
            <b-button id="show-btn" variant="danger" class="delete" @click="showModal(item)">
              <b-icon icon="x-square" font-scale="2" />
            </b-button>
          </div>
          <!-- Modal delete -->
          <b-modal id="bv-modal-delete" hide-footer hide-header>
            <header class="d-flex justify-content-between style-modal">
              <h4>Model Delete Image</h4>
              <button class="delete-modal" @click="hideModal()">
                <b-icon icon="x" font-scale="2" />
              </button>
            </header>
            <div>
              <div class="d-block text-center p-4 style-modal">
                <h4>Do you want to delete a photo named:  {{ listInfo.title }} -ID: {{ listInfo.id }}</h4>
              </div>
            </div>
            <div class="d-flex justify-content-around">
              <b-button class="mt-3 w-25" variant="outline-success" @click="onSubmitModel(listInfo.id)">Yes</b-button>
              <b-button class="mt-3 w-25" variant="outline-warning" @click="hideModal()">Close</b-button>
            </div>
          </b-modal>
        </div>

      </b-col>

    </b-row>
    <b-overlay :show="showLoading" no-wrap rounded="lg" />
  </b-container>
</template>

<script>
import * as ImageApi from '../../api/upload';
import { MakeToast } from '../../utils/toast_message';
const urlAPI = {
    urlImage: `/image`,
};
export default {

    name: 'ImageIndex',
    data() {
        return {
            listImage: [],
            noimg: 'https://www.whiteknightconsulting.com.ng/wp-content/themes/wkc/images/no-image-found-360x250.png',
            url: process.env.MIX_STORE_IMAGE_URL,
            isOpen: false,
            form: {
                title: '',
                url: '',
            },
            showLoading: false,
            Error: {
                title: undefined,
                url: undefined,
            },
            listInfo: {},
            image: '',

        };
    },
    computed: {

    },

    created() {
        this.getAllImage();
    },
    methods: {
        async getAllImage() {
            this.openLoading();
            await ImageApi.getAll({ url: urlAPI.urlImage })
                .then((response) => {
                    this.closeLoading();
                    if (response.code === 200) {
                        MakeToast({
                            variant: 'success',
                            title: 'Successfull',
                            content: `Get All Image Successfull !`,
                        });
                        this.listImage = response.data.result;
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
        onSubmitModel(id) {
            if (id) {
                ImageApi.deleteImage({ url: `${urlAPI.urlImage}/${id}` })
                    .then((response) => {
                        if (response.code === 200) {
                            MakeToast({
                                variant: 'success',
                                title: 'Success',
                                content: `Delete Image Successful !`,
                            });
                            this.hideModal();
                            this.getAllImage();
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
        },
        onSubmitModelAdd() {
            if (this.form.title && this.image){
                this.hideModalAdd();
                this.getAllImage();
            } else {
                MakeToast({
                    variant: 'warning',
                    title: 'Warning',
                    content: 'Please input title and image',
                });
            }
        },
        showModal(info) {
            this.$bvModal.show('bv-modal-delete', info);
            this.listInfo = info;
        },
        hideModal() {
            this.$bvModal.hide('bv-modal-delete');
        },
        showModalAdd() {
            this.$bvModal.show('bv-modal-add');
            this.image = null;
            this.form.title = null;
        },
        hideModalAdd() {
            this.$bvModal.hide('bv-modal-add');
        },
        openLoading() {
            this.showLoading = true;
        },
        closeLoading() {
            this.showLoading = false;
        },
        uploadPhoto(e) {
            if (document.getElementById('photo').files[0] !== undefined){
                if (this.form.title){
                    const files = e.target.files[0];

                    const formData = new FormData();
                    formData.append('file', files);
                    formData.append('title', this.form.title);
                    ImageApi.uploadImage(formData)
                        .then((response) => {
                            if (response.code === 200) {
                                MakeToast({
                                    variant: 'success',
                                    title: 'Successfull',
                                    content: `Update Image Successfull !`,
                                });
                                this.image = this.url + response.data.url;
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
                    this.Error.title = false;
                }
            }
        },
        selectFile() {
            const fileInputElement = this.$refs.file;
            fileInputElement.click();
        },
    },

};
</script>

<style scoped>
 .list-item{
     padding: 26px 20px 10px 16px;;
 }
 .main-page {
     overflow-y: auto;
 }
 div.polaroid {
  width: 100%;
  background-color: white;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  margin-bottom: 25px;
  position: relative;
 }
 div.polaroid:hover {
      cursor: pointer;
      box-shadow: 2px 2px 25px 3px #ececec;
      transition: all 0.4s ease;
    }
 .thumbnail{
    object-fit: fill;
 }
 .img-product{
   display: block;
   margin-left: auto;
   margin-right: auto;
   max-height: 500px;
   height: max-content;
 }
 .b-delete {
   position: absolute;
   top: 1px;
   right: 1px;
 }
 .delete {
    height: 35px;
    width: 35px;
    padding: 1%;
 }
 .delete-modal{
   border: none;
   background-color: white;
 }
 .style-modal{
   border-bottom: 1px solid #dee2e6;
 }
 .upload:hover {
  background-color: darkgrey;
 }
 .spinner-border {
    width: 5rem !important;
    height: 5rem !important;
}

</style>
<style >
@media (min-width: 768px) {

 }
</style>

