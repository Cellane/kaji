<template>
  <tr>
    <th scope="row">{{ task.id }}</th>
    <td>{{ task.name }}</td>
    <td>{{ task.completed_today_by }}</td>
  </tr>
</template>

<script>
export default {
  props: {
    task: {
      required: true
    }
  }
}
</script>
