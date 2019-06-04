<template>
  <div>
    
    valgt tid:{{valgtTid}}
    <br />
    valgt dag:{{valgtDag}}
    <br />
    skriv inn leilighetsNR: <input type="text" id="leilighetInput" v-model="leilighetInput"/> <button @click="saveData()">Lagre</button>
    {{msg}}
    <button @click="console()">Console.log Opprett</button>
  </div>
</template>

<script>
  import axios from 'axios'

export default {
    name: 'OpprettVask',
    props: ['valgtTid', 'valgtDag', 'valgtLeilighet'],
  data () {
    return {
      msg: "",
      leilighetInput: "",
      isUpdated: false
    }
    },
    methods: {
      console() {
        console.log(" valgt tid/dag: " + this.valgtTid, this.valgtDag, this.valgtLeilighet)
      },
      saveData() {
        var vaskObj = {
          LeilighetsNR : this.leilighetInput,
          VaskStart : this.valgtTid,
          Dag: this.valgtDag,
          Varighet: 120
        }
        if (this.valgtLeilighet == undefined ) {
          axios.post('/api/vask', vaskObj)
            .then(function (response) {
              console.log('lagret ny vask: ', response)
              this.isUpdated = true
              this.$emit("sendUpdateToParent", this.isUpdated)
            })
            .catch(function (error) {
              console.log(error)
            })
        }
        else {
          this.msg ="Vennligest velg en ledig time for vask."
        }
       
        
      }
    }
}
</script>
