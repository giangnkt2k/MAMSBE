<template>
  <div>
    <div class="main-page">
      <b-col>
        <b-row>
          <b-col md="12">
            <div class="zone-create">
              <div class="card">
                <div class="card-body">
                  <div class="zone-input">
                    <b-row class="mt-2">
                      <b-col sm="3">
                        <label for="textarea-default">{{ $t('roles.role_name') }}</label>
                      </b-col>
                      <b-col sm="9">
                        <b-form-input
                          v-model="name"
                          name="name"
                          :placeholder="'Name'"
                        />
                      </b-col>
                    </b-row>

                    <b-row class="mt-2">
                      <b-col sm="3">
                        <label for="textarea-default">{{ $t('roles.display_name') }}</label>
                      </b-col>
                      <b-col sm="9">
                        <b-form-input
                          v-model="displayName"
                          name="displayName"
                          :placeholder="'Display name'"
                        />
                      </b-col>
                    </b-row>

                    <b-row class="mt-2">
                      <b-col sm="3">
                        <label>{{ $t('roles.description') }}</label>
                      </b-col>
                      <b-col sm="9">
                        <b-form-textarea
                          v-model="description"
                          name="description"
                          placeholder="Description"
                        />
                      </b-col>
                    </b-row>
                  </div>
                </div>
              </div>
            </div>
            <div class="zone-create">
              <div class="card">
                <div class="card-body">
                  <div class="zone-input">
                    <b-table-simple
                      :bordered="true"
                      :outlined="false"
                      :fixed="false"
                      class="table-route"
                    >
                      <b-thead>
                        <b-tr>
                          <b-th class="w-25">{{ $t('roles.name') }}</b-th>
                          <b-th class="w-50">{{ $t('roles.description') }}</b-th>
                          <b-th class="w-25">{{ $t('roles.choose') }}</b-th>
                        </b-tr>
                      </b-thead>
                      <b-tbody>
                        <b-tr
                          v-for="(permission, index) in permissionList"
                          :key="index"
                        >
                          <b-td>
                            {{ permission.name }}
                          </b-td>
                          <b-td>
                            {{ permission.description }}
                          </b-td>
                          <b-td>
                            <b-form-checkbox-group v-model="selected">
                              <b-form-checkbox
                                v-for="(item, index2) in permission.items"
                                :key="index2"
                                :value="item.id"
                                style="display: flex;"
                              >
                                {{ item.display_name }}
                              </b-form-checkbox>
                            </b-form-checkbox-group>
                          </b-td>
                        </b-tr>
                      </b-tbody>
                    </b-table-simple>
                  </div>
                  <div class="zone-submit">
                    <b-button class="btn_submit" @click="submitRolesInfo()">
                      {{ $t("setting.save") }}
                    </b-button>
                  </div>

                  <div class="zone-return">
                    <b-button variant="warning" @click="returnToIndex()">
                      {{ $t("setting.back") }}
                    </b-button>
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
    urlRoles: `/roles`,
    urlPermissions: `/permissions`,
};

export default {
    nane: 'CreateNewRoles',

    data() {
        return {
            name: '',
            displayName: '',
            description: '',
            permissionID: null,
            permissionList: [],
            demo: [],
            selected: [],
        };
    },

    created() {
        this.getListAllPermission();
    },

    methods: {
        async submitRolesInfo() {
            if (this.name === '') {
                MakeToast({
                    variant: 'warning',
                    title: 'Warning',
                    content: 'Name can not be empty !',
                });
            } else {
                await RequestApi.postOne({ url: urlAPI.urlRoles,
                    name: this.name,
                    display_name: this.displayName,
                    description: this.description,
                    permission_ids: this.selected })
                    .then((response) => {
                        if (response.code === 200) {
                            MakeToast({
                                variant: 'success',
                                title: 'Successfull',
                                content: 'Create New Setting Successfull !',
                            });
                            this.$router.push('/roles/index');
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
        async getListAllPermission() {
            await RequestApi.getAll({ url: urlAPI.urlPermissions })
                .then((response) => {
                    this.permissionList = response.data;
                    for (let i = 0; i < this.permissionList.length; i++) {
                        for (let j = 0; j < this.permissionList[i].items.length; j++) {
                            if (this.permissionList[i].items[j] === null) {
                                this.permissionList[i].items.splice(j, 1);
                            }
                        }
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
            this.$router.push('/roles/index');
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
  min-width: auto;
  max-width: auto;
  margin: 0 auto;
  margin-top: 20px;

  .zone-input {
    input[type="text"]:first-child {
      margin-bottom: 20px;
    }

    input {
      margin-bottom: 20px;
      &:focus {
        border-color: #f98404;
      }
    }

    textarea{
        margin-bottom: 20px;
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
      background-color: #67c23a;

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
