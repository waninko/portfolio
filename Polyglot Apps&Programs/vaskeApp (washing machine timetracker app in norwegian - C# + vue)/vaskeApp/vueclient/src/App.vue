<template>
  <div id="app">
    <Vaskeliste :key ="isUpdated"
    :valgtTid ="valgtTid"
    :isUpdated="isUpdated"
    v-on:sendTimeToParent="getTime"
    v-on:sendUpdateToParent="isUpdated = false"
                />

    <OpprettVask v-if="OpprettVask && !EndreVask"
     :valgtTid ="valgtTid"
     :valgtDag = "valgtDag"
     :valgtLeilighet = "valgtLeilighet"
     v-on:sendUpdateToParent="isUpdated = true"
                 />


    <EndreVask v-if="EndreVask " 
      :valgtTid ="valgtTid"
      :valgtDag = "valgtDag"
      :valgtLeilighet = "valgtLeilighet"
      :valgtVaskId = "valgtVaskId"
       v-on:sendUpdateToParent="isUpdated = true"
               />

    
    <button v-if="!OpprettVask && !EndreVask" @click="leggtilVask()">Sett opp Ny Vask</button>
    <button v-if="!EndreVask && !OpprettVask" @click="redigerVask()">Endre Vask</button> <br />
    <button v-if="OpprettVask || EndreVask" @click="tilOversikt()">Tilbake Til Oversikt</button>

  </div>
</template>

<script>
  import Vaskeliste from "./components/Vaskeliste.vue"
  import EndreVask from "./components/EndreVask.vue"
  import OpprettVask from "./components/OpprettVask.vue"


  export default {
    name: 'App',
    components: {
      Vaskeliste,
      EndreVask,
      OpprettVask
    },
    data() {
      return {
        EndreVask: false,
        OpprettVask: false,
        valgtTid: "testTid",
        valgtDag: "",
        valgtLeilighet: "",
        valgtVaskId: "",
        isUpdated: false

      };
    },
    methods: {
      redigerVask() {
        this.EndreVask = true
      },
      leggtilVask() {
        this.OpprettVask = true
      },
      tilOversikt() {
        this.EndreVask = false
        this.OpprettVask = false
      },
      getTime(tid, dag, valgtLeilighet, valgtVaskId) {
        this.valgtTid = tid
        this.valgtDag = dag
        this.valgtLeilighet = valgtLeilighet
        this.valgtVaskId = valgtVaskId
      }

    }
  }
</script>

<style>
  #app {
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
    margin-top: 60px;
  }
</style>
