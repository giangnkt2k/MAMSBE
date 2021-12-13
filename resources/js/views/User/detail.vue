<template>
  <div>
    <!-- Table City List -->
    <div class="display-table">
      <b-table-simple :bordered="true" :outlined="false" :fixed="false" class="table-route">

        <!-- Header -->
        <b-thead>
          <b-tr>
            <b-th>
              ID
            </b-th>

            <b-th>
              Email
            </b-th>

            <b-th>
              Username
            </b-th>

            <b-th>
              Phone
            </b-th>

            <b-th>
              Return to Index
            </b-th>

          </b-tr>
        </b-thead>

        <!-- Body -->
        <b-tbody>
          <b-tr>
            <b-td>
              {{ id }}
            </b-td>

            <b-td>
              {{ email }}
            </b-td>

            <b-td>
              {{ username }}
            </b-td>

            <b-td>
              {{ phone }}
            </b-td>

            <b-td>
              <b-button variant="warning" @click="returnToIndex"> Return </b-button>
            </b-td>
          </b-tr>
        </b-tbody>

      </b-table-simple>
    </div>

  </div>
</template>

<script>

// import { MakeToast } from '../../utils/toast_message';
import { getOneUser } from '../../api/user';

export default {
    nane: 'DetailUser',

    data() {
        return {
            id: this.$route.params.id,
            email: '',
            username: '',
            phone: '',
        };
    },

    created() {
        this.getSelectedUserInfo();
    },

    methods: {
        async getSelectedUserInfo() {
            var response = await getOneUser(this.id);
            this.id = response.data.id;
            this.email = response.data.email;
            this.username = response.data.username;
            this.phone = response.data.phone;
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
