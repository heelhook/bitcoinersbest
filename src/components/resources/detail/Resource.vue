<template>
  <div>
  <div class="c-white" v-if="loading">Loading...</div>
  <section class="detail mt-50 fade-in" v-cloak>
     <div class="section-header pt-20 pb-20 c-white text-center">
      <p>{{resource.id}}</p>
      <p>{{resource.title}}</p>

        <a target="_blank" class="c-white" :href="resource.url">Open Original Source</a>
        <p class="c-white">Created at {{ resource.created_at | moment.utc("dddd, MMMM Do YYYY, h:mm:ss a") }}</p>

        <!-- <a class="c-white mt-50 push-button" href=""><svg class="mr-15" width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M6.24792 15.869C13.7453 15.869 17.845 9.76428 17.845 4.47072C17.845 4.29733 17.8414 4.12472 17.8335 3.95288C18.6294 3.38741 19.3211 2.68173 19.8667 1.87842C19.1364 2.19748 18.3504 2.41227 17.526 2.50912C18.3675 2.01315 19.0136 1.22859 19.3183 0.29328C18.5308 0.752146 17.6587 1.08566 16.7301 1.26569C15.9863 0.486982 14.9274 0 13.7548 0C11.5039 0 9.67854 1.79407 9.67854 4.00561C9.67854 4.31998 9.7143 4.62576 9.78424 4.91904C6.39654 4.75151 3.39267 3.15739 1.38254 0.733405C1.03249 1.32544 0.830639 2.01315 0.830639 2.74695C0.830639 4.13682 1.55022 5.36385 2.64448 6.08163C1.97576 6.06132 1.34757 5.8809 0.798454 5.58059C0.797854 5.5974 0.797855 5.61379 0.797855 5.63175C0.797855 7.57187 2.20284 9.19177 4.06794 9.55886C3.72544 9.65063 3.36505 9.69984 2.99314 9.69984C2.7309 9.69984 2.47541 9.67447 2.22707 9.62759C2.746 11.2194 4.25072 12.3777 6.03476 12.4101C4.63971 13.4848 2.88229 14.1249 0.972286 14.1249C0.643687 14.1249 0.319062 14.1065 0 14.0694C1.80391 15.2058 3.94596 15.869 6.24813 15.869" fill="white"/>
        </svg>Share on Twitter</a> -->

     </div>
   </section>
 </div>
</template>

<script>

  // todo:
  // clean up API call
  // finish design & build out a clean view

  import axios from 'axios';
  import VueMoment from 'vue-moment';

  export default {
      name: "resource",
      data: function () {
        return {
          resource: {},
          loading: true,
        }
      },
      methods: {
        getResource() {
          var self = this;
          axios.get("http://bitcoinersbest.local:9111/v1/items/"+this.$route.params.id+"?access-token=admin-bandit-authkey")
          .then(function(response){
            self.resource = response.data;
          })
          .catch(error => {
            console.log(error);
          })
          .finally(() => this.loading = false);
        }
      },
      created() {
        this.getResource();
      }
  }
</script>

<style scoped>

[v-cloak] {
  display: none;
}

</style>
