<template>
  <div>
    <app-header></app-header>
    <main class="py-4">
      <div class="container">
        <transition name="fade" mode="out-in">
          <router-view></router-view>
        </transition>
        <notifications position="bottom left"></notifications>
      </div>
    </main>
  </div>
</template>

<script>
import Header from "./components/Header"
export default {
  components: { "app-header": Header }
}
</script>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease-in-out;
}

.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>
