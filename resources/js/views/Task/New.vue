<template>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">New task</div>

        <div class="card-body">
          <form @submit.prevent="newHandler">
            <div class="form-group row">
              <label for="name" class="col-md-2 col-form-label text-md-right">
                Task Name
              </label>

              <div class="col-md-10">
                <input
                  id="name"
                  type="text"
                  class="form-control"
                  name="name"
                  required
                  autofocus
                  v-model="name"
                />
              </div>
            </div>

            <div class="form-group row">
              <label for="" class="col-md-2 col-form-label text-md-right">
                Schedule
              </label>

              <div class="col-md-10 col-form-label">
                <div class="row">
                  <span
                    class="col-md-3"
                    v-for="(day, i) in weekdays"
                    :key="day.value"
                  >
                    <input
                      type="checkbox"
                      :id="`weekday-${i}`"
                      v-model="weekdays[i].checked"
                    />
                    <label :for="`weekday-${i}`">
                      {{ day.name }}
                    </label>
                  </span>
                </div>
              </div>
            </div>

            <div class="form-group row mb-0">
              <div class="col-md-8 offset-md-2">
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
                  {{ inProgress ? "Creating…" : "Create" }}
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
export default {
  data() {
    return {
      name: "",
      weekdays: [
        { value: 1 << 0, checked: true, name: "Sunday" },
        { value: 1 << 1, checked: true, name: "Monday" },
        { value: 1 << 2, checked: true, name: "Tuesday" },
        { value: 1 << 3, checked: true, name: "Wednesday" },
        { value: 1 << 4, checked: true, name: "Thursday" },
        { value: 1 << 5, checked: true, name: "Friday" },
        { value: 1 << 6, checked: true, name: "Saturday" }
      ],
      inProgress: false
    }
  },

  computed: {
    form() {
      return {
        name: this.name,
        schedule: this.weekdays
          .filter(day => day.checked)
          .map(day => day.value)
          .reduce((acc, curr) => acc + curr, 0)
      }
    }
  },

  methods: {
    resetForm() {
      this.name = ""
      this.weekdays.forEach(weekday => (weekday.checked = true))
    },

    newHandler() {
      this.inProgress = true

      axios
        .post("/api/task", this.form)
        .then(response => {
          this.$notify({
            type: "success",
            title: "Task created!"
          })
          this.resetForm()
        })
        .catch(error => {
          this.$notify({
            type: "error",
            title: "Could not create a task…",
            text: "Sorry for the trouble, but maybe try later again?"
          })
        })
        .finally(() => {
          this.inProgress = false
        })
    }
  }
}
</script>
