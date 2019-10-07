<template>
  <p v-if="loading">Loading…</p>
  <p v-else-if="error">Could not fetch tasks. Please try again later.</p>
  <table v-else-if="tasks.length > 0" class="table table-striped">
    <thead>
      <th scope="col">#</th>
      <th scope="col" class="col-xs-6 col-lg-8">Name</th>
      <th scope="col" class="col-xs-4 col-lg-2">{{ lastColumnTitle }}</th>
    </thead>
    <tbody>
      <template v-for="task in tasks">
        <IncompleteTask
          :task="task"
          :key="task.id"
          v-if="!task.completed_today"
        ></IncompleteTask>
        <CompleteTask
          :task="task"
          :key="task.id"
          v-if="task.completed_today"
        ></CompleteTask>
      </template>
    </tbody>
  </table>
  <p v-else>There are no tasks.</p>
</template>

<script>
import CompleteTask from "./CompleteTask"
import IncompleteTask from "./IncompleteTask"

export default {
  props: {
    tasks: {
      required: true,
      default: () => []
    },
    loading: {
      required: true,
      default: false
    },
    error: {
      required: true,
      default: false
    },
    lastColumnTitle: {
      required: false,
      default: "Actions"
    }
  },

  components: {
    CompleteTask,
    IncompleteTask
  }
}
</script>
