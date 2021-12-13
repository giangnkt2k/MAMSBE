<template>
  <b-navbar toggleable="lg" type="dark">
    <b-navbar-brand @click.prevent.stop="$emit('toggle')">
      <i id="toggle-menu" class="icofont-navigation-menu" />
    </b-navbar-brand>
    <b-navbar-toggle target="nav-collapse">
      <template #default="{ expanded }">
        <b-icon v-if="expanded" icon="chevron-bar-up" />
        <b-icon v-else icon="chevron-bar-down" />
      </template>
    </b-navbar-toggle>
    <b-collapse id="nav-collapse" is-nav>
      <b-navbar-nav id="text-name">
        {{ $t(title) }}
      </b-navbar-nav>
      <b-navbar-nav class="ml-auto">
        <LangSelector class="m-2" />
        <b-dropdown
          id="dropdown-profile"
          text="Block Level Dropdown"
          block
          class="m-2"
          style="text-align: center;"
          right
        >
          <template #button-content>
            <span>{{ fullname }}</span>
          </template>
          <b-dropdown-item class="text" @click="doLogout()">
            {{ $t('navbar.logout') }}
          </b-dropdown-item>
          <b-dropdown-item class="text" @click="goProfile()">
            {{ $t('routes.profile') }}
          </b-dropdown-item>
        </b-dropdown>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>
</template>
<script>
import LangSelector from '../LangSelector/index';
export default {
    name: 'Navbar',
    components: {
        LangSelector,
    },
    computed: {
        fullname() {
            return this.$store.getters.name;
        },
        title() {
            return this.$route.meta.title;
        },
    },
    methods: {
        doLogout() {
            this.$store.dispatch('logout')
                .then(() => {
                    this.$router.push('/login');
                });
        },
        goProfile() {
            this.$router.push('/profile/index');
        },
    },
};
</script>

<style lang="scss" scoped>
    .navbar{
        background-color: #ffffff;
        border-bottom: 1px solid #dee4ec;
        width: 100%;
        top: 0;
        position: sticky;
        z-index: 999;
        padding: 0.2rem 1rem 0.2rem 1rem;
    }

    .navbar .nav-link{
        color: #5b6e88 !important;
    }

    .navbar a i{
        color: #5b6e88;
        font-size: 20px;
    }

    @media(max-width: 768px){
        .navbar-dark .navbar-toggler {
            border-color:transparent;
        }
    }

    .text{
        text-align: center;
    }

    #text-name {
        font-size: 21px;
    }

    .text a {
        color: black;
        text-decoration: none;
    }

    #selectStore {
        width: 200px;
    }

    #selectApp {
        width: 250px;
        margin-right: 10px;
    }

    .icon-user {
        margin-right: 5px;
    }

    .item-nav {
        margin-left: 10px;
        margin-right: 10px;
    }

    .display-full {
        display: flex;
    }

    i#toggle-menu {
        color: #000;
    }

    button.navbar-toggler {
        background: #052C50 99%;
    }

    button.navbar-toggler > svg {
        color: white;
    }

    button.navbar-toggler:focus {
        outline: none;
    }
</style>
