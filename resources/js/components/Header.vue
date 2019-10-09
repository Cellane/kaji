<template>
  <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
      <router-link :to="{ name: 'home' }" class="navbar-brand">
        Kaji
      </router-link>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <router-link :to="{ name: 'home' }" class="nav-link">
              Home
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="{ name: 'task-new' }" class="nav-link">
              New Task
            </router-link>
          </li>
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
          <!-- Authentication Links -->
          <template v-if="!loggedIn">
            <li class="nav-item">
              <router-link :to="{ name: 'user-login' }" class="nav-link">
                Login
              </router-link>
            </li>
            <li class="nav-item">
              <router-link :to="{ name: 'user-register' }" class="nav-link">
                Register
              </router-link>
            </li>
          </template>
          <template v-else>
            <span class="navbar-text">
              {{ user.name }}
            </span>
            <li class="nav-item">
              <a class="nav-link" href="#" @click.prevent="logoutHandler">
                Logout
              </a>
            </li>
          </template>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import { mapActions, mapGetters, mapState } from "vuex"

export default {
  computed: {
    ...mapGetters("login", ["loggedIn"]),
    ...mapState("login", ["user"])
  },

  methods: {
    logoutHandler() {
      this.logout().then(() => this.$router.push("/user/login"))
    },

    ...mapActions("login", ["logout"])
  },

  watch: {
    // prettier-ignore
    "$route"() {
      $(".navbar-collapse").collapse("hide")
    }
  }
}
</script>
