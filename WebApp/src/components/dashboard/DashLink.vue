<template>
  <div v-if="!link.sublinks">
    <q-item v-ripple clickable :class="levelClass" :to="link.route">
      <q-item-section avatar>
        <q-icon :name="link.icon" />
      </q-item-section>
      <q-item-section> {{ link.title }}</q-item-section>
    </q-item>
  </div>
  <div v-else>
    <q-expansion-item :icon="link.icon" :label="link.title" expand-icon-class="text-primary">
      <DashLinks v-for="(sublink, index) in link.sublinks" :key="index" :link="sublink" :level="level + 1" />
    </q-expansion-item>
    <q-separator />
  </div>
</template>

<script lang="ts">
import { defineComponent, PropType } from 'vue'
import { Link } from 'src/assets/models/link'

export default defineComponent({
  name: 'DashLinks',
  props: {
    link: {
      type: Object as PropType<Link>,
      required: true,
    },
    level: {
      type: Number,
      default: 0,
    },
  },
  computed: {
    levelClass: function () {
      // calcula la clase a utilizar dado el nivel
      return 'level-' + this.level
    },
  },
})
</script>
