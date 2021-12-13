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
                      name="name"
                      :placeholder="'City name'"
                      @keyup.enter="submitCityInfo()"
                    />
                  </div>

                  <div class="zone-submit">
                    <b-button :class="is_ready" variant="success" @click="submitCityInfo()">
                      Change
                    </b-button>
                  </div>

                  <div class="zone-return">
                    <b-button variant="warning" @click="returnToIndex()"> Return</b-button>
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
import * as RequestApi from '../../api/request';
import { MakeToast } from '../../utils/toast_message';

const urlAPI = {
    urlCity: `/city`,
};

export default {
    name: 'EditCity',
    data() {
        return {
            id: this.$route.params.id,
            name: '',
            is_ready: '',
        };
    },

    created() {
        this.getSelectedCityInfo();
    },

    methods: {

        async getSelectedCityInfo() {
            var response = await RequestApi.getOne({
                url: `${urlAPI.urlCity}/${this.id}`,
            });
            this.name = response.data.name;
            this.is_ready = 'is_ready';
        },

        async submitCityInfo() {
            if (this.name === '') {
                MakeToast({
                    variant: 'warning',
                    title: 'Warning',
                    content: 'Name can not be empty !',
                });
            } else {
                await RequestApi.putOne({
                    url: `${urlAPI.urlCity}/${this.id}`,
                    name: this.name,
                })
                    .then((response) => {
                        if (response.code === 200) {
                            MakeToast({
                                variant: 'success',
                                title: 'Successful',
                                content: `Edit City Successful !`,
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
            this.$router.push('/city/index');
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
