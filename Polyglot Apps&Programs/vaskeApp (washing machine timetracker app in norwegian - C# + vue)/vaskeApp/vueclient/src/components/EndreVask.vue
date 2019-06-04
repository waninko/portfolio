<template>
  <div>

    <br />
    {{nrMsg}}<br />
    <input type="text" v-model="leilighetsNR" /> <br /> <br />
    {{timeMsg}} <br />
    <input type="text" v-model="valgtDag" /> <br />
    <input type="text" v-model="valgtTid" /> <br />
    <button @click="saveChanges()">Lagre</button>
    <button @click="deleteSelected()">Slett Oppføring</button>
    
  </div>
</template> 


<script>
  import axios from 'axios'

export default {
    name: 'EndreVask',
    props: ['valgtTid', 'valgtDag', 'valgtLeilighet', 'valgtVaskId'],
  data () {
    return {
      nrMsg: "Tast inn leilighetsNR på nytt om behøvelig",
      timeMsg: "Velg Annet Tidspunkt og/eller dag i kalenderen om nødvendig",
      leilighetsNR: this.valgtLeilighet,
      isUpdated: false
    }
    },
    computed: {
      updatedChosenApartment() {
        return this.valgtLeilighet
      }
    },
    mounted() {
      console.log("vaskID fra props: " + this.valgtVaskId)
    },
  methods: {
    saveChanges() { 
      var url = '/api/vask/' + this.valgtVaskId
      console.log("dette er URL: " + url)
      console.log("leilighetsNR: " + this.leilighetsNR)

      var vaskeObj = {
        leilighetsNR: this.leilighetsNR,
        vaskStart: this.valgtTid,
        dag: this.valgtDag,
        varighet: 120
      }
      console.log("vaskeObj rett før axios: " + JSON.stringify(vaskeObj))

      axios.put(url, vaskeObj)
        
          .then(response => {
            console.log(response)
            this.isUpdated = true
            console.log("update status in update: ", this.isUpdated)
            this.$emit("sendUpdateToParent", this.isUpdated)
        })
        .catch(error => {
          if (error.response) {
            // The request was made and the server responded with a status code
            // that falls out of the range of 2xx
            console.log(error.response.data)
            console.log(error.response.status)
            console.log(error.response.headers)
          } else if (error.request) {
            // The request was made but no response was received
            console.log(error.request);
          } else {
            // Something happened in setting up the request that triggered an Error
            console.log('Error', error.message)
          }
          console.log(error.config)
          })
    },

    deleteSelected() {
      var url = '/api/vask/' + this.valgtVaskId
      axios.delete(url)
        .then(response => {
          console.log(response)
          this.isUpdated = true
          this.$emit("sendUpdateToParent", this.isUpdated)
          console.log("update status in delete: " , this.isUpdated)
        })
        .catch(error => {
          if (error.response) {
            // The request was made and the server responded with a status code
            // that falls out of the range of 2xx
            console.log(error.response.data)
            console.log(error.response.status)
            console.log(error.response.headers)
          } else if (error.request) {
            // The request was made but no response was received
            console.log(error.request);
          } else {
            // Something happened in setting up the request that triggered an Error
            console.log('Error', error.message)
          }
          console.log(error.config)
        })
    }
  }
}
</script>
