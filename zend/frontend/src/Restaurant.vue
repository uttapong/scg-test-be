<template>
  <a-layout id="components-layout-demo-responsive">
    <a-layout>
      <H1>Restaurant Finder</H1>
      <a-layout-sider
        breakpoint="lg"
        collapsedWidth="0"
        @collapse="onCollapse"
        @breakpoint="onBreakpoint"
      >
        <div class="logo"/>
        <a-menu theme="dark" mode="inline" :defaultSelectedKeys="['4']">
          <a-menu-item key="1">
            <a-icon type="user"/>
            <span class="nav-text">nav 1</span>
          </a-menu-item>
          <a-menu-item key="2">
            <a-icon type="video-camera"/>
            <span class="nav-text">nav 2</span>
          </a-menu-item>
          <a-menu-item key="3">
            <a-icon type="upload"/>
            <span class="nav-text">nav 3</span>
          </a-menu-item>
          <a-menu-item key="4">
            <a-icon type="user"/>
            <span class="nav-text">nav 4</span>
          </a-menu-item>
        </a-menu>
      </a-layout-sider>
      <a-layout-content>
        <div>
          <div class="search-input">
            <a-input-search
              placeholder="Search Restaurant"
              style="width: 400px"
              size="large"
              @search="onSearch"
            />
          </div>
          <div class="result-list">
            <a-list
              itemLayout="vertical"
              size="large"
              :dataSource="searchResult"
              :loading="loading"
            >
              <a-list-item slot="renderItem" key="item.title">
                <div slot="actions">
                  <span>View More</span>
                </div>
                <img
                  slot="extra"
                  width="272"
                  v-if="item.photos"
                  alt="logo"
                  :src="'https://maps.googleapis.com/maps/api/place/photo?key=AIzaSyCQWpAtVowR7C1BRlml8_LeRMWSpKUZ1HQ&maxwidth=300&maxheight=200&photoreference='+item.photos[0].photo_reference"
                >

                <a-list-item-meta :description="item.description">
                  <div slot="title">
                    <h2>{{item.name}}</h2>
                    <a-rate :value="item.rating" disabled allowHalf/>
                    <p>{{item.vicinity}}</p>
                  </div>
                  <a-avatar slot="avatar" :src="item.icon"/>
                </a-list-item-meta>
                {{item.content}}
              </a-list-item>
            </a-list>
          </div>
        </div>
      </a-layout-content>
      <a-layout-footer style="textAlign: center">Uttapong Ruangrit</a-layout-footer>
    </a-layout>
  </a-layout>
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
  methods: {
    onSearch(value) {
      // console.log(value);
      this.searchRestaurant(value);
    },
    searchRestaurant(keyword) {
      this.loading = true;
      // http://localhost/public/search?location=bangsue

      // http://localhost:8081/localhost/public/search?location=
      axios
        .get("http://localhost/public/search", {
          params: {
            location: keyword
          }
        })
        .then(response => {
          this.searchResult = response.data;
          // console.log(response.data);
        })
        .then(() => {
          // always executed
          this.loading = false;
        });
    }
  }
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
