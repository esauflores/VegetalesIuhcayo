<template>
  <q-page class="text-center q-pa-lg">
    <span class="text-h5"> Bienvenido usuario - {{ login.userData.nombre_usuario }} </span>
  </q-page>
</template>
<script lang="ts">
import { useDConfigStore } from 'src/stores/dashboard/config'
import { useLoginStore } from 'src/stores/dashboard/login'
import { defineComponent } from 'vue'

export default defineComponent({
  data() {
    return {
      login: useLoginStore(),
      dash: useDConfigStore(),
    }
  },

  created() {
    this.dash.page.title = 'Bienvenido'
  },
  updated() {
    this.dash.page.title = 'Bienvenido'
  },
})
</script>
