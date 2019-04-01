<template>
  <div class="hello">
    <h1>Test av datamottak fra ASP</h1>
    <table>
      <tr>
        <th>ID</th>
        <th>NAME</th>
        <th>AGE</th>
      </tr>
      <tr v-for="person in people">
        <td>{{person.id}}</td>
        <td>{{person.name}}</td>
        <td>{{person.age}}</td>
      </tr>
    </table>
      
      

  </div>
</template>

<script>
  import axios from 'axios';

  

export default {
  name: 'HelloWorld',
  data () {
    return {
      people: []
    }
    },
    created: async function () {
      /* MÅTE 1
      const self = this;
      axios.get('/api/people')
        .then(function (response) {
          // handle success
          console.log(response.data);

          self.people.length = 0;
          self.people.push(...response.data);
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });*/

      //med TRY& CATCH (da kan vi bruke this!):
      try {
        const response = await axios.get('/api/people');
        console.log(response.data);
        this.people.length = 0;
        this.people.push(...response.data);
      }
      catch (e) {
        console.log(e);
      }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
