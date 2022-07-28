<template>
  <div class="fullscreen bg-image text-white text-center q-pa-md flex flex-center">
    <div>
      <div class="big-text">Error 404</div>

      <div class="sub-text">Está página no existe</div>

      <q-btn
        class="q-mt-xl"
        color="white"
        text-color="primary"
        unelevated
        :to="{ name: 'DashboardMain' }"
        label="Regresar a main"
        no-caps
      />
    </div>
  </div>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
  name: 'ErrorNotFound',
})
</script>

<style lang="scss" scoped>
.big-text {
  font-size: 9vh;
}

.sub-text {
  font-size: 5vh;
  opacity: 0.4;
}
</style>
