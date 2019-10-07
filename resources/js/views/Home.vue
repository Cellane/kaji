<template>
  <div>
    <div class="row justify-content-center mb-3">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Incomplete tasks</div>
          <div class="card-body">
            <TaskList
              :tasks="notCompleted"
              :loading="loading"
              :error="error"
            ></TaskList>
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Finished tasks</div>
          <div class="card-body">
            <TaskList
              :tasks="completed"
              :loading="loading"
              :error="error"
              lastColumnTitle="Completed by"
            ></TaskList>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions } from "vuex"
import TaskList from "../components/TaskList"

export default {
  computed: {
    ...mapState("todayTasks", ["notCompleted", "completed", "loading", "error"])
  },

  methods: {
    ...mapActions("todayTasks", ["fetch"])
  },

  mounted() {
    this.fetch()
  },

  components: {
    TaskList
  }
}
</script>
