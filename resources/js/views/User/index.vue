<template>
  <div id="veho_userindex">
    <div class="card">
      <div class="card-body" style="margin: 0 auto;">
        <b-button
          style="background: #f05454; border: none;"
          class="btn_create"
          @click="createNewCity"
        > Create User
        </b-button>
      </div>
    </div>

    <div class="card">
      <div class="card-body" style="min-height: 675px;">
        <b-table-simple :bordered="true" :outlined="false" :fixed="false" class="table-route">
          <b-thead>
            <b-tr>
              <b-th>ID</b-th>

              <b-th>Email</b-th>

              <b-th>Username</b-th>

              <b-th>Name</b-th>

              <b-th>Detail</b-th>

              <b-th>Edit</b-th>

              <b-th>Delete</b-th>
            </b-tr>
          </b-thead>

          <b-tbody>
            <b-tr v-for="(user, index) in UserList" :key="index">
              <b-td>{{ user.id }}</b-td>

              <b-td>{{ user.email }}</b-td>

              <b-td>{{ user.username }}</b-td>

              <b-td>{{ user.name }}</b-td>

              <b-td>
                <b-button class="btn_detail" variant="info" @click="goToDetailScreen(user.id)"> Detail
                </b-button>
              </b-td>

              <b-td>
                <b-button class="btn_edit" variant="warning" @click="goToEditScreen(user.id)"> Edit
                </b-button>
              </b-td>

              <b-td>
                <b-button class="btn_delete" variant="danger" @click="confirmationForm(user.id)">
                  Delete
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
import { getAllUser, deleteOneUser } from '../../api/user';
import { MakeToast } from '../../utils/toast_message';

export default {
    name: 'UserIndex',
    data() {
        return {
            UserList: [],
            Pagination: {
                current_page: 1,
                per_page: 0,
                total_records: 0,
            },
        };
    },
    created() {
        this.getListAllUser();
    },
    methods: {
        async getListAllUser() {
            const PAGINATION = {
                page: this.Pagination.current_page,
                per_page: this.Pagination.per_page,
            };

            await getAllUser(PAGINATION)
                .then((response) => {
                    this.UserList = response.data;
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
            this.getListAllUser();
        },

        createNewCity() {
            if (this.$router !== undefined) {
                this.$router.push('/user/create');
            }
        },

        goToDetailScreen(id) {
            this.$router.push({ path: `/user/detail/${id}` }, (onAbort) => {
            });
        },

        goToEditScreen(id) {
            this.$router.push({ path: `/user/edit/${id}` }, (onAbort) => {
            });
        },

        confirmationForm(id) {
            this.$bvModal.msgBoxConfirm((`Are you sure to delete this user ?`), {
                okVariant: 'danger',
                okTitle: 'Yes',
                cancelVariant: 'primary',
                cancelTitle: 'No',
                centered: true,
            })
                .then(value => {
                    this.confirmStatus = value;
                    if (this.confirmStatus === true) {
                        deleteOneUser(id)
                            .then(() => {
                                this.refreshAfterChanged();
                                MakeToast({
                                    variant: 'success',
                                    title: 'Success',
                                    content: `Delete User Successfull !`,
                                });
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
    background: #23272a;
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
