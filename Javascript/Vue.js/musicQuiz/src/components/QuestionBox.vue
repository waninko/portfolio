<template>
<div>
    <!-- <div class="bigQuestionbox" v-responsive="'hidden-xs'">
    <div class="question-box-container">
  <b-jumbotron bg-variant="secondary" text-variant="white" border-variant="dark">
    <template slot="lead" >
      <span v-html="currentQuestion.question"></span>
    </template>
    <hr class="my-4">
    <b-list-group class="questionText">
      <b-list-group-item 
      v-for="(answer, index) in shuffledAnswers" 
      :key="index"
      @click="selectAnswer(index)"
      :class="answerClass(index)"
      >
         <span v-html="answer"></span>
      </b-list-group-item>
    </b-list-group>
    <b-button variant="info"
    @click="submitAnswer"
    :disabled="selectedIndex === null 
    || answered">
    Submit Answer</b-button>
  </b-jumbotron>
  </div>
  </div> -->




  <div class="smallQuestionbox" v-responsive="['hidden-all','xs','sm']">
    <div class="question-box-container">
  <b-jumbotron id="smallJumbo" bg-variant="secondary" text-variant="white" border-variant="dark">
    <template slot="lead" >
      <!-- {{ currentQuestion.question }} span to avoid ascii issues-->
      <span v-html="currentQuestion.question"></span>
    </template>
    <hr class="my-4">
    <b-list-group class="questionText">
      <b-list-group-item 
      v-for="(answer, index) in shuffledAnswers" 
      :key="index"
      @click="selectAnswer(index)"
      :class="answerClass(index)"
      >
        <!-- {{ answer }} span to avoid ascii issues-->
         <span v-html="answer"></span>
      </b-list-group-item>
    </b-list-group>
    <b-button variant="info"
    @click="submitAnswer"
    :disabled="selectedIndex === null 
    || answered">
    Submit Answer</b-button>
  </b-jumbotron>
  </div>
</div>
</div>
</template>

<script >
import _ from 'lodash'
import vueResponsive from "vue-responsive"

export default{
  props: {
    currentQuestion: Object,
    next: Function,
    incrementCheckAndGetName: Function
  },
  data() {
    return {
      selectedIndex: null,
      correctIndex: null,
      shuffledAnswers: [],
      answered: false
    }
  },
  computed: {
    answers(){
      let answers = [...this.currentQuestion.incorrect_answers]
      answers.push(this.currentQuestion.correct_answer)
      return answers
    }
  },
  watch: {
    currentQuestion: {
      immediate: true,
      handler() {
        this.selectedIndex = null
        this.answered = false
        this.shuffleAnswers()
      }
      
    }
  },
  methods: {
    selectAnswer(index){
     this.selectedIndex = index
    },
    shuffleAnswers(){
       let answers = [...this.currentQuestion.incorrect_answers, this.currentQuestion.correct_answer]
       this.shuffledAnswers = _.shuffle(answers)
       this.correctIndex = this.shuffledAnswers.indexOf(this.currentQuestion.correct_answer)
    },
    submitAnswer(){
      let isCorrect = false
      if (this.selectedIndex === this.correctIndex) {
        isCorrect = true;
      }
      this.answered = true
      this.incrementCheckAndGetName(isCorrect)
      this.next()
    },
    answerClass(index){
      let answerClass = ''

      if(!this.answered && this.selectedIndex === index ){
        answerClass = 'selected'
      } 
      else if(this.answered && this.correctIndex === index){
          answerClass = 'correct'
      }
      else if(this.answered && this.selectedIndex == index && 
              this.correctIndex !== index){
        answerClass = 'incorrect'
      }
      return answerClass
     

      
    }
  }
}
</script>

<style scoped>
.list-group {
  margin-bottom: 15px;
}

.list-group-item:hover {
  background: lightblue;
  cursor: pointer;
}

.selected {
  background-color: lightblue;
}

.correct {
   background-color: lightgreen;
}

.incorrect {
   background-color: #f9665c;
}

.btn {
  margin: 0 5px;
}
.questionText{
  color: black;
}

#smallJumbo{
  height: 490px;
  width: 250px;;
  position: relative;
  top: 20px;
  right: 55px;
}
</style>