<template>
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Login</div>

        <div class="card-body">
          <form @submit.prevent="loginHandler">
            <div class="form-group row">
              <label for="email" class="col-md-4 col-form-label text-md-right">
                E-Mail Address
              </label>

              <div class="col-md-6">
                <input
                  id="email"
                  type="email"
                  class="form-control"
                  name="email"
                  required
                  autocomplete="email"
                  autofocus
                  v-model="form.email"
                />
              </div>
            </div>

            <div class="form-group row">
              <label
                for="password"
                class="col-md-4 col-form-label text-md-right"
              >
                Password
              </label>

              <div class="col-md-6">
                <input
                  id="password"
                  type="password"
                  class="form-control"
                  :class="error ? 'is-invalid' : ''"
                  name="password"
                  required
                  autocomplete="current-password"
                  v-model="form.password"
                />

                <span class="invalid-feedback" role="alert" v-if="error">
                  <strong>E-mail address or password is invalid.</strong>
                </span>
              </div>
            </div>

            <div class="form-group row mb-0">
              <div class="col-md-8 offset-md-4">
                <button
                  type="submit"
                  class="btn btn-primary"
                  :disabled="inProgress"
                >
                  <span
                    class="spinner-border spinner-border-sm"
                    role="status"
                    aria-hidden="true"
                    v-if="inProgress"
                  ></span>
                  {{ inProgress ? "Logging in…" : "Login" }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapState } from "vuex"

export default {
  data() {
    return {
      form: {
        email: "",
        password: ""
      }
    }
  },

  computed: {
    ...mapState("login", ["inProgress", "error"])
  },

  methods: {
    resetForm() {
      this.form.email = ""
      this.form.password = ""
    },

    loginHandler() {
      this.login(this.form)
        .then(() => {
          this.resetForm()
          this.$router.push("/")
        })
        .catch(error => console.error(error))
    },

    ...mapActions("login", ["login"])
  }
}
</script>
