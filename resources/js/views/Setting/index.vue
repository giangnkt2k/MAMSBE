<template>
  <div>
    <div class="card">
      <div class="card-body" style="margin: 0 auto">
        <b-button class="btn_create" variant="info" @click="createNewSetting">
          {{ $t("setting.create") }}
        </b-button>
      </div>
    </div>
    <div class="card">
      <div class="card-body" style="min-height: 675px">
        <div class="title-content">{{ $t('setting.title') }}</div>
        <b-table-simple
          :bordered="true"
          :outlined="false"
          :fixed="false"
          class="table-route"
        >
          <b-thead>
            <b-tr>
              <b-th>ID</b-th>
              <b-th class="w-50">{{ $t("setting.name") }}</b-th>
              <b-th>{{ $t("setting.key") }}</b-th>
              <b-th>{{ $t('setting.action') }}</b-th>
            </b-tr>
          </b-thead>

          <b-tbody>
            <b-tr v-for="(setting, index) in SettingList" :key="index">
              <b-td>{{ setting.id }}</b-td>

              <b-td>{{ setting.label }}</b-td>

              <b-td>{{ setting.key }}</b-td>

              <b-td>
                <b-button variant="info" @click="goToDetailScreen(setting.id)">
                  {{ $t("setting.detail") }}
                </b-button>

                <b-button variant="warning" @click="goToEditScreen(setting.id)">
                  {{ $t("setting.edit") }}
                </b-button>

                <b-button variant="danger" @click="confirmationForm(setting.id)">
                  {{ $t("setting.delete") }}
                </b-button>
              </b-td>
            </b-tr>
          </b-tbody>
        </b-table-simple>
      </div>
    </div>
    <div class="card">
      <div class="card-body pagianation">
        <b-pagination
          v-model="Pagination.current_page"
          :per-page="Pagination.per_page"
          :total-rows="Pagination.total_records"
        />
      </div>
    </div>
  </div>
</template>

<script>
import * as RequestApi from '../../api/request';
import { MakeToast } from '../../utils/toast_message';

const urlAPI = {
    urlSetting: `/setting`,
};

export default {
    name: 'SettingIndex',

    data() {
        return {
            id: this.$route.params.id,
            SettingList: [],
            Pagination: {
                current_page: 1,
                per_page: 10,
                total_records: 100,
            },
        };
    },
    created() {
        this.getListAllSetting();
    },

    methods: {
        async getListAllSetting() {
            await RequestApi.getAll({ url: urlAPI.urlSetting })

                .then((response) => {
                    this.SettingList = response.data.result;
                })
                .catch((error) => {
                    MakeToast({
                        variant: 'warning',
                        title: 'Warning',
                        content: error.message,
                    });
                });
        },
        refreshAfterChanged() {
            this.getListAllSetting();
        },

        createNewSetting() {
            this.$router.push('/setting/create');
        },

        goToDetailScreen(id) {
            this.$router.push(
                {
                    path: `/setting/detail/${id}`,
                },
                (onAbort) => {}
            );
        },

        goToEditScreen(id) {
            this.$router.push(
                {
                    path: `/setting/edit/${id}`,
                },
                (onAbort) => {}
            );
        },
        confirmationForm(id) {
            this.$bvModal
                .msgBoxConfirm(`Are you sure to delete this setting ?`, {
                    okVariant: 'danger',
                    okTitle: 'Yes',
                    cancelVariant: 'primary',
                    cancelTitle: 'No',
                    centered: true,
                })
                .then((value) => {
                    this.confirmStatus = value;
                    if (this.confirmStatus === true) {
                        RequestApi.deleteOne({ url: `${urlAPI.urlSetting}/${id}` }).then(
                            () => {
                                MakeToast({
                                    variant: 'success',
                                    title: 'Success',
                                    content: `Delete Setting Successful !`,
                                });
                                this.refreshAfterChanged();
                            }
                        );
                    }
                });
        },
    },
};
</script>

<style>
#screen-title {
  position: flex;
  text-align: center;
  margin-top: 50px;
}

th {
  text-align: center;
  vertical-align: middle;
  background: #072b52;
  color: #ffffff;
}

.table-route {
  position: relative;
  top: 20%;
}

.table-route thead th {
  position: sticky;
  top: 0;
}

td {
  text-align: center;
  vertical-align: middle;
}

.title-content{
  margin:20px 0;
  font-weight: bold;
}

.display-table {
  height: 540px;
  width: 95%;
  margin: 0 auto;
  overflow: auto;
}

#btn-create-new-city {
  position: relative;
  top: 100px;
  margin-left: 50px;
}

.buttons-control {
  text-align: center;
  margin-top: 20px;
  margin-bottom: 20px;
}

.pagination {
  display: flex;
  justify-content: center;
  vertical-align: middle;
  margin-top: 20px;
  margin-bottom: 10px;
}
</style>
