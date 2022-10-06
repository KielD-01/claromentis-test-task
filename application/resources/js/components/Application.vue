<template>
  <v-app>
    <v-main>
      <v-container>
        <v-row height="inherit">
          <v-col cols="2" style="height: -webkit-fill-available">
            <v-card class="mx-auto" height="100%"
                    width="100%">
              <v-navigation-drawer
                  width="inherit"
                  absolute
                  dark
                  src="/img/sidebar.jpg"
                  permanent
              >
                <v-list>
                  <v-list-item
                      v-for="([icon, text, route], i) in items"
                      :key="i"
                      link
                      @click="activeRoute(route) ? () => {} : $router.push({name: route})"
                      :class="{'route-active': activeRoute(route)}"
                  >
                    <v-list-item-icon>
                      <v-icon v-text="icon"></v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                      <v-list-item-title v-text="text"></v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                </v-list>
              </v-navigation-drawer>
            </v-card>
          </v-col>
          <v-col cols="10">
            <v-row>
              <v-col cols="12" class="d-flex justify-center">
                <h1>Claromentis CSV Uploader</h1>
              </v-col>
            </v-row>
            <router-view></router-view>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
export default {
  name: "Application",
  data: () => ({
    items: [
      ['mdi-home', 'Main', 'main'],
      ['mdi-magnify-scan', 'Analyzer', 'upload'],
    ],
  }),
  mounted() {
    console.log('mounted')
  },
  methods : {
    activeRoute(route) {
      return this.$route.name === route;
    },
  },
}
</script>

<style scoped>
.container {
  height: 100% !important;
  display: flex !important;
}


.route-active {
  background: rgba(200, 200, 200, 0.4);
}
</style>