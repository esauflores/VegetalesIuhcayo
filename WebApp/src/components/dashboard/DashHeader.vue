<template>
  <!--Header-->
  <q-header id="navbar" class="bg-image" height-hint="64" elevated>
    <!--Toolbar: prácticamente todo el sidenav-->
    <q-toolbar class="q-pr-lg q-pl-md">
      <!--Botón toggle para el sidenav, solo aparece debajo de cierto tamaño-->
      <q-btn v-if="$q.screen.lt.md" dense flat round icon="menu" @click="toggleSidenav()" />
      <q-toolbar-title>
        <!--Título de la página actual-->
        {{ dash.page.title }}
      </q-toolbar-title>

      <!--Foto usuario y dropdown funciones de usuario-->
      <q-btn round dense flat>
        <!--Foto del usuario-->
        <q-avatar>
          <img src="~assets/images/emptyUser.jpg" />
        </q-avatar>
        <!--menú dropdown-->

        <q-menu anchor="bottom left" self="top left" id="userDropdown">
          <q-list>
            <!--Botón mi cuenta-->
            <q-item clickable :to="{ name: 'DashboardLogin' }">
              <q-item-section avatar>
                <q-icon class="text-primary" name="person" />
              </q-item-section>
              <q-item-section>Mi cuenta</q-item-section>
            </q-item>

            <!--Botón cerrar sesión-->
            <q-item clickable :to="{ name: 'DashboardLogin' }">
              <q-item-section avatar>
                <q-icon class="text-red" name="close" />
              </q-item-section>
              <q-item-section>Cerrar sesión</q-item-section>
            </q-item>
          </q-list>
        </q-menu>
      </q-btn>
    </q-toolbar>

    <!--Barra de navegación de las páginas, en forma de tabs-->
    <q-tabs v-if="dash.page.tabs" align="left" class="bg-secondary text-primary" inline-label keep-alive="true">
      <div v-for="(tab, index) in dash.page.tabs" :key="index">
        <q-route-tab class="text-primary" :to="tab.route" :label="tab.title" :icon="tab.icon" />
      </div>
    </q-tabs>
  </q-header>
</template>

<script lang="ts">
import { useDConfigStore } from 'src/stores/dashboard/config'
import { defineComponent } from 'vue'

export default defineComponent({
  data() {
    return {
      dash: useDConfigStore(),
    }
  },
  methods: {
    toggleSidenav: function () {
      this.dash.sidenavState = !this.dash.sidenavState
    },
  },
})
</script>
