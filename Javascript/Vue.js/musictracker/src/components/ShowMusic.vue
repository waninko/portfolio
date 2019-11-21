<template>
  <div>
    {{searchInput}}
    <br>
    <div id="trackSearch">
      {{msg}}<br>
      <input type="text" v-model="searchInput">
      <br>
    </div>


    <div id="countrySearch">
      <br>{{msg2}}<br>
      <input type="text" v-model="countryInput">
      <br><br>
      <button @click="getMusicInfo()">Search!</button>
      <br>
    </div>
    <tr class="resultTable" v-for="(result, index) in searchOutput" v-bind:key="index">
      <td v-if="searchInput === result.artistName">{{result.artistName}} - {{result.name}} #of Plays so far this month: {{result.listeners}}</td>
    </tr>
    <tr class="resultTable" v-for="(result, index) in countryOutput" v-bind:key="index">
      <td>
        Number {{index+1}}. is
        <b>{{result.name}}</b><br> and has
        <b>{{result.listeners | formatNumber}}</b> listeners!
      </td>
      <br>
    </tr>
  </div>
</template>

<script>
export default {
  name: "ShowMusic",
  data() {
    return {
      msg: "Search Artist names to see most played tracks!: ",
      msg2: "Country to see top artists in:",
      searchInput: "",
      searchOutput: [],
      countryInput: "",
      countryOutput: []
    };
  },
  created() {},
  filters: {
    formatNumber(value) {
      console.log("value filter: ", value);
      return value.toLocaleString();
    }
  },
  methods: {
    
    getMusicInfo() {
      const LastFM = require("last-fm");
      const lastfm = new LastFM("2966e89ae7f423c13dc2fd74303548b3");
      console.log("this i method: " + this.searchInput);
      this.searchOutput.length = 0;
      this.countryOutput.length = 0;

      if (!this.searchInput == "") {
        let capitalizedSearch = this.searchInput.charAt(0).toUpperCase() + this.searchInput.slice(1);
        this.searchInput = capitalizedSearch;
        console.log(capitalizedSearch);
        lastfm.trackSearch({ q: capitalizedSearch }, (err, data) => {
          if (!err) {
            console.log(...data.result);
            this.searchOutput.push(...data.result);
          } else {
            console.error(err);
          }
        });
      } else {
        console.log("Blank, checking countryBox.");
      }

      if (!this.countryInput == "") {
        lastfm.geoTopArtists({ country: this.countryInput }, (err, data) => {
          console.log("geo test: ", ...data.artist);
          this.countryOutput.push(...data.artist);
        });
      } else {
        console.log("No input in Countrybox.");
      }
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

td {
  padding: 5px;
  padding-left:50%;

}
#trackSearch, #countrySearch {
  padding: 10px;
}
.resultTable{
  padding-left: 150px;
}

</style>
