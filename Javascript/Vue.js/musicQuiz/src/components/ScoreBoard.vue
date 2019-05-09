<template>
  <div class="scoreBoard">
<!-- 
    <div class="yourScoreBig" v-responsive="['hidden-all','md','lg']">
    <div class="savedName">{{savedName}}</div> 
    <div class="answerScore">AnswerScore:{{ numCorrect }}</div>
    <div class="addedScore">Calculated Score: {{numCorrect + timePoints}}</div>
    <button id="bigButton" class="btn btn-outline-light btn-lg" @click="addScore()">SUBMIT SCORE</button>
    </div> -->
    
       <div class="yourScoreSmall" v-responsive="['hidden-all','xs','sm']">
       <div class="savedNameSmall">{{savedName}}</div> 
       <div class="answerScoreSmall">AnswerScore:{{ numCorrect }}</div>
       <div class="addedScoreSmall">Calculated Score: {{numCorrect + timePoints}}</div>
     <button class="btn btn-outline-light btn-xs" @click="addScore()">SUBMIT SCORE</button>
    </div> 

    
    <hr>
    <table class="table table-striped table-dark table-bordered">
      <thead class="thead-dark">
        <tr>
          <th>Place</th>
          <th>Score</th>
          <th>Name</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(score, index) in orderedScores" v-bind:key="score.id">
          <td v-if="score.userScore">{{startPlacingAtOne(index)}}</td>
          <td>{{score.userScore}}</td>
          <td>{{score.name}}</td>
        </tr>




      </tbody>
    </table>
  </div>
</template>

<script>
import { db } from "../main";
import _ from "lodash";
import vueResponsive from "vue-responsive"

export default {
  props: ["numCorrect", "savedName", "timePoints"],
  data() {
    return {
      userScores: [
        {
          name: "",
          userScore: ""
        }
      ],
      name: "",
      userScore: 0
    };
  },
  created() {
    this.name = this.savedName;
    this.userScore = this.numCorrect;
    this.showScores();
  },
  computed: {
    orderedScores() {
      let userScores = this.uniqueNames(this.userScores);
      let ordered = _.orderBy(
        userScores,
        function(o) {
          return new Number(o.userScore);
        },
        ["desc"]
      );
      return ordered.slice(0, 10);
    }
  },

  methods: {
    addScore() {
      let name = JSON.stringify(this.name);
      let calculatedScore = this.userScore + this.timePoints;
      let userScore = JSON.stringify(calculatedScore);
      //loading start anim på knapp her (buttonloader)

      db.collection("userScores")
        .add({ name, userScore })
        .then(() => {
          console.log("Added score"); //legg til loading stopp her
        });
    },

    showScores() {
      db.collection("userScores").onSnapshot(res => {
        const changes = res.docChanges();

        changes.forEach(change => {
          if (change.type === "added") {
            this.userScores.push({
              ...change.doc.data()
            });
          }
        });
      });
    },

    uniqueNames(arrayName) {
      let uniqueNames = [];
      arrayName.map(user => {
        if (!uniqueNames.find(i => i.name === user.name) > 0) {
          uniqueNames.push(user);
        }
      });
      return uniqueNames;
    },
    startPlacingAtOne(index) {
      return index + 1;
    }
  }
};
</script>

<style scoped>
.answerScore{
  position:relative;
  left:5px;
}
.savedName{
  color:yellow;
  position:relative;
  left:10px;
}
.addedScore{
  position: relative;
  right:45px;
}
.yourScoreBig {
  color: whitesmoke;
  font-size: 20px;
  position: relative;
  left:45px;
}
#bigButton{
  position: relative;
  right:45px;
}


.yourScoreSmall{
  color:whitesmoke;
}
.savedNameSmall{
  color:yellow;
  position:relative;
  left:30px;
  top:40px;

}
.answerScoreSmall{
  position: relative;
  left:2px;
  bottom:23px;
}
.addedScoreSmall{
position:relative;
  left:7px;
  top:25px;
}


.btn{
  position:relative;
  top: 32px;
}
</style>