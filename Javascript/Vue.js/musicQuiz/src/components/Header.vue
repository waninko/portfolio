<template>
  <div>
<h3><b>-=Music Quiz=- </b></h3>
     <b-progress v-if="numTotal" class="mt-2" :max="1" height="2.75rem"  show-value>
      <b-progress-bar  class="text-dark"  :value="numCorrect" variant="info" striped :animated="true"><h6><b>Current Success: {{ calculateScore }}</b></h6></b-progress-bar>
      <b-progress-bar :value="numWrong" variant="secondary"><h6><b>Number of Errors: {{ errorPercent }}</b></h6> </b-progress-bar>
      </b-progress> 

    <b-nav tabs align="center">
      <b-nav-item disabled><div  class="navItem">Questions Answered: {{ numTotal }}/10</div></b-nav-item>
      <b-nav-item disabled><div  class="navItem">Current Score: {{ numCorrect }} </div></b-nav-item>
       <b-nav-item disabled><div  class="navItem">Current Errors: {{ numWrong }}</div></b-nav-item>
    </b-nav>
    
  
    
  </div>
</template>

<script>
export default {
  props: [
    'numCorrect',
    'numWrong',
    'numTotal'
  ],
  data(){
    return {
      calculatedScore: null
    }
  },
   computed: {
  	calculateScore() {
      if(this.numCorrect > 0){
        return Math.round(parseInt(this.numCorrect) / parseInt(this.numTotal)* 100) + "%"
      }
      else return 0 + "%";
    	
    },
    errorPercent(){
      if(this.numWrong > 0){
        return Math.round(parseInt(this.numWrong) / parseInt(this.numTotal)* 100) + "%"
      }
       else return 0 + "%";
    }
  }
}
</script>

<style scoped>
.navbar{
  display: inline-block;
  vertical-align: top;
   text-align: center;
}
.navItem{
  color:whitesmoke;
}

</style>