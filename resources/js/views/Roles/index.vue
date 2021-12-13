<template>
  <div>
    <div class="card">
      <div class="card-body" style="margin: 0 auto">
        <b-button class="btn_create" variant="info" @click="createNewSetting">
          {{ $t('roles.create') }}
        </b-button>
      </div>
    </div>
    <div class="card">
      <div class="card-body" style="min-height: 675px">
        <div class="title-content">{{ $t('roles.title') }}</div>
        <b-table-simple :bordered="true" :outlined="false" :fixed="false" class="table-route">
          <b-thead>
            <b-tr>
              <b-th>ID</b-th>
              <b-th>{{ $t('roles.name') }}</b-th>
              <b-th>{{ $t('roles.display_name') }}</b-th>
              <b-th>{{ $t('roles.description') }}</b-th>
              <b-th>{{ $t('roles.action') }}</b-th>
            </b-tr>
          </b-thead>

          <b-tbody>
            <b-tr v-for="(roles, index) in RolesList" :key="index">
              <b-td>{{ roles.id }}</b-td>
              <b-td>{{ roles.name }}</b-td>
              <b-td>{{ roles.display_name }}</b-td>
              <b-td>{{ roles.description }} </b-td>
              <b-td>
                <b-button variant="info" @click="goToDetailScreen(roles.id)">{{ $t('roles.detail') }}</b-button>
                <b-button variant="warning" @click="goToEditScreen(roles.id)">{{ $t('roles.edit') }}</b-button>
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
    urlRoles: `/roles`,
};

export default {
    name: 'RolesIndex',

    data() {
        return {
            id: this.$route.params.id,
            RolesList: [],
            Pagination: {
                current_page: 1,
                per_page: 10,
                total_records: 100,
            },
        };
    },
    created() {
        this.getListAllRoles();
    },

    methods: {
        async getListAllRoles() {
            await RequestApi.getAll({ url: urlAPI.urlRoles })
                .then((response) => {
                    this.RolesList = response.data;
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
            this.getListAllRoles();
        },
        createNewSetting() {
            this.$router.push('/roles/create');
        },

        goToDetailScreen(id) {
            this.$router.push(
                {
                    path: `/roles/detail/${id}`,
                },
                (onAbort) => {}
            );
        },

        goToEditScreen(id) {
            this.$router.push(
                {
                    path: `/roles/edit/${id}`,
                },
                (onAbort) => {});
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

.title-content{
  margin:20px 0;
  font-weight: bold;
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
