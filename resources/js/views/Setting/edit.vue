<template>
  <div>
    <div class="main-page">
      <b-col>
        <b-row>
          <b-col md="6" offset-md="3">
            <div class="zone-create">
              <div class="card">
                <div class="card-body">

                  <div class="zone-input">
                    <b-form-input
                      v-model="name"
                      :disabled="disabled"
                      name="name"
                      :placeholder="'Setting name'"
                    />
                    <b-form-input
                      v-model="key"
                      name="key"
                      :placeholder="'Key'"
                    />
                    <b-form-input
                      v-model="value"
                      name="value"
                      :placeholder="'Value'"
                    />
                    <b-form-select v-model="type" name="type" class="mb-3">
                      <b-form-select-option :value="null" disabled>Type</b-form-select-option>
                      <b-form-select-option value="String">String</b-form-select-option>
                      <b-form-select-option value="Number">Number</b-form-select-option>
                      <b-form-select-option value="Default">Default</b-form-select-option>
                    </b-form-select>
                  </div>
                  <div class="zone-submit">
                    <b-button :class="is_ready" variant="success" @click="submitSettingInfo()">
                      {{ $t('setting.save') }}
                    </b-button>
                  </div>
                  <div class="zone-return">
                    <b-button variant="warning" @click="returnToIndex()"> {{ $t('setting.cancel') }}</b-button>
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
import * as RequestApi from '../../api/request';
const urlAPI = {
    urlSetting: `/setting`,
};

export default {
    name: 'EditSetting',
    data() {
        return {
            id: this.$route.params.id,
            name: '',
            key: '',
            value: '',
            type: '',
            is_ready: '',
            state: 'disabled',
        };
    },
    computed: {
        disabled() {
            return this.state === 'disabled';
        },
    },

    created() {
        this.getSelectedSettingInfo();
    },
    methods: {
        async getSelectedSettingInfo() {
            var response = await RequestApi.getOne({
                url: `${urlAPI.urlSetting}/${this.id}`,
            });
            this.name = response.data.label;
            this.key = response.data.key;
            this.value = response.data.value;
            this.type = response.data.type;
            this.is_ready = 'is_ready';
        },

        async submitSettingInfo() {
            if (this.name === '') {
                MakeToast({
                    variant: 'warning',
                    title: 'Warning',
                    content: 'Name can not be empty !',
                });
            } else {
                await RequestApi.putOne({
                    url: `${urlAPI.urlSetting}/${this.id}`,
                    label: this.name,
                    key: this.key,
                    value: this.value,
                    type: this.type,
                })
                    .then((response) => {
                        if (response.code === 200) {
                            MakeToast({
                                variant: 'success',
                                title: 'Successful',
                                content: `Edit setting Successful !`,
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
            }
        },

        returnToIndex() {
            this.$router.push('/setting/index');
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
        input[type="text"]:first-child {
          margin-bottom: 20px;
        }

        input {
          margin-bottom:20px ;
          &:focus {
            border-color: #f98404;
          }
        }
      }

      .zone-return {
        margin-top: 20px;

        button {
            color: #ffffff;
            width: 100%;
            border: none;

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
