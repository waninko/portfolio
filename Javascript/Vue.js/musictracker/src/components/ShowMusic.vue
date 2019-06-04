<template>
  <div>
    {{searchInput}}
    <br>
    <div id="trackSearch">
      {{msg}}
      <input type="text" v-model="searchInput">
      <br>
    </div>

    <tr class="resultTable" v-for="(result, index) in searchOutput" v-bind:key="index">
      <td>{{result.artistName}} ~ {{result.name}}</td>
    </tr>

    <div id="countrySearch">
      <br>Country to see top artists in:
      <input type="text" v-model="countryInput">
      <br>
      <button @click="getMusicInfo()">Search!</button>
      <br>
    </div>
    <tr class="resultTable" v-for="(result, index) in countryOutput" v-bind:key="index">
      <td>
        Number {{index}}. is
        <b>{{result.name}}</b> and has
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
      msg: "Search track names/ Artist names: ",
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
      const lastfm = new LastFM("2966e89ae7f423c13dc2fd74303548b3", {
        userAgent: "MyApp/1.0.0 (http://example.com)"
      });
      console.log("this i method: " + this.searchInput);
      this.searchOutput.length = 0;
      this.countryOutput.length = 0;

      if (!this.searchInput == "") {
        lastfm.trackSearch({ q: this.searchInput }, (err, data) => {
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

</style>
