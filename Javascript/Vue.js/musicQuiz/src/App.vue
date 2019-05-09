<template>
  <div id="app"> <Header :numCorrect="numCorrect" :numTotal="numTotal" :numWrong="numWrong"  />
    <Timer 
    :timePoints ="timePoints"
    :index ="index"
    :numCorrect="numCorrect"
    :showScores="showScores"
    v-on:childToParent="updateTimeScore"
    />
   
    
    <ScoreBoard
      v-if="showScores"
      :numCorrect="numCorrect"
      :savedName="savedName"
      :timePoints="timePoints"
    />
    <b-container class="bv-example-row">
      <b-row>
        <b-col sm="6" offset="3">
          <QuestionBox
            v-if="questions.length && !showScores"
            :currentQuestion="questions[index]"
            :next="next"
            :incrementCheckAndGetName="incrementCheckAndGetName"
            :submitAnswer ="submitAnswer"
          />
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
import Header from "./components/Header.vue";
import QuestionBox from "./components/QuestionBox.vue";
import ScoreBoard from "./components/ScoreBoard.vue";
import Timer from "./components/Timer.vue";

export default {
  name: "app",
  components: {
    Header,
    QuestionBox,
    ScoreBoard,
    Timer
  },
  data() {
    return {
      questions: [],
      index: 0,
      numCorrect: 0,
      numWrong: 0,
      numTotal: 0,
      showScores: false,
      savedName: "",
      scores: null,
      submitAnswer: false,
      timePoints: 0
    };
  },
  methods: {
    next() {
      this.index++
    },

    incrementCheckAndGetName(isCorrect) {
      if (isCorrect) {
        this.numCorrect++
      }
      else if(!isCorrect){
        this.numWrong++
      }
      this.submitAnswer = true
      this.numTotal++
      if (this.numTotal == 10) {
        let promptName = prompt("Enter your name:")
        this.savedName = promptName

        this.showScores = true
      }
    },
    updateTimeScore(value){
      this.timePoints = value
    }
  },
  mounted: function() {
    fetch("https://opentdb.com/api.php?amount=40&category=12&type=multiple", {
      method: "get"
    })
      .then(response => {
        return response.json();
      })
      .then(jsonData => {
        this.questions = jsonData.results;
      });
  }
};
</script>

<style>
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: whitesmoke;
  background-color:#2c3e50;
}
</style>
