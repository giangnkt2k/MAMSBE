<template>
  <div>
    <div class="card">
      <div class="card-body" style="margin: 0 auto;">
        <b-button class="btn_create" variant="info" @click="createNewCity"> Create New City </b-button>
      </div>
    </div>

    <div class="card">
      <div class="card-body" style="min-height: 675px;">
        <b-table-simple
          :bordered="true"
          :outlined="false"
          :fixed="false"
          class="table-route"
        >
          <b-thead>
            <b-tr>
              <b-th>ID</b-th>

              <b-th>Name</b-th>

              <b-th>Detail</b-th>

              <b-th>Edit</b-th>

              <b-th>Delete</b-th>
            </b-tr>
          </b-thead>

          <b-tbody>
            <b-tr v-for="(city, index) in CityList" :key="index">
              <b-td>{{ city.id }}</b-td>

              <b-td>{{ city.name }}</b-td>

              <b-td>
                <b-button variant="info" @click="goToDetailScreen(city.id)"> Detail </b-button>
              </b-td>

              <b-td>
                <b-button variant="warning" @click="goToEditScreen(city.id)"> Edit </b-button>
              </b-td>

              <b-td>
                <b-button variant="danger" @click="confirmationForm(city.id)"> Delete </b-button>
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
    urlCity: `/city`,
};

export default {

    name: 'CityIndex',

    data() {
        return {
            id: this.$route.params.id,
            CityList: [],
            Pagination: {
                current_page: 1,
                per_page: 10,
                total_records: 100,
            },
        };
    },

    created() {
        this.getListAllCity();
    },

    methods: {
        async getListAllCity() {
            await RequestApi.getAll({ url: urlAPI.urlCity })
                .then((response) => {
                    this.CityList = response.data.result;
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
            this.getListAllCity();
        },

        createNewCity() {
            this.$router.push('/city/create');
        },

        goToDetailScreen(id) {
            this.$router.push(
                {
                    path: `/city/detail/${id}`,
                }, (onAbort) => {}
            );
        },

        goToEditScreen(id) {
            this.$router.push(
                {
                    path: `/city/edit/${id}`,
                }, (onAbort) => {});
        },

        confirmationForm(id) {
            this.$bvModal.msgBoxConfirm((`Are you sure to delete this city ?`), {
                okVariant: 'danger',
                okTitle: 'Yes',
                cancelVariant: 'primary',
                cancelTitle: 'No',
                centered: true,
            })
                .then(value => {
                    this.confirmStatus = value;
                    if (this.confirmStatus === true) {
                        RequestApi.deleteOne({ url: `${urlAPI.urlCity}/${id}` })
                            .then(() => {
                                MakeToast({
                                    variant: 'success',
                                    title: 'Success',
                                    content: `Delete City Successful !`,
                                });
                                this.refreshAfterChanged();
                            });
                    }
                });
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

th {
    text-align: center;
    vertical-align: middle;
    background: rgba(5, 44, 80, 0.99);
    color: #FFFFFF;
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
