<template>
  <q-layout view="lHh Lpr lFf">
    <DashHeader />

    <!--Sidenav-->
    <q-drawer
      id="sidenav"
      :width="240"
      class="text-black"
      v-model="dash.sidenavState"
      side="left"
      elevated
      content-class="column justify-between"
      show-if-above
    >
      <div class="absolute-top text-primary bg-primary" id="sidenavTop">
        <q-toolbar class="q-pr-none q-pl-none">
          <!--Sidenav en caso de tener tamaño lg o superior-->
          <q-toolbar-title class="flex flex-center q-pr-none q-pl-none">
            <q-img src="~assets/images/logoSoloImagen.png" fit="fill" height="35px" width="37px"></q-img>
            <span class="text-white font-sofia self-center q-pl-xs">Vegetales Iuhcayo</span>
          </q-toolbar-title>
        </q-toolbar>

        <!--Logo/Main-->
        <q-item
          class="level-0 flex flex-center q-pa-none q-pt-sm q-pb-sm"
          v-ripple
          clickable
          :to="{ name: 'DashboardMain' }"
        >
          <q-img src="~assets/images/logo.png" fit="contain" height="150px" />
        </q-item>
        <q-separator />
      </div>
      <!--Botones de navegación-->
      <q-scroll-area id="sidenavLinks">
        <q-list>
          <DashLink v-for="(link, index) in dash.accessLinks" :key="index" :link="link" />
        </q-list>
      </q-scroll-area>

      <div class="absolute-bottom text-primary" id="sidenavBottom">
        <!--Ajustes-->
        <q-separator />

        <q-item class="level-0" clickable v-ripple :to="{ name: 'DashboardSettings' }">
          <q-item-section avatar>
            <q-icon name="settings" />
          </q-item-section>
          <q-item-section>Ajustes</q-item-section>
        </q-item>
      </div>
    </q-drawer>

    <!--Contenido-->
    <q-page-container>
      <router-view />
    </q-page-container>

    <DashFooter />
  </q-layout>
</template>

<script lang="ts">
//librerías
import { useDConfigStore } from 'src/stores/dashboard/config'
import DashHeader from 'src/components/dashboard/DashHeader.vue'
import DashFooter from 'src/components/dashboard/DashFooter.vue'
import { defineComponent } from 'vue'
import DashLink from 'src/components/dashboard/DashLink.vue'

// app
export default defineComponent({
  data() {
    return {
      dash: useDConfigStore(),
    }
  },

  created() {
    if (!this.$q.screen.lt.md) {
      this.dash.sidenavState = true
    }
  },

  beforeCreate: () => {
    document.body.className = 'none'
  },
  beforeUpdate: () => {
    document.body.className = 'none'
  },

  components: { DashFooter, DashHeader, DashLink },
})
</script>

