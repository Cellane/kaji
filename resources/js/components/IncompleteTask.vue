<template>
  <tr>
    <th scope="row">{{ task.id }}</th>
    <td>{{ task.name }}</td>
    <td>
      <button
        class="btn btn-sm btn-primary"
        @click="completeHandler"
        :disabled="isCompleting(task.id)"
      >
        <span
          class="spinner-border spinner-border-sm"
          role="status"
          aria-hidden="true"
          v-if="isCompleting(task.id)"
        ></span>
        {{ isCompleting(task.id) ? "Completing…" : "Complete" }}
      </button>
    </td>
  </tr>
</template>

<script>
import { mapActions, mapGetters } from "vuex"
export default {
  props: {
    task: {
      required: true
    }
  },

  computed: {
    ...mapGetters("todayTasks", ["isCompleting"])
  },

  methods: {
    completeHandler() {
      this.complete(this.task.id)
    },
    ...mapActions("todayTasks", ["complete"])
  }
}
</script>
