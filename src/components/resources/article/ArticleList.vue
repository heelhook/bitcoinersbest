<template>
  <!-- <div>
    <ArticleItem
      v-for="article in articles"
      :key="article.id"
      :article="article"
    />
    <Trigger @triggerIntersected="loadMore"/>
  </div> -->
<div id="ArticleList">
  <div class="article-module d-flex br-4 mb-30 fade-in" v-for="article in articles" :key="article.id">
    <div class="flex-grow-1 align-self-center">
        <img :src="article.image" class="card-img" alt="...">
        <h6 class="text-uppercase c-gray-1 medium mt-25 mb-15">{{article.created_by}}</h6>
        <router-link :to="'/'+article.id+'/'+article.title"><h5 class="medium mb-15 c-white">{{article.title}}</h5></router-link>
        <h5 v-if="article.description.length < 140" class="regular c-gray-1">{{article.description}}</h5>
        <h5 v-else class="regular c-gray-1">{{ article.description.substring(0,140) + "..." }}</h5>
    </div>
    <div class="align-self-top pl-20">
        <div class="votes text-center">
          <p class="c-white">{{article.statusType.id}}</p>
          <b-button v-if="article.statusType.id == 55" class="vote btn btn-transparent bg-brand icon-wrap" @click="upVote(article.id, 1)">
            <svg class="active push-button" width="12" height="42" viewBox="0 0 9 28" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M3.99984 0L-0.00015655 17.1C-0.100157 17.3 0.199843 17.5 0.399843 17.4L2.39984 16.2C2.89984 15.9 3.49984 16.2 3.49984 16.8L3.89984 27.4C3.89984 27.5 3.99984 27.5 3.99984 27.4L8.09984 10.2C8.19984 10 7.89984 9.8 7.69984 9.9L5.69984 11.1C5.19984 11.4 4.59984 11.1 4.59984 10.5L3.99984 0C3.99984 0 4.09984 0 3.99984 0Z" fill="#6F7C91"/>
            </svg>
          </b-button>
          <b-button v-else="article.statusType.id == 50" class="vote btn btn-transparent bg-brand icon-wrap" v-b-modal.invoice-modal>
            <svg id="ten-x" class="push-button" width="34" height="42" viewBox="0 0 22 28" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M10.7 0.4L11.2 10.9C11.2 11.5 11.9 11.8 12.3 11.5L14.3 10.3C14.5 10.2 14.7 10.4 14.7 10.6L10.6 27.8C10.6 27.9 10.5 27.8 10.5 27.8L10.1 17.2C10.1 16.6 9.4 16.3 9 16.6L7 17.8C6.8 17.9 6.6 17.7 6.6 17.5L10.7 0.4C10.7 0.3 10.6 0.3 10.7 0.4ZM2.4 0L0 10.4C0 10.5 0.1 10.6 0.2 10.6L1.4 9.9C1.7 9.7 2.1 9.9 2.1 10.3L2.4 16.7H2.5L4.8 6.2C4.8 6.1 4.7 6 4.6 6L3.4 6.8C3.1 7 2.8 6.8 2.7 6.4L2.4 0ZM19.3 0L16.9 10.4C16.9 10.5 17 10.6 17.1 10.6L18.3 9.9C18.6 9.7 19 9.9 19 10.3L19.3 16.7H19.4L21.8 6.2C21.8 6.1 21.7 6 21.6 6L20.4 6.7C20.1 6.9 19.7 6.7 19.7 6.3L19.3 0Z" fill="#6F7C91"/>
            </svg>
          </b-button>
            <div class="vote-total" id="vote-total">
              <h6 class="medium mt-10 c-white">{{article.vote_count}}</h6>
              <h6 class="vote-increment bg-brand c-black br-4" id="vote-increment">10</h6>
            </div>
        </div>
    </div>
  </div>

  <div class="d-flex justify-content-center mb-3" v-if="isLoading">
    <b-spinner variant="primary" label="Loading..."></b-spinner>
  </div>

</div>
</template>

<script>
// todo:
// implement voting system
// bug:
// infinite scroll repeatedly calls the last segment of resource elements

// import ArticleItem from "./ArticleItem.vue";
import axios from "axios";

export default {
	name: "ArticlesList",
  data() {
		return {
			endOfTheScreen: false,
			isLoading: false,
			pageNo: 1,
			limit: 10,
			articles: [],
			showbtn: false,
			autoLoading: true,
      user_id: 69,
		}
	},
	watch: {
		endOfTheScreen(endOfTheScreen) {
			if (endOfTheScreen === true && this.autoLoading) {
				this.pageNo += 1;
				this.loadArticles(this.pageNo, this.limit);
				console.log("hit end of scroll");
			}
		}
	},
	created() {
    // this.getVotes();

		window.onscroll = () => {
			this.endOfTheScreen = this.scrollCheck();
		};
		this.loadArticles();
	},
	methods: {
		scrollCheck() {
			if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
				return true;
			}
		},
		loadArticles(page = this.pageNo, limit = this.limit) {
			this.isLoading = true;
			const _self = this;
			axios.get("http://bitcoinersbest.local:9111/v1/items?access-token=admin-bandit-authkey&V1ResItemSearch[res_type_id]=30&page=" + page + "&limit=" + limit)
      .then(response => {

      const resourceList = response.data.map(c => {
          return {
            id: c.id,
            votes:
              // todo:
              // determine if logged_in, then get user_id -- hardcoded atm
               axios.get("http://bitcoinersbest.local:9111/v1/items/"+c.id+"/votes/69?access-token=admin-bandit-authkey")
              .then(res => {
                  console.log("success");
                  statusType: res.statusType
              })
          };
        })

        for (let i in response.data) {
          _self.articles.push(response.data[i]);
        }
        _self.isLoading = true;
        _self.showbtn = false;

			})
      .finally(() => _self.isLoading = false);
		},



    upVote(id, count) {
      var self = this;
      let config = {
        headers : {
          'Content-Type': 'application/x-www-form-urlencoded'
        }
      }

      var formData = new FormData();
      formData.append("res_item_id", id);
      formData.append("count", count);
      formData.append("user_id", 69);  // hardcoded user_id, update when twitter auth
      console.log(formData);
      console.log(id);

      axios.post('http://bitcoinersbest.local:9111/v1/res-votes?access-token=admin-bandit-authkey', formData, config)
      .then((response) => {
        this.incrementVote();
      })
      .catch(error => {
        console.log(error.response);
      });
    },
    incrementVote() {
      console.log("vote count: " +this.vote_count);
      this.resource.vote_count++;
      console.log("vote count: " +this.vote_count);
    },





	}
}
</script>
