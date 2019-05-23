<template>
  <div>
    <b-form inline>
      <label class="sr-only" for="inline-form-input-name">Name</label>
      <b-input id="inline-form-input-name" class="mb-2 mr-sm-2 mb-sm-0" placeholder="Jane Doe"></b-input>

      <label class="sr-only" for="inline-form-input-username">Username</label>
      <b-input-group prepend="@" class="mb-2 mr-sm-2 mb-sm-0">
        <b-input id="inline-form-input-username" placeholder="Username"></b-input>
      </b-input-group>

      <b-form-checkbox class="mb-2 mr-sm-2 mb-sm-0">Remember me</b-form-checkbox>

      <b-button variant="primary">Save</b-button>
    </b-form>
  </div>
</template>
<script>
import axios from "axios";
export default {
  data: function() {
    return {
      searchResult: [],
      loading: false
    };
  },
  methods: {}
};
</script>

<style scoped>
#components-layout-demo-responsive .logo {
  height: 32px;
  background: rgba(255, 255, 255, 0.2);
  margin: 16px;
}
.search-input {
  display: flex;
  justify-content: center;
}

.result-list {
  padding: 0px 100px;
  margin-top: 40px;
  /* background-color: rgba(0, 0, 0, 0.65); */
}
</style>
