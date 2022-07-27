<template>
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

    <!-- Content -->
      <div>
        <h1>This is master component</h1>
        <h3>Count : {{ counter }}</h3>
      </div>
      <hr><br>
      <div>
        <com-a></com-a>
      </div>
      <hr><br>
      <div>
        <com-b></com-b>
      </div>
      <hr><br>
      <div>
        <com-c></com-c>
      </div>
      <!-- Content -->
      <hr><br>
      <!-- Button -->
      <div>
          <button class="btn btn-success" @click="increaseCount()">Increase Count</button>
      </div>
      <!-- Button -->
    </div>
  </div>
</template>

<script>
import comA from "./comA.vue";
import comB from "./comB.vue";
import comC from "./comC.vue";
import { mapGetters } from 'vuex'

export default {
  components: {
    comA,
    comB,
    comC,
  },

  computed: {
      ...mapGetters({
          'counter': 'getCount',
      }),

    //   getCount() {
    //       return this.$store.getters.getCount;
    //   }
  },

  methods: {
      increaseCount() {
          // this.$store.commit('increaseStateCount', 1);
          this.$store.dispatch('increaseStateCountAction', 1);
      }
  }
};
</script>