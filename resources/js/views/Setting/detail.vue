<template>
  <div>
    <div class="display-table">
      <b-table-simple :bordered="true" :outlined="false" :fixed="false" class="table-route">
        <b-thead>
          <b-tr>
            <b-th>ID</b-th>
            <b-th>{{ $t("setting.name") }}</b-th>
            <b-th>{{ $t("setting.key") }}</b-th>
            <b-th>{{ $t("setting.type") }}</b-th>
            <b-th>{{ $t("setting.value") }}</b-th>
            <b-th>{{ $t("setting.return") }}</b-th>
          </b-tr>
        </b-thead>

        <b-tbody>
          <b-tr>
            <b-td>{{ setting_id }}</b-td>
            <b-td>{{ name }}</b-td>
            <b-td>{{ key }}</b-td>
            <b-td>{{ value }}</b-td>
            <b-td>{{ type }}</b-td>

            <b-td>
              <b-button variant="warning" @click="returnToIndex"> {{ $t('setting.back') }} </b-button>
            </b-td>
          </b-tr>
        </b-tbody>

      </b-table-simple>
    </div>

  </div>
</template>

<script>
import * as RequestApi from '../../api/request';

const urlAPI = {
    urlSetting: `/setting`,
};

export default {
    nane: 'DetailSetting',

    data() {
        return {
            id: this.$route.params.id,
            name: '',
            setting_id: '',
            key: '',
            value: '',
            type: '',
        };
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
            this.setting_id = response.data.id;
            this.key = response.data.key;
            this.value = response.data.value;
            this.type = response.data.type;
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
